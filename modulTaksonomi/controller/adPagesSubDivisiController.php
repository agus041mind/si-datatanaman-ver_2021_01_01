<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbDivisi;
use App\tbSubDivisi;
use App\tbHistory;

class adPagesSubDivisiController extends Controller
{
    public function index(){
        $subDivisi = tbSubDivisi::where('nama','<>','')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.subDivisi.index',compact('subDivisi'));
    }
    public function create(){
        $divisi = tbDivisi::where('nama','<>','Indetermined')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.subDivisi.tambah',compact('divisi'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'divisi' => 'required',
            'subDivisi' => 'required|max:30|unique:tb_subdivisi,nama'
        ]);
        
        $subDivisi = new tbSubDivisi;
        $subDivisi->idDivisi = $req->divisi;
        $subDivisi->nama = $req->subDivisi;
        $subDivisi->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah sub divisi '.$req->subDivisi;
        $history->ket = 'Modul sub divisi';
        $history->save();

        return redirect(route('adminSubDivisi'))->with('sessPesanSindata','Data sub divisi berhasil disimpan.'); 
    }
    public function show($idSubDivisi){
        $subDivisi = tbSubDivisi::find($idSubDivisi);

        $divisi = tbDivisi::where('nama','<>','Indetermined')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.subDivisi.tampil',compact('subDivisi','divisi'));
    }
    public function edit(Request $req, $idSubDivisi){
        if($req->subDivisi <> $req->subDivisiHidden){
            $rule = [
                'divisi' => 'required',
                'subDivisi' => 'required|max:30|unique:tb_subdivisi,nama'
            ];
        }else{
            $rule = [
                'divisi' => 'required',
                'subDivisi' => 'required|max:30'
            ];
        }
        $this->validate($req, $rule);

        $subDivisi = tbSubDivisi::find($idSubDivisi);
        $subDivisi->idDivisi = $req->divisi;
        $subDivisi->nama = $req->subDivisi;
        $subDivisi->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah sub divisi '.$req->subDivisiHidden.' menjadi '.$req->subDivisi;
        $history->ket = 'Modul sub divisi';
        $history->save();

        return redirect(route('adminSubDivisi'))->with('sessPesanSindata','Data sub divisi berhasil diubah.');                
    }
    public function delete(Request $req, $idSubDivisi){
        $subDivisiHidden = tbSubDivisi::find($idSubDivisi);
        $subDivisiHid = $subDivisiHidden->nama;

        $subDivisi = tbSubDivisi::find($idSubDivisi);
        $subDivisi->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus sub divisi '.$subDivisiHid;
        $history->ket = 'Modul sub divisi';
        $history->save();

        return redirect(route('adminSubDivisi'))->with('sessPesanSindata','Data sub divisi berhasil dihapus.');        
    }
}
