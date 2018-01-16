<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ControllerTrait;
use App\Models\RombelSiswa;
use App\Models\Master\TahunAjaran;
use App\Models\Master\MTingkat;
use App\Models\TingkatMapel;
use App\Models\SiswaNilai;
use App\Models\Rombel;
use Alert;
use Validator;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class SiswaNilaiController extends Controller{
    use ControllerTrait;
    
    public function pilih(){ 
        
//        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
//        $tahun = [ '' => '--- Pilih ---'];
//        foreach ($tahun_ajaran as $value) {
//            $tahun[$value->id] = $value->nama;
//        }
//        return view('rombel_siswa/pilih_tahun', ['tahun' => $tahun]);
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->first();
        return redirect("admin/siswa_nilai/$tahun_ajaran->id");
    }
    
    public function storepilih(Request $request){ 
        return redirect("admin/siswa_nilai/$request->tahun");
    }
    
    public function index(Request $request, $tahun_id){ 
        
        $Mtingkat = MTingkat::get();
        $tingkat = [];
        foreach ($Mtingkat as $mt) {
            $tingkat[$mt->id] = $mt->nama . ' (' .$mt->keterangan .')';
        }
        $tingkat_id = isset($request->tingkat_id) ? $request->tingkat_id : $Mtingkat[0]->id;
        
        
        $Rombels = Rombel::where('tahun_id',$tahun_id)->where('tingkat_id',$tingkat_id)->get();
        $rombel = [];
        $rt = [];
        foreach ($Rombels as $mt) {
            $rombel[$mt->id] = $mt->nama ;
            $rt[] = $mt->id;
        }
        if($request->rombel_id){
            if(in_array($request->rombel_id, $rt)){
                $rombel_id = $request->rombel_id;
            }else{
                $rombel_id = isset($rt[0]) ? $rt[0] : null ;
            }
        }else{
            $rombel_id = isset($rt[0]) ? $rt[0] : null ;
        }
        
        $tingkat_mapels = TingkatMapel::join('m_mapel','tingkat_mapel.mapel_id','=','m_mapel.id')
                ->where('tingkat_id',$tingkat_id)
                ->where('tahun_id',$tahun_id)
                ->get();
        $tingkat_mapel = [];
        $rm = [];
        foreach ($tingkat_mapels as $mp) {
            $tingkat_mapel[$mp->id] = $mp->nama ;
            $rm[] = $mp->id;
        }
        if($request->tingkat_mapel_id){
            if(in_array($request->tingkat_mapel_id, $rm)){
                $tingkat_mapel_id = $request->tingkat_mapel_id;
            }else{
                $tingkat_mapel_id = isset($rm[0]) ? $rm[0] : null ;
            }
        }else{
            $tingkat_mapel_id = isset($rm[0]) ? $rm[0] : null ;
        }
        
        $rombel_siswa = RombelSiswa::leftjoin('siswa','rombel_siswa.siswa_id','=','siswa.id')
                ->select('siswa.nama as nama','siswa.nomor_induk','rombel_siswa.siswa_id as siswa_id','siswa_nilai.nilai')
                ->leftJoin('siswa_nilai', function($query) use ($tingkat_mapel_id){
//                    $query->select('siswa_id','nilai')
//                    ->from('siswa_nilai')
                    $query->on('rombel_siswa.siswa_id','=','siswa_nilai.siswa_id')
                    ->where('tingkat_mapel_id', $tingkat_mapel_id);
                })
                ->where('rombel_siswa.rombel_id', $rombel_id)
//                ->where('siswa_nilai.tingkat_mapel_id', $tingkat_mapel_id)
                ->orderBy('siswa.nama', 'ASC')
                ->get()
                ;
//        dd($rombel_siswa);
        $objtahun = $this->findFromCache($tahun_id, new TahunAjaran, ['m_tahun_ajaran']);
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
        $tahun_all = [ '' => '--- Pilih ---'];
        foreach ($tahun_ajaran as $value) {
            $tahun_all[$value->id] = $value->nama;
        }
        
        
        $data = [
                'rombel_siswa' => $rombel_siswa,
                'rombel_id'=> $rombel_id,
                'rombel' => $rombel,
                'tingkat_id'=> $tingkat_id,
                'tingkat' => $tingkat,
                'tingkat_mapel_id'=> $tingkat_mapel_id,
                'tingkat_mapel' => $tingkat_mapel,
                'tahun' => $objtahun,
                'tahun_all' => $tahun_all,
            ];
        return view('siswa_nilai/index', $data);
    }
    
    public function store(Request $request,$tahun){ 
        
        $validator = Validator::make($request->all(), [
            'rombel_id' => 'required',
            'tingkat_id' => 'required',
            'tingkat_mapel_id' => 'required',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        $tingkat_mapel_id = $request->tingkat_mapel_id;
//        dd($request->nilai);
        foreach ($request->nilai as $siswa_id => $nilai) {
            $nilai = $nilai ? $nilai : 0;
            if($siswa_nilai = SiswaNilai::where('tingkat_mapel_id',$tingkat_mapel_id)->where('siswa_id',$siswa_id)->first()){
                $siswa_nilai->update([
                    'nilai' => $nilai ? $nilai : 0,
                ]);
            }else{
                SiswaNilai::create([
                    'siswa_id' => $siswa_id,
                    'nilai' => $nilai,
                    'tingkat_mapel_id' => $tingkat_mapel_id,
                ]);
            }
        }
        $data = [
            'tahun' => $tahun,
            'rombel_id'=>$request->rombel_id,
            'tingkat_id'=>$request->tingkat_id,
            'tingkat_mapel_id' => $tingkat_mapel_id,
            ];
        return redirect()->route('permission.siswa_nilai.index', $data);
    }
    
    public function export_presensi($tahun_id,$rombel_id){ 
        
        $rombel = Rombel::find($rombel_id);
        $tingkat = $rombel->tingkat;
        $title = [
            'Nomer',
            'NIS',
            'Nama Lenngkap',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            ];
        
        $fileName = "KELAS $tingkat->nama $rombel->nama.xlsx";
        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
       
        $rombel_siswa = RombelSiswa::join('siswa','rombel_siswa.siswa_id','=','siswa.id')
                ->where('rombel_id',$rombel_id)
                ->orderBy('siswa.nama', 'ASC')
                ->get();
        
        $writer->openToBrowser($fileName); // stream data directly to the browser
        $writer->addRow($title); // tambahkan judul dibaris pertama
        $no=0;
        foreach ($rombel_siswa as $data) {
            $no++;
            $siswa = [
                'no' => $no,
                'induk' => $data->no_induk,
                'nama' => $data->nama,
                '1' => "",
                '2' => "",
                '3' => "",
                '4' => "",
                '5' => "",
                '6' => "",
            ];
            $writer->addRow($siswa); // tambakan data data per baris
        }
        $writer->close();
    }
    
    
}