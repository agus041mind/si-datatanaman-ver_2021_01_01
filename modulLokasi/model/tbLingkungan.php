<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbLingkungan extends Model
{
    protected $table = 'tb_lingkungan';
    protected $primaryKey = 'idLingkungan';
    protected $appends = 'IdModalBS';

    public function wilayah(){
        return $this->belongsTo('App\tbWilayah','idWilayah');
    }
    public function vak(){
        return $this->hasMany('App\tbVak','idLingkungan');
    }
    public function bibitDitanam(){
        return $this->hasManyThrough('App\tbBibitDitanam','App\tbVak','idLingkungan','idVak');
    }
    public function koleksi(){
        return $this->hasManyThrough('App\tbKoleksi','App\tbVak','idLingkungan','idVak');
    }
    public function relokasi(){
        return $this->hasManyThrough('App\tbRelokasi','App\tbVak','idLingkungan','idVakLama');
    }
    public function getIdModalBSAttribute(){
        $idModal = "L".$this->idLingkungan;
        return $idModal;
    }
}
