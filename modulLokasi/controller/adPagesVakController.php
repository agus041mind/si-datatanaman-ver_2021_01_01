<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\tbLingkungan;
use App\tbVak;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesVakController extends Controller
{
    public function index(){
        $vak = tbVak::orderBy('indek','asc')
        ->get();
        
        $jmlVak = tbVak::count();
        
        return view('adPages.vak.index',compact('vak','jmlVak'));
    }
    public function create(){
        $lingkungan = tbLingkungan::where('idLingkungan','<>','0')
        ->orderBy('indek','asc')
        ->get();

        return view('adPages.vak.tambah',compact('lingkungan'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'lingkungan' => 'required',
            'vak' => 'required|unique:tb_vak,nama',
            'perawat' => 'required'
        ]);
        
        $vak = new tbVak;
        $vak->idLingkungan = $req->lingkungan;
        $vak->nama = $req->vak;
        $vak->perawat = $req->perawat;
        $vak->indek = Sindata::indekVak('mak')+1;
        $vak->keterangan = $req->keterangan;
        $vak->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah vak '.$req->vak.' ('.$req->perawat.')';
        $history->ket = 'Modul vak';
        $history->save();

        return redirect(route('adminVak'))->with('sessPesanSindata','Data vak berhasil disimpan.');
    }
    public function show($idVak){
        $vak = tbVak::find($idVak);
        $lingkungan = tbLingkungan::where('idLingkungan','<>','0')
        ->orderBy('indek','asc')
        ->get();
        
        return view('adPages.vak.tampil',compact('vak','lingkungan'));
    }
    public function edit(Request $req, $idVak){
        if($req->vak == $req->vakHidden){
            $rule = [
                'lingkungan' => 'required',
                'vak' => 'required',
                'perawat' => 'required'
            ];
        }else{
            $rule = [
                'lingkungan' => 'required',
                'vak' => 'required|unique:tb_vak,nama',
                'perawat' => 'required'
            ];
        }
        $this->validate($req, $rule);

        $vak = tbVak::find($idVak);
        $vak->idLingkungan = $req->lingkungan;
        $vak->nama = $req->vak;
        $vak->perawat = $req->perawat;
        $vak->keterangan = $req->keterangan;
        $vak->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah vak '.$req->vakHidden.' ('.$req->perawatHidden.') menjadi '.$req->vak.' ('.$req->perawat.')';
        $history->ket = 'Modul vak';
        $history->save();

        return redirect(route('adminVak'))->with('sessPesanSindata','Data vak berhasil diubah.');  
    }
    public function delete(Request $req, $idVak){
        $vakHidden = tbVak::find($idVak);
        $vakHid = $vakHidden->nama;
        $perawatHid = $vakHidden->perawat;

        $vak = tbVak::find($idVak);
        $vak->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus vak '.$vakHid.' ('.$perawatHid.')';
        $history->ket = 'Modul vak';
        $history->save();

        return redirect(route('adminVak'))->with('sessPesanSindata','Data vak berhasil dihapus.');
    }
    public function orderDown(Request $req, $idVak){        
        $vak1 = tbVak::find($idVak);
        $idVak1 = $vak1->idVak;

        $vak2 = tbVak::where('indek','>',$vak1->indek)->orderBy('indek','asc')->first();
        $idVak2 = $vak2->idVak;
   
        $indek1 = $vak1->indek;
        $indek2 = $vak2->indek;
        $indek3 = Sindata::indekVak('mak')+1;

        $order1 = tbVak::find($idVak1);
        $order1->indek = $indek3;
        $order1->update();
        
        $order2 = tbVak::find($idVak2);
        $order2->indek = $indek1;
        $order2->update();

        $order3 = tbVak::find($idVak1);
        $order3->indek = $indek2;
        $order3->update();

        return redirect(route('adminVak'));
    }
    public function orderUp(Request $req, $idVak){
        $vak1 = tbVak::find($idVak);
        $idVak1 = $vak1->idVak;

        $vak2 = tbVak::where('indek','<',$vak1->indek)->orderBy('indek','desc')->first();
        $idVak2 = $vak2->idVak;

        $indek1 = $vak1->indek;
        $indek2 = $vak2->indek;
        $indek3 = Sindata::indekVak('mak')+1;

        $order1 = tbVak::find($idVak1);
        $order1->indek = $indek3;
        $order1->update();

        $order2 = tbVak::find($idVak2);
        $order2->indek = $indek1;
        $order2->update();

        $order3 = tbVak::find($idVak1);
        $order3->indek = $indek2;
        $order3->update();

        return redirect(route('adminVak'));
    }
}
