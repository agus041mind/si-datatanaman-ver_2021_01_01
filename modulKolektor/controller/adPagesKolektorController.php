<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\tbKolektor;
use App\tbHistory;

class adPagesKolektorController extends Controller
{
    public function index(){
        $kolektor = tbKolektor::where('idKolektor','<>','K0')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.kolektor.index',compact('kolektor'));
    }
    public function create(){
        return view('adPages.kolektor.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'jenis' => 'required',
            'kodeSindata' => 'required|unique:tb_kolektor,idKolektor',
            'kodeKolektor' => 'required',
            'nama' => 'required'
        ]);
        
        $kolektor = new tbKolektor;
        $kolektor->idKolektor = Str::upper($req->kodeSindata);
        $kolektor->idKolektorAsli = Str::upper($req->kodeKolektor);
        $kolektor->nama = $req->nama;
        $kolektor->keterangan = $req->keterangan;
        $kolektor->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah kolektor '.$req->nama.' ('.Str::upper($req->kodeSindata).'; '.Str::upper($req->kodeKolektor).')';
        $history->ket = 'Modul kolektor';
        $history->save();

        return redirect(route('adminKolektor'))->with('sessPesanSindata','Data kolektor berhasil disimpan.');
    }
    public function show($idKolektor){
        $kolektor = tbKolektor::find($idKolektor);

        return view('adPages.kolektor.tampil',compact('kolektor'));
    }
    public function edit(Request $req, $idKolektor){
        if($req->kodeSindata <> $req->kodeSindataHidden){
            $rule = [
                'jenis' => 'required',
                'kodeSindata' => 'required|unique:tb_kolektor,idKolektor',
                'kodeKolektor' => 'required',
                'nama' => 'required'
                ];
        }else{
            $rule = [
                'jenis' => 'required',
                'kodeSindata' => 'required',
                'kodeKolektor' => 'required',
                'nama' => 'required'
            ];
        }
        $this->validate($req, $rule);

        $kolektor = tbKolektor::find($idKolektor);
        $kolektor->idKolektor = Str::upper($req->kodeSindata);
        $kolektor->idKolektorAsli = Str::upper($req->kodeKolektor);
        $kolektor->nama = $req->nama;
        $kolektor->keterangan = $req->keterangan;
        $kolektor->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah kolektor '.$req->namaHidden.' ('.$req->kodeSindataHidden.'; '.$req->kodeKolektorHidden.') menjadi '.$req->nama.' ('.Str::upper($req->kodeSindata).'; '.Str::upper($req->kodeKolektor).')';
        $history->ket = 'Modul kolektor';
        $history->save();

        return redirect(route('adminKolektor'))->with('sessPesanSindata','Data kolektor berhasil diubah.');                
    }
    public function delete(Request $req, $idKolektor){
        $kolektorHidden = tbKolektor::find($idKolektor);
        $kodeSindataHid = $kolektorHidden->idKolektor;
        $kodeKolektorHid = $kolektorHidden->idKolektorAsli;
        $namaHid = $kolektorHidden->nama;

        $kolektor = tbKolektor::find($idKolektor);
        $kolektor->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus kolektor '.$namaHid.' ('.$kodeSindataHid.'; '.$kodeKolektorHid.')';
        $history->ket = 'Modul kolektor';
        $history->save();

        return redirect(route('adminKolektor'))->with('sessPesanSindata','Data kolektor berhasil dihapus.');        
    }    
}
