<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ControllerTrait;
use App\Models\RombelSiswa;
use App\Models\Master\TahunAjaran;
use App\Models\Master\MTingkat;
use App\Models\Siswa;
use App\Models\Rombel;
use Alert;
use Validator;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class RombelSiswaController extends Controller{
    use ControllerTrait;
    
    public function pilih(){ 
        
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
        $tahun = [ '' => '--- Pilih ---'];
        foreach ($tahun_ajaran as $value) {
            $tahun[$value->id] = $value->nama;
        }
        return view('rombel_siswa/pilih_tahun', ['tahun' => $tahun]);
        
    }
    
    public function storepilih(Request $request){ 
        return redirect("admin/rombel_siswa/$request->tahun");
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
//        $rombel_id = isset($request->rombel_id) ? (in_array($request->rombel_id, $rombel) ? $request->rombel_id : $Rombels[0]->id ) : null;
        
        $rombel_siswa = RombelSiswa::join('siswa','rombel_siswa.siswa_id','=','siswa.id')
                ->where('rombel_id',$rombel_id)
                ->orderBy('siswa.nama', 'ASC')
                ->get();
        $siswa_t = [];
        foreach ($rombel_siswa as $value) {
            $siswa_t[] = $value->siswa_id;
        }
        $siswa = Siswa::where('is_lulus','0')
                ->whereNotIn('id', function($query) use ($tahun_id){
                    $query->select('rombel_siswa.siswa_id')
                    ->from('rombel_siswa')
                    ->leftJoin( 'rombel', 'rombel_siswa.rombel_id', '=', 'rombel.id' )
                    ->where('rombel.tahun_id', $tahun_id);
                })
                ->where('tingkat_id',$tingkat_id)
                ->orderBy('siswa.nama', 'ASC')
                ->get();
        
        $objtahun = $this->findFromCache($tahun_id, new TahunAjaran, ['m_tahun_ajaran']);
        $tahun_ajaran = TahunAjaran::orderBy('id',"DESC")->get();
        $tahun_all = [ '' => '--- Pilih ---'];
        foreach ($tahun_ajaran as $value) {
            $tahun_all[$value->id] = $value->nama;
        }
        $data = [
                'siswa' => $siswa,
                'rombel_siswa' => $rombel_siswa,
                'rombel_id'=> $rombel_id,
                'rombel' => $rombel,
                'tingkat_id'=> $tingkat_id,
                'tingkat' => $tingkat,
                'tahun' => $objtahun,
                'tahun_all' => $tahun_all,
            ];
        return view('rombel_siswa/index', $data);
    }
    
    public function store(Request $request,$tahun){ 
        
        $validator = Validator::make($request->all(), [
            'rombel_id' => 'required',
            'siswa' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        $rombel = Rombel::find($request->rombel_id);
        foreach ($request->siswa as $s) {
            if(!RombelSiswa::where('rombel_id',$request->rombel_id)->where('siswa_id',$s)->first()){
                $rombel->siswa()->attach($s);
            }
        }
        $data = [
            'tahun' => $tahun,
            'rombel_id'=>$request->rombel_id,
            'tingkat_id'=>$rombel->tingkat_id
            ];
        return redirect()->route('permission.rombel_siswa.index', $data);
    }
    
    public function delete(Request $request, $tahun){ 
        
        $validator = Validator::make($request->all(), [
            'rombel_id' => 'required',
            'siswa' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        $rombel = Rombel::find($request->rombel_id);
        if($request->siswa){
            $rombel->siswa()->detach($request->siswa);
        }
        $data = [
            'tahun' => $tahun,
            'rombel_id'=>$request->rombel_id,
            'tingkat_id'=>$rombel->tingkat_id
            ];
        return redirect()->route('permission.rombel_siswa.index', $data);
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