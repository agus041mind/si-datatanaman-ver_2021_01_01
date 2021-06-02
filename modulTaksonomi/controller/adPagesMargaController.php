<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\tbSuku;
use App\tbMarga;
use App\tbJenis;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesMargaController extends Controller
{
    public function index(){
        $marga = tbMarga::where('nama','<>','')
        ->where('nama','<>','Gendub')
        ->orderBy('updated_at','desc')
        ->get();
        
        return view('adPages.marga.index',compact('marga'));
    }
    public function create(){
        $suku = tbSuku::where('nama','<>','')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.marga.tambah',compact('suku'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'suku' => 'required',
            'marga' => [
                'required',
                'max:30',
                Rule::notIn(['Gendub','gendub','GENDUB']),
                Rule::unique('tb_marga','nama')->where(function ($query) use ($req){
                    return $query->where('idSuku',$req->suku);
                })    
            ]
        ]);
     
        $sukuHidBaru = tbSuku::find($req->suku);
        $sukuHidBaru01 = $sukuHidBaru->nama;

        $idMargaBaru = Sindata::idMargaBaru();
        $idJenisBaru = Sindata::idJenisBaru();

        $marga = new tbMarga;
        $marga->idMarga = $idMargaBaru;
        $marga->idSuku = $req->suku;
        $marga->nama = $req->marga;
        $marga->save();

        $jenis = new tbJenis;
        $jenis->idJenis = $idJenisBaru;
        $jenis->idMarga = $idMargaBaru;
        $jenis->nama = 'sp.';
        $jenis->idAuthorJenis = "A0";
        $jenis->idAuthorSubJenis = "A0";
        $jenis->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah marga '.$req->marga.' ('.$sukuHidBaru01.')';
        $history->ket = 'Modul marga';
        $history->save();

        return redirect(route('adminMarga'))->with('sessPesanSindata','Data marga berhasil disimpan.'); 
    }
    public function show($idMarga){
        $marga = tbMarga::find($idMarga);

        $suku = tbSuku::where('nama','<>','')
        ->orderBy('nama','asc')
        ->get();

        return view('adPages.marga.tampil',compact('marga','suku'));
    }
    public function edit(Request $req, $idMarga){
        if(($req->suku == $req->sukuHidden) && ($req->marga == $req->margaHidden)){
            $rule = [
                'suku' => 'required',
                'marga' => [
                    'required',
                    'max:30',
                    Rule::notIn(['Gendub','gendub','GENDUB'])
                ]
            ];
        }else{
            $rule = [
                'suku' => 'required',
                'marga' => [
                    'required',
                    'max:30',
                    Rule::notIn(['Gendub','gendub','GENDUB']),
                    Rule::unique('tb_marga','nama')->where(function ($query) use ($req){
                        return $query->where('idSuku',$req->suku);
                    })    
                ]
            ];
        }
        $this->validate($req, $rule);

        $sukuHidUbah01 = tbSuku::find($req->sukuHidden);
        $sukuHidUbah0101 = $sukuHidUbah01->nama;

        $sukuHidUbah02 = tbSuku::find($req->suku);
        $sukuHidUbah0202 = $sukuHidUbah02->nama;

        $marga = tbMarga::find($idMarga);
        $marga->idSuku = $req->suku;
        $marga->nama = $req->marga;
        $marga->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah marga '.$req->margaHidden.' ('.$sukuHidUbah0101.') menjadi '.$req->marga.' ('.$sukuHidUbah0202.')';
        $history->ket = 'Modul marga';
        $history->save();

        return redirect(route('adminMarga'))->with('sessPesanSindata','Data marga berhasil diubah.');                
    }
    public function delete(Request $req, $idMarga){        
        $margaHidden = tbMarga::find($idMarga);
        $sukuHid = $margaHidden->suku->nama;
        $margaHid = $margaHidden->nama;

        $marga = tbMarga::find($idMarga);
        $marga->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus marga '.$margaHid.' ('.$sukuHid.')';
        $history->ket = 'Modul marga';
        $history->save();

        return redirect(route('adminMarga'))->with('sessPesanSindata','Data marga berhasil dihapus.');        
    }
}
