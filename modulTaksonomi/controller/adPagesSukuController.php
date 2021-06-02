<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbOrdo;
use App\tbSuku;
use App\tbMarga;
use App\tbJenis;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesSukuController extends Controller
{
    public function index(){
        $suku = tbSuku::where('nama','<>','')
        ->orderBy('updated_at','desc')
        ->get(); 
        
        return view('adPages.suku.index',compact('suku'));
    }
    public function create(){
        $ordo = tbOrdo::where('idKelas','<>','0')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.suku.tambah',compact('ordo'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'bangsa' => 'required',
            'suku' => 'required|max:40|unique:tb_suku,nama',
            'singkatan' => 'max:25'
        ]);
   
        $idSukuBaru = Sindata::idSukuBaru();
        $idMargaBaru = Sindata::idMargaBaru();
        $idJenisBaru = Sindata::idJenisBaru();
        
        $suku = new tbSuku;
        $suku->idSuku = $idSukuBaru;
        $suku->idOrdo = $req->bangsa;
        $suku->nama = $req->suku;
        $suku->singkatan = $req->singkatan;
        $suku->save();

        $marga = new tbMarga;
        $marga->idMarga = $idMargaBaru;
        $marga->idSuku = $idSukuBaru;
        $marga->nama = "Gendub";
        $marga->save();

        $jenis = new tbJenis;
        $jenis->idJenis = $idJenisBaru;
        $jenis->idMarga = $idMargaBaru;
        $jenis->idAuthorJenis = "A0";
        $jenis->idAuthorSubJenis = "A0";
        $jenis->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah suku '.$req->suku;
        $history->ket = 'Modul suku';
        $history->save();

        return redirect(route('adminSuku'))->with('sessPesanSindata','Data suku berhasil disimpan.'); 
    }
    public function show($idSuku){
        $suku = tbSuku::find($idSuku);

        $ordo = tbOrdo::where('idKelas','<>','0')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.suku.tampil',compact('suku','ordo'));
    }
    public function edit(Request $req, $idSuku){
        if($req->suku <> $req->sukuHidden){
            $rule = [
                'bangsa' => 'required',
                'suku' => 'required|max:40|unique:tb_suku,nama',
                'singkatan' => 'max:25'
            ];
        }else{
            $rule = [
                'bangsa' => 'required',
                'suku' => 'required|max:40',
                'singkatan' => 'max:25'
            ];
        }
        $this->validate($req, $rule);

        $suku = tbSuku::find($idSuku);
        $suku->idOrdo = $req->bangsa;
        $suku->nama = $req->suku;
        $suku->singkatan = $req->singkatan;
        $suku->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah suku '.$req->sukuHidden.' menjadi '.$req->suku;
        $history->ket = 'Modul suku';
        $history->save();

        return redirect(route('adminSuku'))->with('sessPesanSindata','Data suku berhasil diubah.');                
    }
    public function delete(Request $req, $idSuku){
        $sukuHidden = tbSuku::find($idSuku);
        $sukuHid = $sukuHidden->nama;

        $suku = tbSuku::find($idSuku);
        $suku->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus suku '.$sukuHid;
        $history->ket = 'Modul suku';
        $history->save();

        return redirect(route('adminSuku'))->with('sessPesanSindata','Data suku berhasil dihapus.');        
    }
}
