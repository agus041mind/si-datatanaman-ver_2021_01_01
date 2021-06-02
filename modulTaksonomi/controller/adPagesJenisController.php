<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\tbAuthor;
use App\tbGuna;
use App\tbKegunaan;
use App\tbMarga;
use App\tbJenis;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesJenisController extends Controller
{
    public function index(){
        $jenis = tbJenis::where('nama','<>','')
        ->where('nama','<>','sp.')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.jenis.index',compact('jenis'));
    }
    public function create(){
        $marga = tbMarga::where('nama','<>','')
        ->where('nama','<>','Gendub')
        ->orderBy('nama','asc')
        ->get();

        $author = tbAuthor::orderBy('idAuthor','asc')
        ->get();

        $kegunaan = tbKegunaan::orderBy('nama','asc')
        ->get();
        
        return view('adPages.jenis.tambah',compact('marga','author','kegunaan'));
    }
    public function store(Request $req){
        $this->validate($req,[
            'marga' => 'required',
            'jenis' => [
                'required',
                Rule::notIn(['Sp','sp','SP','Sp.','sp.','SP.']),
                Rule::unique('tb_jenis','nama')->where(function ($query) use ($req){
                        return $query->where('idMarga',$req->marga)
                        ->where('idAuthorJenis',$req->authorJenis)
                        ->where('subJenis',$req->subJenis)
                        ->where('idAuthorSubJenis',$req->authorSubJenis);
                })    
            ],
            'authorJenis' => 'required',
            'authorSubJenis' => 'required'
        ]);
    
        $margaHidden = tbMarga::find($req->marga);
        $margaHid = $margaHidden->nama;
        $authorJenisHidden = tbAuthor::find($req->authorJenis);
        $authorJenisHid = $authorJenisHidden->nama;
        $authorSubJenisHidden = tbAuthor::find($req->authorSubJenis);
        $authorSubJenisHid = $authorSubJenisHidden->nama;

        $idJenisBaru = Sindata::idJenisBaru();

        $jenis = new tbJenis;
        $jenis->idJenis = $idJenisBaru;
        $jenis->idMarga = $req->marga;
        $jenis->nama = $req->jenis;
        $jenis->idAuthorJenis = $req->authorJenis;
        $jenis->subJenis = $req->subJenis;
        $jenis->idAuthorSubJenis = $req->authorSubJenis;
        $jenis->kegunaan = $req->kegunaan;
        $jenis->distribusi = $req->persebaran;
        $jenis->keterangan = $req->keterangan;
        $jenis->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah jenis '.$margaHid.' '.$req->jenis.' '.$authorJenisHid.' '.$req->subJenis.' '.$authorSubJenisHid;
        $history->ket = 'Modul jenis';
        $history->save();

        return redirect(route('adminJenis'))->with('sessPesanSindata','Data jenis berhasil disimpan.');
    }
    public function show($idJenis){
        $jenis = tbJenis::find($idJenis);

        $marga = tbMarga::where('nama','<>','')
        ->where('nama','<>','Gendub')
        ->orderBy('nama','asc')
        ->get();

        $author = tbAuthor::orderBy('idAuthor','asc')
        ->get();

        $kegunaan = tbKegunaan::orderBy('nama','asc')
        ->get();

        return view('adPages.jenis.tampil',compact('jenis','marga','author','kegunaan'));
    }
    public function edit(Request $req, $idJenis){
        if(($req->marga == $req->margaHidden) && ($req->jenis == $req->jenisHidden) && ($req->authorJenis == $req->authorJenisHidden) && ($req->subJenis == $req->subJenisHidden) && ($req->authorSubJenis == $req->authorSubJenisHidden)){
            $rule = [
                'marga' => 'required',
                'jenis' => 'required',
                'authorJenis' => 'required',
                'authorSubJenis' => 'required'    
            ];
        }else{
            $rule = [
                'marga' => 'required',
                'jenis' => [
                    'required',
                    Rule::notIn(['Sp','sp','SP','Sp.','sp.','SP.']),
                    Rule::unique('tb_jenis','nama')->where(function ($query) use ($req){
                            return $query->where('idMarga',$req->marga)
                            ->where('idAuthorJenis',$req->authorJenis)
                            ->where('subJenis',$req->subJenis)
                            ->where('idAuthorSubJenis',$req->authorSubJenis);
                    })    
                ],
                'authorJenis' => 'required',
                'authorSubJenis' => 'required'    
            ];
        }
        $this->validate($req, $rule);

        $margaHidUbah01 = tbMarga::find($req->margaHidden);
        $margaHidUbah0101 = $margaHidUbah01->nama;
        $authorJenisHidUbah01 = tbAuthor::find($req->authorJenisHidden);
        $authorJenisHidUbah0101 = $authorJenisHidUbah01->nama;
        $authorSubJenisHidUbah01 = tbAuthor::find($req->authorSubJenisHidden);
        $authorSubJenisHidUbah0101 = $authorSubJenisHidUbah01->nama;

        $margaHidUbah02 = tbMarga::find($req->marga);
        $margaHidUbah0202 = $margaHidUbah02->nama;
        $authorJenisHidUbah02 = tbAuthor::find($req->authorJenis);
        $authorJenisHidUbah0202 = $authorJenisHidUbah02->nama;
        $authorSubJenisHidUbah02 = tbAuthor::find($req->authorSubJenis);
        $authorSubJenisHidUbah0202 = $authorSubJenisHidUbah02->nama;

        $jenis = tbJenis::find($idJenis);
        $jenis->idMarga = $req->marga;
        $jenis->nama = $req->jenis;
        $jenis->idAuthorJenis = $req->authorJenis;
        $jenis->subJenis = $req->subJenis;
        $jenis->idAuthorSubJenis = $req->authorSubJenis;
        $jenis->kegunaan = $req->kegunaan;
        $jenis->distribusi = $req->persebaran;
        $jenis->keterangan = $req->keterangan;        
        $jenis->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah jenis '.$margaHidUbah0101.' '.$req->jenisHidden.' '.$authorJenisHidUbah0101.' '.$req->subJenisHidden.' '.$authorSubJenisHidUbah0101.' menjadi '.$margaHidUbah0202.' '.$req->jenis.' '.$authorJenisHidUbah0202.' '.$req->subJenis.' '.$authorSubJenisHidUbah0202;
        $history->ket = 'Modul jenis';
        $history->save();

        return redirect(route('adminJenis'))->with('sessPesanSindata','Data jenis berhasil diubah.'); 
    }
    public function delete(Request $req, $idJenis){        
        $jenisHidden = tbJenis::find($idJenis);
        $margaHid = $jenisHidden->marga->nama;
        $jenisHid = $jenisHidden->nama;
        $authorJenisHid = $jenisHidden->authorJenis->nama;
        $subJenisHid = $jenisHidden->subJenis;
        $authorSubJenisHid = $jenisHidden->authorSubJenis->nama;

        $jenis = tbJenis::find($idJenis);
        $jenis->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus jenis '.$margaHid.' '.$jenisHid.' '.$authorJenisHid.' '.$subJenisHid.' '.$authorSubJenisHid;
        $history->ket = 'Modul jenis';
        $history->save();

        return redirect(route('adminJenis'))->with('sessPesanSindata','Data jenis berhasil dihapus.');        
    }
}
