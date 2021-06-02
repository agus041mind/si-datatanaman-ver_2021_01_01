<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\tbLokasi;
use App\tbHistory;

class adPagesLokasiController extends Controller
{
    public function index(){
        $lokasi = tbLokasi::where('idLokasi','<>','0')
        ->orderBy('updated_at','desc')
        ->get();

        return view('adPages.lokasi.index',compact('lokasi'));
    }
    public function create(){
        return view('adPages.lokasi.tambah');
    }
    public function store(Request $req){
        $this->validate($req,[
            'kab_kota' => [
                'required',
                Rule::unique('tb_lokasi','kab_kota')->where(function ($query) use ($req){
                    return $query->where('provinsi',$req->provinsi)
                    ->where('pulau',$req->pulau)
                    ->where('negara',$req->negara);
                })
            ],
            'provinsi' => 'required',
            'pulau' => 'required',
            'negara' => 'required'    
        ]);
        
        $lokasi = new tbLokasi;
        $lokasi->negara = $req->negara;
        $lokasi->pulau = $req->pulau;
        $lokasi->provinsi = $req->provinsi;
        $lokasi->kab_kota = $req->kab_kota;
        $lokasi->save();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menambah lokasi '.$req->kab_kota.'; '.$req->provinsi.'; '.$req->pulau.'; '.$req->negara;
        $history->ket = 'Modul lokasi eksplorasi';
        $history->save();

        return redirect(route('adminLokasi'))->with('sessPesanSindata','Data lokasi eksplorasi berhasil disimpan.');
    }
    public function show($idLokasi){
        $lokasi = tbLokasi::find($idLokasi);
        return view('adPages.lokasi.tampil',compact('lokasi'));
    }
    public function edit(Request $req, $idLokasi){
        if(($req->kab_kota == $req->kab_kotaHidden) && ($req->provinsi == $req->provinsiHidden) && ($req->pulau == $req->pulauHidden) && ($req->negara == $req->negaraHidden)){
            $rule = [
                'kab_kota' => 'required',
                'provinsi' => 'required',
                'pulau' => 'required',
                'negara' => 'required'    
            ];
        }else{
            $rule = [
                'kab_kota' => [
                    'required',
                    Rule::unique('tb_lokasi','kab_kota')->where(function ($query) use ($req){
                        return $query->where('provinsi',$req->provinsi)
                        ->where('pulau',$req->pulau)
                        ->where('negara',$req->negara);
                    })
                ],
                'provinsi' => 'required',
                'pulau' => 'required',
                'negara' => 'required'    
            ];
        }
        $this->validate($req, $rule);

        $lokasi = tbLokasi::find($idLokasi);
        $lokasi->kab_kota = $req->kab_kota;
        $lokasi->provinsi = $req->provinsi;
        $lokasi->pulau = $req->pulau;
        $lokasi->negara = $req->negara;
        $lokasi->update();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Mengubah lokasi '.$req->kab_kotaHidden.'; '.$req->provinsiHidden.'; '.$req->pulauHidden.'; '.$req->negaraHidden.' menjadi '.$req->kab_kota.'; '.$req->provinsi.'; '.$req->pulau.'; '.$req->negara;
        $history->ket = 'Modul lokasi eksplorasi';
        $history->save();

        return redirect(route('adminLokasi'))->with('sessPesanSindata','Data lokasi eksplorasi berhasil diubah.');  
    }
    public function delete(Request $req, $idLokasi){
        $lokasiHidden = tbLokasi::find($idLokasi);
        $kab_kotaHid = $lokasiHidden->kab_kota;
        $provinsiHid = $lokasiHidden->provinsi;
        $pulauHid = $lokasiHidden->pulau;
        $negaraHid = $lokasiHidden->negara;

        $lokasi = tbLokasi::find($idLokasi);
        $lokasi->delete();

        $history = new tbHistory;
        $history->idUser = $req->session()->get('sessANSindataIdUser');
        $history->aktivitas = 'Menghapus lokasi '.$kab_kotaHid.'; '.$provinsiHid.'; '.$pulauHid.'; '.$negaraHid;
        $history->ket = 'Modul lokasi eksplorasi';
        $history->save();

        return redirect(route('adminLokasi'))->with('sessPesanSindata','Data lokasi eksplorasi berhasil dihapus.');
    }
}
