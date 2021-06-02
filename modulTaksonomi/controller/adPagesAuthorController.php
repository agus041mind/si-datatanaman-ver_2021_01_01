<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbAuthor;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesAuthorController extends Controller
{
    public function index(){
        $author = tbAuthor::where('nama','<>','')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.author.index',compact('author'));
    }
    public function create(){
        return view('adPages.author.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'author' => 'required|unique:tb_author,nama'
        ]);
        
        $idAuthorBaru = Sindata::idAuthorBaru();

        $author = new tbAuthor;
        $author->idAuthor = $idAuthorBaru;
        $author->nama = $req->author;
        $author->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah author '.$req->author;
        $history->ket = 'Modul author';
        $history->save();

        return redirect(route('adminAuthor'))->with('sessPesanSindata','Data author berhasil disimpan.'); 
    }
    public function show($idAuthor){
        $author = tbAuthor::find($idAuthor);
        return view('adPages.author.tampil',compact('author'));
    }
    public function edit(Request $req, $idAuthor){
        if($req->author <> $req->authorHidden){
            $rule = [
                'author' => 'required|unique:tb_author,nama'
            ];
        }else{
            $rule = [
                'author' => 'required'
            ];
        }        
        $this->validate($req, $rule);
        
        $author = tbAuthor::find($idAuthor);
        $author->nama = $req->author;
        $author->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah author '.$req->authorHidden.' menjadi '.$req->author;
        $history->ket = 'Modul author';
        $history->save();

        return redirect(route('adminAuthor'))->with('sessPesanSindata','Data author berhasil diubah.');        
    }
    public function delete(Request $req, $idAuthor){
        $authorHidden = tbAuthor::find($idAuthor);
        $authorHid = $authorHidden->nama;

        $author = tbAuthor::find($idAuthor);
        $author->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus author '.$authorHid;
        $history->ket = 'Modul author';
        $history->save();

        return redirect(route('adminAuthor'))->with('sessPesanSindata','Data author berhasil dihapus.');
    }
}
