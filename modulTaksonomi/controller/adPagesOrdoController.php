<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbKelas;
use App\tbOrdo;
use App\tbHistory;

class adPagesOrdoController extends Controller
{
    public function index(){
        $ordo = tbOrdo::where('nama','<>','')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.ordo.index',compact('ordo'));
    }
    public function create(){
        $kelas = tbKelas::where('idSubDivisi','<>','0')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.ordo.tambah',compact('kelas'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'kelas' => 'required',
            'bangsa' => 'required|max:30|unique:tb_ordo,nama'
        ]);
        
        $ordo = new tbOrdo;
        $ordo->idKelas = $req->kelas;
        $ordo->nama = $req->bangsa;
        $ordo->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah bangsa '.$req->bangsa;
        $history->ket = 'Modul bangsa';
        $history->save();

        return redirect(route('adminOrdo'))->with('sessPesanSindata','Data bangsa berhasil disimpan.'); 
    }
    public function show($idOrdo){
        $ordo = tbOrdo::find($idOrdo);

        $kelas = tbKelas::where('idSubDivisi','<>','0')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.ordo.tampil',compact('ordo','kelas'));
    }
    public function edit(Request $req, $idOrdo){
        if($req->bangsa <> $req->bangsaHidden){
            $rule = [
                'kelas' => 'required',
                'bangsa' => 'required|max:30|unique:tb_ordo,nama'
            ];
        }else{
            $rule = [
                'kelas' => 'required',
                'bangsa' => 'required|max:30'
            ];
        }
        $this->validate($req, $rule);

        $ordo = tbOrdo::find($idOrdo);
        $ordo->idKelas = $req->kelas;
        $ordo->nama = $req->bangsa;
        $ordo->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah bangsa '.$req->bangsaHidden.' menjadi '.$req->bangsa;
        $history->ket = 'Modul bangsa';
        $history->save();

        return redirect(route('adminOrdo'))->with('sessPesanSindata','Data bangsa berhasil diubah.');                
    }
    public function delete(Request $req, $idOrdo){
        $bangsaHidden = tbOrdo::find($idOrdo);
        $bangsaHid = $bangsaHidden->nama;

        $ordo = tbOrdo::find($idOrdo);
        $ordo->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus bangsa '.$bangsaHid;
        $history->ket = 'Modul bangsa';
        $history->save();

        return redirect(route('adminOrdo'))->with('sessPesanSindata','Data bangsa berhasil dihapus.');        
    }    
}
