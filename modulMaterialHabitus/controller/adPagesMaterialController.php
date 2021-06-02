<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbMaterial;
use App\tbHistory;

class adPagesMaterialController extends Controller
{
    public function index(){
        $material = tbMaterial::where('idMaterial','<>','0')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.material.index',compact('material'));
    }
    public function create(){
        return view('adPages.material.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'kode' => 'required|unique:tb_material,kode',
            'material' => 'required'
        ]);
        
        $material = new tbMaterial;
        $material->kode = $req->kode;
        $material->nama = $req->material;
        $material->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah material '.$req->material.' ('.$req->kode.')';
        $history->ket = 'Modul material';
        $history->save();

        return redirect(route('adminMaterial'))->with('sessPesanSindata','Data material berhasil disimpan.'); 
    }
    public function show($idMaterial){
        $material = tbMaterial::find($idMaterial);
        return view('adPages.material.tampil',compact('material'));
    }
    public function edit(Request $req, $idMaterial){
        if($req->kode <> $req->kodeHidden){
            $rule = [
                'kode' => 'required|unique:tb_material,kode',
                'material' => 'required'
                ];
        }else{
            $rule = [
                'kode' => 'required',
                'material' => 'required'
                ];
        }        
        $this->validate($req, $rule);
        
        $material = tbMaterial::find($idMaterial);
        $material->kode = $req->kode;
        $material->nama = $req->material;
        $material->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah material '.$req->materialHidden.' ('.$req->kodeHidden.') menjadi '.$req->material.' ('.$req->kode.')';
        $history->ket = 'Modul material';
        $history->save();

        return redirect(route('adminMaterial'))->with('sessPesanSindata','Data material berhasil diubah.');        
    }
    public function delete(Request $req, $idMaterial){
        $materialHidden = tbMaterial::find($idMaterial);
        $kodeHid = $materialHidden->kode;
        $materialHid = $materialHidden->nama;

        $material = tbMaterial::find($idMaterial);
        $material->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus material '.$materialHid.' ('.$kodeHid.')';
        $history->ket = 'Modul material';
        $history->save();

        return redirect(route('adminMaterial'))->with('sessPesanSindata','Data material berhasil dihapus.');
    }
}
