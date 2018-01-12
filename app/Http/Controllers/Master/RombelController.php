<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\MRombel;
use App\Models\Master\MTingkat;
use Alert;


class RombelController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['m_rombel'];
        $key = '_list_m_rombel';
        $s = '';
        
        $Mtingkat = MTingkat::get();
        $tingkat = [];
        foreach ($Mtingkat as $mt) {
            $tingkat[$mt->id] = $mt->nama . ' (' .$mt->keterangan .')';
        }
        $tingkat_id = isset($request->tingkat_id) ? $request->tingkat_id : $Mtingkat[0]->id;
        
        if($request->s){
            $s = $request->s;
            $model = MRombel::where('m_rombel.nama','like',"%$s%")
                    ->orWhere('m_rombel.keterangan','like',"%$s%");
        }else{
            $model = new MRombel();
        }
        $model = $model->where('tingkat_id',$tingkat_id);
        $model = $model->leftJoin('m_tingkat','m_rombel.tingkat_id','=','m_tingkat.id');
        $model = $model->select('m_rombel.*','m_tingkat.nama as tingkat');
        $result = $this->paginateFromCache($tag, $model, $key);
        
        $data = [
            'data' => $result,
            's' => $s,
            'tingkat' => $tingkat,
            'tingkat_id' => $tingkat_id,
            ];
        return view('master/rombel/index', $data);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'tingkat_id' => 'required',
            'nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        try {
            if(!$request->id){
                $new_data = MRombel::create($request->all());
            }else{
                $new_data = MRombel::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            Alert::danger("Terjadi masalah pada database");
            
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('m_rombel');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.mrombel.index');
        
    }
    
    public function edit($id){
        $query = MRombel::find($id)->toArray();
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new MTingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/rombel/form', array_merge($query, ['tingkat_all' => $tingkat]));
    }
    
    public function add(){ 
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new MTingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/rombel/form',array_merge(['tingkat_all' => $tingkat], []));
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