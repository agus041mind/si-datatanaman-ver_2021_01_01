<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbWilayah extends Model
{
    protected $table = 'tb_wilayah';
    protected $primaryKey = 'idWilayah';
    protected $appends = ['BibitDitanam','Koleksi','Relokasi','IdModalBS'];

    public function lingkungan(){
        return $this->hasMany('App\tbLingkungan','idWilayah');
    }
    public function getBibitDitanamAttribute(){
        $lokasiBD = DB::table('tb_bibitditanam')
        ->join('tb_vak','tb_bibitditanam.idVak','=','tb_vak.idVak')
        ->join('tb_lingkungan','tb_vak.idLingkungan','=','tb_lingkungan.idLingkungan')
        ->join('tb_wilayah','tb_lingkungan.idWilayah','=','tb_wilayah.idWilayah')
        ->where('tb_wilayah.idWilayah','=',$this->idWilayah)
        ->count();        
        return $lokasiBD;
    }
    public function getKoleksiAttribute(){
        $lokasiK = DB::table('tb_koleksi')
        ->join('tb_vak','tb_koleksi.idVak','=','tb_vak.idVak')
        ->join('tb_lingkungan','tb_vak.idLingkungan','=','tb_lingkungan.idLingkungan')
        ->join('tb_wilayah','tb_lingkungan.idWilayah','=','tb_wilayah.idWilayah')
        ->where('tb_wilayah.idWilayah','=',$this->idWilayah)
        ->count();        
        return $lokasiK;
    }
    public function getRelokasiAttribute(){
        $lokasiR = DB::table('tb_relokasi')
        ->join('tb_vak','tb_relokasi.idVakLama','=','tb_vak.idVak')
        ->join('tb_lingkungan','tb_vak.idLingkungan','=','tb_lingkungan.idLingkungan')
        ->join('tb_wilayah','tb_lingkungan.idWilayah','=','tb_wilayah.idWilayah')
        ->where('tb_wilayah.idWilayah','=',$this->idWilayah)
        ->count();        
        return $lokasiR;
    }
    public function getIdModalBSAttribute(){
        $idModal = "W".$this->idWilayah;
        return $idModal;
    }
}
