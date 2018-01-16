<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ControllerTrait;
use App\Models\TingkatMapel;
use App\Models\Master\Mapel;
use App\Models\Master\MTingkat;
use App\Models\Master\TahunAjaran;
use Alert;
use Validator;

class TingkatMapelController extends Controller{
    use ControllerTrait;
    
    public function pilih(){ 
        
//        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
//        $tahun = [ '' => '--- Pilih ---'];
//        foreach ($tahun_ajaran as $value) {
//            $tahun[$value->id] = $value->nama;
//        }
//        return view('tingkat_mapel/pilih_tahun', ['tahun' => $tahun]);
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->first();
        return redirect("admin/tingkat_mapel/$tahun_ajaran->id");
    }
    
    public function storepilih(Request $request){ 
        return redirect("admin/tingkat_mapel/$request->tahun");
    }
    
    public function index(Request $request, $tahun_id){ 
        
        $Mtingkat = MTingkat::get();
        $tingkat = [];
        foreach ($Mtingkat as $mt) {
            $tingkat[$mt->id] = $mt->nama . ' (' .$mt->keterangan .')';
        }
        
        $tingkat_id = isset($request->tingkat_id) ? $request->tingkat_id : $Mtingkat[0]->id;
        
        $mapel_tingkat = TingkatMapel::join('m_mapel','tingkat_mapel.mapel_id','=','m_mapel.id')
                ->where('tingkat_id',$tingkat_id)
                ->where('tahun_id',$tahun_id)
                ->get();
        $mapel_t = [];
        foreach ($mapel_tingkat as $value) {
            $mapel_t[] = $value->mapel_id;
        }
        $mapel = Mapel::whereNotIn('id',$mapel_t)->get();
        
        $objtahun = $this->findFromCache($tahun_id, new TahunAjaran, ['m_tahun_ajaran']);
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
        $tahun_all = [ '' => '--- Pilih ---'];
        foreach ($tahun_ajaran as $value) {
            $tahun_all[$value->id] = $value->nama;
        }
        
        $data = [
                'mapel' => $mapel,
                'mapel_tingkat' => $mapel_tingkat,
                'tingkat_id'=> $tingkat_id,
                'tingkat' => $tingkat,
                'tahun' => $objtahun,
                'tahun_all' => $tahun_all,
            ];
        return view('tingkat_mapel/index', $data);
    }
    
    public function store(Request $request, $tahun_id){ 
        
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
            if(!TingkatMapel::where('tingkat_id',$request->tingkat_id)
                    ->where('tahun_id', $tahun_id)
                    ->where('mapel_id',$m)->first()){
                $tingkat->mapels()->attach($m,['tahun_id'=>$tahun_id]);
            }
        }
        return redirect()->route('permission.tingkat_mapel.index', ['tahun_id'=>$tahun_id,'tingkat_id' => $request->tingkat_id]);
    }
    
    public function delete(Request $request,$tahun_id){ 
        
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
            $tingkat->mapels()->wherePivot('tahun_id', $tahun_id)->detach($request->mapel);
        }
        return redirect()->route('permission.tingkat_mapel.index', ['tahun_id'=>$tahun_id,'tingkat_id' => $request->tingkat_id]);
    }
    
}