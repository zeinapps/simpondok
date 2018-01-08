<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
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

        return view('siswa/form', array_merge($query, $siswaInfo));
    }
    
    public function add(){ 
        return view('siswa/form');
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
        $file = $request->file->path();// get file
        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        $reader->open($file);
               
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
                if(strlen(trim($row[0])) == 0){
                    $class = "danger";
                    $is_submit = false;
                }
                $new_siswa = [
                    'nama' => trim($row[0]),
                    'nomor_induk' => trim($row[1]),
                    'alamat' => trim($row[2]),
                    'tempat_lahir' => trim($row[3]),
                    'tanggal_lahir' => trim($row[4]),
                    'class' => $class,
                ];
                $AllNewSiswa[] = $new_siswa;
                
            }
        }
        $reader->close();
        
        if(count($AllNewSiswa) == 0){
            Alert::danger("Tidak ditemukan data yang valid");
            return back();
        }
        
        $max_upload = 1000;
        if(count($AllNewSiswa) > $max_upload){
            Alert::danger("Maksimal Upload $max_upload akun");
            return back();
        }
        if($is_submit){
            Alert::success('Add/Update Data berhasil');
        }else{
            Alert::danger('Ada beberapa data yang tidak valid, silahkan diperbaiki lagi');
        }
        return view('siswa/previewupload',['data' => $AllNewSiswa,'is_submit' => $is_submit]);
    
    }

}