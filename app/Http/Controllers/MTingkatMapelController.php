<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ControllerTrait;
use App\Models\MTingkatMapel;
use App\Models\Master\Mapel;
use App\Models\Master\MTingkat;
use Alert;
use Validator;

class MTingkatMapelController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        
        $Mtingkat = MTingkat::get();
        $tingkat = [];
        foreach ($Mtingkat as $mt) {
            $tingkat[$mt->id] = $mt->nama . ' (' .$mt->keterangan .')';
        }
        
        $tingkat_id = isset($request->tingkat_id) ? $request->tingkat_id : $Mtingkat[0]->id;
        
        $mapel_tingkat = MTingkatMapel::join('m_mapel','m_tingkat_mapel.mapel_id','=','m_mapel.id')
                ->where('tingkat_id',$tingkat_id)
                ->get();
        $mapel_t = [];
        foreach ($mapel_tingkat as $value) {
            $mapel_t[] = $value->mapel_id;
        }
        $mapel = Mapel::whereNotIn('id',$mapel_t)->get();
        $data = [
                'mapel' => $mapel,
                'mapel_tingkat' => $mapel_tingkat,
                'tingkat_id'=> $tingkat_id,
                'tingkat' => $tingkat,
            ];
        return view('master/tingkat_mapel/index', $data);
    }
    
    public function store(Request $request){ 
        
        $validator = Validator::make($request->all(), [
            'tingkat_id' => 'required',
            'mapel' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        $tingkat = MTingkat::find($request->tingkat_id);
        foreach ($request->mapel as $m) {
            if(!MTingkatMapel::where('tingkat_id',$request->tingkat_id)->where('mapel_id',$m)->first()){
                $tingkat->mapels_default()->attach($m);
            }
        }
        return redirect()->route('permission.m_tingkat_mapel.index', ['tingkat_id' => $request->tingkat_id]);
    }
    
    public function delete(Request $request){ 
        
        $validator = Validator::make($request->all(), [
            'tingkat_id' => 'required',
            'mapel' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        $tingkat = MTingkat::find($request->tingkat_id);
        if($request->mapel){
            $tingkat->mapels_default()->detach($request->mapel);
        }
        return redirect()->route('permission.m_tingkat_mapel.index', ['tingkat_id' => $request->tingkat_id]);
    }
    
}