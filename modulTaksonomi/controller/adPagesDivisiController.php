<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbDivisi;
use App\tbHistory;

class adPagesDivisiController extends Controller
{
    public function index(){
        $divisi = tbDivisi::where('nama','<>','Indetermined')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.divisi.index',compact('divisi'));
    }
    public function create(){
        return view('adPages.divisi.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'divisi' => 'required|max:30|unique:tb_divisi,nama'
        ]);
        
        $divisi = new tbDivisi;
        $divisi->idKingdom = '1';
        $divisi->nama = $req->divisi;
        $divisi->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah divisi '.$req->divisi;
        $history->ket = 'Modul divisi';
        $history->save();

        return redirect(route('adminDivisi'))->with('sessPesanSindata','Data divisi berhasil disimpan.'); 
    }
    public function show($idDivisi){
        $divisi = tbDivisi::find($idDivisi);
        return view('adPages.divisi.tampil',compact('divisi'));
    }
    public function edit(Request $req, $idDivisi){
        if($req->divisi <> $req->divisiHidden){
            $rule = [
                'divisi' => 'required|max:30|unique:tb_divisi,nama'
            ];
        }else{
            $rule = [
                'divisi' => 'required|max:30'
            ];
        }        
        $this->validate($req, $rule);
        
        $divisi = tbDivisi::find($idDivisi);
        $divisi->nama = $req->divisi;
        $divisi->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah divisi '.$req->divisiHidden.' menjadi '.$req->divisi;
        $history->ket = 'Modul divisi';
        $history->save();

        return redirect(route('adminDivisi'))->with('sessPesanSindata','Data divisi berhasil diubah.');        
    }
    public function delete(Request $req, $idDivisi){
        $divisiHidden = tbDivisi::find($idDivisi);
        $divisiHid = $divisiHidden->nama;

        $divisi = tbDivisi::find($idDivisi);
        $divisi->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus divisi '.$divisiHid;
        $history->ket = 'Modul divisi';
        $history->save();

        return redirect(route('adminDivisi'))->with('sessPesanSindata','Data divisi berhasil dihapus.');
    }
}
