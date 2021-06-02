<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\tbWilayah;
use App\tbHistory;
use App\Helpers\Sindata;

class adPagesWilayahController extends Controller
{
    public function index(){
        $wilayah = tbWilayah::where('idWilayah','<>','0')
        ->orderBy('indek','asc')
        ->get();
        
        $jmlWilayah = tbWilayah::where('idWilayah','<>','0')->count();
        
        return view('adPages.wilayah.index',compact('wilayah','jmlWilayah'));
    }
    public function create(){
        return view('adPages.wilayah.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'wilayah' => 'required|unique:tb_wilayah,nama',
            'pengawas' => 'required'
        ]);
        
        $wilayah = new tbWilayah;
        $wilayah->nama = $req->wilayah;
        $wilayah->pengawas = $req->pengawas;
        $wilayah->indek = Sindata::indekWilayah('mak')+1;
        $wilayah->keterangan = $req->keterangan;
        $wilayah->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah wilayah '.$req->wilayah.' ('.$req->pengawas.')';
        $history->ket = 'Modul wilayah';
        $history->save();

        return redirect(route('adminWilayah'))->with('sessPesanSindata','Data wilayah berhasil disimpan.');
    }
    public function show($idWilayah){
        $wilayah = tbWilayah::find($idWilayah);
        return view('adPages.wilayah.tampil',compact('wilayah'));
    }
    public function edit(Request $req, $idWilayah){
        if($req->wilayah == $req->wilayahHidden){
            $rule = [
                'wilayah' => 'required',
                'pengawas' => 'required'
            ];
        }else{
            $rule = [
                'wilayah' => 'required|unique:tb_wilayah,nama',
                'pengawas' => 'required'
            ];
        }
        $this->validate($req, $rule);

        $wilayah = tbWilayah::find($idWilayah);
        $wilayah->nama = $req->wilayah;
        $wilayah->pengawas = $req->pengawas;
        $wilayah->keterangan = $req->keterangan;
        $wilayah->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah wilayah '.$req->wilayahHidden.' ('.$req->pengawasHidden.') menjadi '.$req->wilayah.' ('.$req->pengawas.')';
        $history->ket = 'Modul wilayah';
        $history->save();

        return redirect(route('adminWilayah'))->with('sessPesanSindata','Data wilayah berhasil diubah.');  
    }
    public function delete(Request $req, $idWilayah){
        $wilayahHidden = tbWilayah::find($idWilayah);
        $wilayahHid = $wilayahHidden->nama;
        $pengawasHid = $wilayahHidden->pengawas;

        $wilayah = tbWilayah::find($idWilayah);
        $wilayah->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus wilayah '.$wilayahHid.' ('.$pengawasHid.')';
        $history->ket = 'Modul wilayah';
        $history->save();

        return redirect(route('adminWilayah'))->with('sessPesanSindata','Data wilayah berhasil dihapus.');
    }
    public function orderDown(Request $req, $idWilayah){
        $wilayah1 = tbWilayah::find($idWilayah);
        $idWilayah1 = $wilayah1->idWilayah;

        $wilayah2 = tbWilayah::where('indek','>',$wilayah1->indek)->orderBy('indek','asc')->first();
        $idWilayah2 = $wilayah2->idWilayah;

        $indek1 = $wilayah1->indek;
        $indek2 = $wilayah2->indek;
        $indek3 = Sindata::indekWilayah('mak')+1;

        $order1 = tbWilayah::find($idWilayah1);
        $order1->indek = $indek3;
        $order1->update();

        $order2 = tbWilayah::find($idWilayah2);
        $order2->indek = $indek1;
        $order2->update();

        $order3 = tbWilayah::find($idWilayah1);
        $order3->indek = $indek2;
        $order3->update();

        return redirect(route('adminWilayah'));
    }
    public function orderUp(Request $req, $idWilayah){
        $wilayah1 = tbWilayah::find($idWilayah);
        $idWilayah1 = $wilayah1->idWilayah;

        $wilayah2 = tbWilayah::where('indek','<',$wilayah1->indek)->orderBy('indek','desc')->first();
        $idWilayah2 = $wilayah2->idWilayah;

        $indek1 = $wilayah1->indek;
        $indek2 = $wilayah2->indek;
        $indek3 = Sindata::indekWilayah('mak')+1;

        $order1 = tbWilayah::find($idWilayah1);
        $order1->indek = $indek3;
        $order1->update();

        $order2 = tbWilayah::find($idWilayah2);
        $order2->indek = $indek1;
        $order2->update();

        $order3 = tbWilayah::find($idWilayah1);
        $order3->indek = $indek2;
        $order3->update();

        return redirect(route('adminWilayah'));
    }
}
