<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbSubDivisi;
use App\tbKelas;
use App\tbHistory;

class adPagesKelasController extends Controller
{
    public function index(){
        $kelas = tbKelas::where('nama','<>','')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.kelas.index',compact('kelas'));
    }
    public function create(){
        $subDivisi = tbSubDivisi::where('idDivisi','<>','0')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.kelas.tambah',compact('subDivisi'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'subDivisi' => 'required',
            'kelas' => 'required|max:30|unique:tb_kelas,nama'
        ]);
        
        $kelas = new tbKelas;
        $kelas->idSubDivisi = $req->subDivisi;
        $kelas->nama = $req->kelas;
        $kelas->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah kelas '.$req->kelas;
        $history->ket = 'Modul kelas';
        $history->save();

        return redirect(route('adminKelas'))->with('sessPesanSindata','Data kelas berhasil disimpan.'); 
    }
    public function show($idKelas){
        $kelas = tbKelas::find($idKelas);

        $subDivisi = tbSubDivisi::where('idDivisi','<>','0')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.kelas.tampil',compact('kelas','subDivisi'));
    }
    public function edit(Request $req, $idKelas){
        if($req->kelas <> $req->kelasHidden){
            $rule = [
                'subDivisi' => 'required',
                'kelas' => 'required|max:30|unique:tb_kelas,nama'
            ];
        }else{
            $rule = [
                'subDivisi' => 'required',
                'kelas' => 'required|max:30'
            ];
        }
        $this->validate($req, $rule);

        $kelas = tbKelas::find($idKelas);
        $kelas->idSubDivisi = $req->subDivisi;
        $kelas->nama = $req->kelas;
        $kelas->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah kelas '.$req->kelasHidden.' menjadi '.$req->kelas;
        $history->ket = 'Modul kelas';
        $history->save();

        return redirect(route('adminKelas'))->with('sessPesanSindata','Data kelas berhasil diubah.');                
    }
    public function delete(Request $req, $idKelas){
        $kelasHidden = tbKelas::find($idKelas);
        $kelasHid = $kelasHidden->nama;

        $kelas = tbKelas::find($idKelas);
        $kelas->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus kelas '.$kelasHid;
        $history->ket = 'Modul kelas';
        $history->save();

        return redirect(route('adminKelas'))->with('sessPesanSindata','Data kelas berhasil dihapus.');        
    }
}
