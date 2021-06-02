<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\tbWilayah;
use App\tbLingkungan;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesLingkunganController extends Controller
{
    public function index(){
        $lingkungan = tbLingkungan::where('idLingkungan','<>','0')
        ->orderBy('indek','asc')
        ->get();
        
        $jmlLingkungan = tbLingkungan::where('idLingkungan','<>','0')->count();
        
        return view('adPages.lingkungan.index',compact('lingkungan','jmlLingkungan'));
    }
    public function create(){
        $wilayah = tbWilayah::where('idWilayah','<>','0')
        ->orderBy('indek','asc')
        ->get();

        return view('adPages.lingkungan.tambah',compact('wilayah'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'wilayah' => 'required',
            'lingkungan' => 'required|unique:tb_lingkungan,nama',
            'pengamat' => 'required'
        ]);
        
        $lingkungan = new tbLingkungan;
        $lingkungan->idWilayah = $req->wilayah;
        $lingkungan->nama = $req->lingkungan;
        $lingkungan->pengamat = $req->pengamat;
        $lingkungan->indek = Sindata::indekLingkungan('mak')+1;
        $lingkungan->keterangan = $req->keterangan;
        $lingkungan->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah lingkungan '.$req->lingkungan.' ('.$req->pengamat.')';
        $history->ket = 'Modul lingkungan';
        $history->save();

        return redirect(route('adminLingkungan'))->with('sessPesanSindata','Data lingkungan berhasil disimpan.');
    }
    public function show($idLingkungan){
        $lingkungan = tbLingkungan::find($idLingkungan);
        $wilayah = tbWilayah::where('idWilayah','<>','0')
        ->orderBy('indek','asc')
        ->get();
        
        return view('adPages.lingkungan.tampil',compact('lingkungan','wilayah'));
    }
    public function edit(Request $req, $idLingkungan){
        if($req->lingkungan == $req->lingkunganHidden){
            $rule = [
                'wilayah' => 'required',
                'lingkungan' => 'required',
                'pengamat' => 'required'
            ];
        }else{
            $rule = [
                'wilayah' => 'required',
                'lingkungan' => 'required|unique:tb_lingkungan,nama',
                'pengamat' => 'required'
            ];
        }
        $this->validate($req, $rule);

        $lingkungan = tbLingkungan::find($idLingkungan);
        $lingkungan->idWilayah = $req->wilayah;
        $lingkungan->nama = $req->lingkungan;
        $lingkungan->pengamat = $req->pengamat;
        $lingkungan->keterangan = $req->keterangan;
        $lingkungan->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah lingkungan '.$req->lingkunganHidden.' ('.$req->pengamatHidden.') menjadi '.$req->lingkungan.' ('.$req->pengamat.')';
        $history->ket = 'Modul lingkungan';
        $history->save();

        return redirect(route('adminLingkungan'))->with('sessPesanSindata','Data lingkungan berhasil diubah.');  
    }
    public function delete(Request $req, $idLingkungan){
        $lingkunganHidden = tbLingkungan::find($idLingkungan);
        $lingkunganHid = $lingkunganHidden->nama;
        $pengamatHid = $lingkunganHidden->pengamat;

        $lingkungan = tbLingkungan::find($idLingkungan);
        $lingkungan->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus lingkungan '.$lingkunganHid.' ('.$pengamatHid.')';
        $history->ket = 'Modul lingkungan';
        $history->save();

        return redirect(route('adminLingkungan'))->with('sessPesanSindata','Data lingkungan berhasil dihapus.');
    }
    public function orderDown(Request $req, $idLingkungan){
        $lingkungan1 = tbLingkungan::find($idLingkungan);
        $idLingkungan1 = $lingkungan1->idLingkungan;

        $lingkungan2 = tbLingkungan::where('indek','>',$lingkungan1->indek)->orderBy('indek','asc')->first();
        $idLingkungan2 = $lingkungan2->idLingkungan;

        $indek1 = $lingkungan1->indek;
        $indek2 = $lingkungan2->indek;
        $indek3 = Sindata::indekLingkungan('mak')+1;

        $order1 = tbLingkungan::find($idLingkungan1);
        $order1->indek = $indek3;
        $order1->update();

        $order2 = tbLingkungan::find($idLingkungan2);
        $order2->indek = $indek1;
        $order2->update();

        $order3 = tbLingkungan::find($idLingkungan1);
        $order3->indek = $indek2;
        $order3->update();

        return redirect(route('adminLingkungan'));
    }
    public function orderUp(Request $req, $idLingkungan){
        $lingkungan1 = tbLingkungan::find($idLingkungan);
        $idLingkungan1 = $lingkungan1->idLingkungan;

        $lingkungan2 = tbLingkungan::where('indek','<',$lingkungan1->indek)->orderBy('indek','desc')->first();
        $idLingkungan2 = $lingkungan2->idLingkungan;

        $indek1 = $lingkungan1->indek;
        $indek2 = $lingkungan2->indek;
        $indek3 = Sindata::indekLingkungan('mak')+1;

        $order1 = tbLingkungan::find($idLingkungan1);
        $order1->indek = $indek3;
        $order1->update();

        $order2 = tbLingkungan::find($idLingkungan2);
        $order2->indek = $indek1;
        $order2->update();

        $order3 = tbLingkungan::find($idLingkungan1);
        $order3->indek = $indek2;
        $order3->update();

        return redirect(route('adminLingkungan'));
    }
}
