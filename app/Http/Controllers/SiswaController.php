<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\MTingkat;
use App\Models\Siswa;
use App\Models\SiswaInfo;
use Alert;
use DB;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class SiswaController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['siswa'];
        $key = '_list_siswa';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Siswa::where('nama','like',"%$s%");
        }else{
            $model = new Siswa();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('siswa/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        $param_siswa = [
            'nama' => $request->nama,
            'is_lulus' => $request->is_lulus,
            'tingkat_id' => $request->tingkat_id,
            'nomor_induk' => $request->nomor_induk?$request->nomor_induk:null,
        ];
                
        DB::beginTransaction();
        try {
            
            if(!$request->id){
                $siswa_id = Siswa::create($param_siswa)->id;
            }else{
                Siswa::find($request->id)
                        ->update($param_siswa);
                $siswa_id = $request->id;
            }


            $param_info = $request->all();
            $siswaInfo = SiswaInfo::where('siswa_id',$siswa_id)->first();
            if(!$siswaInfo){
                SiswaInfo::create(array_merge($param_info,['siswa_id' => $siswa_id]));
            }else{
                $siswaInfo->update($param_info);
            }
                
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $errorCode = $e->errorInfo[1];          
            if($errorCode == 1062){
                Alert::danger("Nomer Induk Tidak boleh sama");
            }else{
                Alert::danger("Terjadi masalah pada database");
            }
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        
        $this->clearCache('siswa','siswa_info');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.siswa.index');
        
    }
    
    public function edit($id){
        $query = Siswa::find($id)->toArray();
        $siswaInfo = SiswaInfo::where('siswa_id',$id)->first()->toArray();

        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new MTingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        
        return view('siswa/form', array_merge($query, $siswaInfo,['tingkat_all' => $tingkat]));
    }
    
    public function add(){ 
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new MTingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('siswa/form',['tingkat_all' => $tingkat]);
    }
    
    public function delete($id){ 
        $siswa = Siswa::find($id);
        if($siswa){
            $siswa->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
    public function formupload(){ 
        return view('siswa/formupload');
    }
    
    public function uploadexcel(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        $file = $request->file->path();// get file
        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        $reader->open($file);
               
        $data_error = 0;   
        $data_valid = 0;

        $is_submit = true;
        $AllNewSiswa = [];
        foreach ($reader->getSheetIterator() as $sheet) {
            $new_siswa = [];
            $row_0 = true;
            
            foreach ($sheet->getRowIterator() as $row) {
                //lompati kolom
                if($row_0){
                    $row_0 = false;
                    continue;
                }
                $class = "success";
                $validator = Validator::make($row, [
                    0 => 'required',
                    1 => 'required|integer|min:0',
                    2 => 'max:255',
                    3 => 'max:50',
                    4 => 'date_format:d-m-Y',
                ]);
                $message = "OK";
                if ($validator->fails()) {
                    $message = json_encode($validator->errors()->toArray());
                    $class = "danger";
                    $is_submit = false;
                    $data_error++;
                }else{
                    $data_valid++;
                }
                
                
                $new_siswa = [
                    'nama' => trim($row[0]),
                    'nomor_induk' => trim($row[1]),
                    'alamat' => trim($row[2]),
                    'tempat_lahir' => trim($row[3]),
                    'tanggal_lahir' => trim($row[4]),
                    'class' => $class,
                    'message' => $message,
                ];
                $AllNewSiswa[] = $new_siswa;
                
            }
        }
        $reader->close();
        
        if(count($AllNewSiswa) == 0){
            Alert::danger("Tidak ditemukan data yang valid");
            return back();
        }
        
        $max_upload = 100;
        if(count($AllNewSiswa) > $max_upload){
            Alert::danger("Maksimal Upload $max_upload akun");
            return back();
        }
        
        if($is_submit){
            Alert::success("$data_valid data Valid Semua");
        }else{
            Alert::danger("$data_error data yang tidak valid, silahkan diperbaiki lagi");
        }
        return view('siswa/previewupload',['data' => $AllNewSiswa,'is_submit' => $is_submit]);
    
    }

    public function storeupload(Request $request){ 
     
        $nama = $request->nama;
        $nomor_induk = $request->nomor_induk;
        $alamat = $request->alamat ;
        $tanggal_lahir = $request->tanggal_lahir;
        $tempat_lahir = $request->tempat_lahir;
        
        DB::beginTransaction();
        try {
            
            foreach ($nama as $key => $v) {
                $param = [
                    'nama' => $nama[$key],
                    'nomor_induk' => $nomor_induk[$key],
                ];
                $siswa_id = Siswa::create($param)->id;
            
                $param_info = [
                    'siswa_id' => $siswa_id,
                    'alamat' => $alamat[$key],
                    'tanggal_lahir' => date("Y-m-d", strtotime($tanggal_lahir[$key])),
                    'tempat_lahir' => $tempat_lahir[$key],
                ];
                SiswaInfo::create($param_info);
            } 

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::danger("Terjadi masalah pada database");
            return redirect()->route('permission.siswa.formupload');
        }
        
        $this->clearCache('siswa','siswa_info');
        Alert::success('Import Data berhasil');
        return redirect()->route('permission.siswa.index');
        
    }
}