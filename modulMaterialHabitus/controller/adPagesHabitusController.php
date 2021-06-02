<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbHabitus;
use App\tbHistory;

class adPagesHabitusController extends Controller
{
    public function index(){
        $habitus = tbHabitus::where('idHabitus','<>','0')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.habitus.index',compact('habitus'));
    }
    public function create(){
        return view('adPages.habitus.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'kode' => 'required|unique:tb_habitus,kode',
            'habitus' => 'required'
        ]);
        
        $habitus = new tbHabitus;
        $habitus->kode = $req->kode;
        $habitus->nama = $req->habitus;
        $habitus->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah habitus '.$req->habitus.' ('.$req->kode.')';
        $history->ket = 'Modul habitus';
        $history->save();

        return redirect(route('adminHabitus'))->with('sessPesanSindata','Data habitus berhasil disimpan.'); 
    }
    public function show($idHabitus){
        $habitus = tbHabitus::find($idHabitus);
        return view('adPages.habitus.tampil',compact('habitus'));
    }
    public function edit(Request $req, $idHabitus){
        if($req->kode <> $req->kodeHidden){
            $rule = [
                'kode' => 'required|unique:tb_habitus,kode',
                'habitus' => 'required'
                ];
        }else{
            $rule = [
                'kode' => 'required',
                'habitus' => 'required'
                ];
        }        
        $this->validate($req, $rule);
        
        $habitus = tbHabitus::find($idHabitus);
        $habitus->kode = $req->kode;
        $habitus->nama = $req->habitus;
        $habitus->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah habitus '.$req->habitusHidden.' ('.$req->kodeHidden.') menjadi '.$req->habitus.' ('.$req->kode.')';
        $history->ket = 'Modul habitus';
        $history->save();

        return redirect(route('adminHabitus'))->with('sessPesanSindata','Data habitus berhasil diubah.');        
    }
    public function delete(Request $req, $idHabitus){
        $habitusHidden = tbHabitus::find($idHabitus);
        $kodeHid = $habitusHidden->kode;
        $habitusHid = $habitusHidden->nama;

        $habitus = tbHabitus::find($idHabitus);
        $habitus->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus habitus '.$habitusHid.' ('.$kodeHid.')';
        $history->ket = 'Modul habitus';
        $history->save();

        return redirect(route('adminHabitus'))->with('sessPesanSindata','Data habitus berhasil dihapus.');
    }
}
