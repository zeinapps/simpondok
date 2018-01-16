<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Rombel;
use App\Models\Roleuser;
use App\Models\Master\MTingkat;
use App\Models\Master\TahunAjaran;
use Alert;


class RombelController extends Controller{
    use ControllerTrait;
    
    public function pilih(){ 
        
//        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
//        $tahun = [ '' => '--- Pilih ---'];
//        foreach ($tahun_ajaran as $value) {
//            $tahun[$value->id] = $value->nama;
//        }
//        return view('rombel/pilih_tahun', ['tahun' => $tahun]);
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->first();
        return redirect("admin/rombel/$tahun_ajaran->id");
    }
    
    public function storepilih(Request $request){ 
        return redirect("admin/rombel/$request->tahun");
    }
    
    public function index(Request $request, $tahun ){ 
        
        $tag = ['rombel'];
        $key = '_list_rombel';
        $s = '';
        
        $Mtingkat = MTingkat::get();
        $tingkat = [];
        foreach ($Mtingkat as $mt) {
            $tingkat[$mt->id] = $mt->nama . ' (' .$mt->keterangan .')';
        }
        $tingkat_id = isset($request->tingkat_id) ? $request->tingkat_id : $Mtingkat[0]->id;
        
        if($request->s){
            $s = $request->s;
            $model = Rombel::where('rombel.nama','like',"%$s%")
                    ->orwhere('rombel.keterangan','like',"%$s%");
        }else{
            $model = new Rombel();
        }
        $model = $model->where('tingkat_id',$tingkat_id);
        $model = $model->where('tahun_id',$tahun);
        $model = $model->with('wali');
        $model = $model->leftJoin('m_tingkat','rombel.tingkat_id','=','m_tingkat.id');
        $model = $model->select('rombel.*','m_tingkat.nama as tingkat');
        $result = $this->paginateFromCache($tag, $model, $key);
        
        $objtahun = $this->findFromCache($tahun, new TahunAjaran, ['m_tahun_ajaran']);
        
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
        $tahun_all = [ '' => '--- Pilih ---'];
        foreach ($tahun_ajaran as $value) {
            $tahun_all[$value->id] = $value->nama;
        }
        
        $data = [
            'data' => $result, 
            's' => $s, 
            'tahun' => $objtahun,
            'tahun_all' => $tahun_all,
            'tingkat' => $tingkat,
            'tingkat_id' => $tingkat_id,
            ];
        
        return view('rombel/index', $data );
        
        
    }
    
    public function store(Request $request, $tahun){ 
        $validator = Validator::make($request->all(), [
            'tingkat_id' => 'required',
            'tahun_id' => 'required',
            'nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        try {
            if(!$request->id){
                $new_data = Rombel::create($request->all());
            }else{
                $new_data = Rombel::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            Alert::danger("Terjadi masalah pada database");
            
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('rombel');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.rombel.index',['tahun' => $tahun,'tingkat_id' => $request->tingkat_id]);
        
    }
    
    public function edit($tahun, $id){
        $query = Rombel::find($id)->toArray();
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new MTingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        $gurus = Roleuser::with('user')->where('role_id',config('app.role.guru'))->get();
        $guru = [];
        foreach ($gurus as $value) {
            $guru[$value->user_id] =  $value->user->name;
        }
        return view('rombel/form', array_merge($query, ['tingkat_all' => $tingkat, 'guru' => $guru, 'tahun_id' => $tahun]));
    }
    
    public function add($tahun){ 
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new MTingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        
        $gurus = Roleuser::with('user')->where('role_id',config('app.role.guru'))->get();
        $guru = [];
        foreach ($gurus as $value) {
            $guru[$value->user_id] =  $value->user->name;
        }
        return view('rombel/form',['tingkat_all' => $tingkat, 'guru' => $guru, 'tahun_id' => $tahun]);
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        if($role){
            $role->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
}