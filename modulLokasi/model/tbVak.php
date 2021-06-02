<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbVak extends Model
{
    protected $table = 'tb_vak';
    protected $primaryKey = 'idVak';
    protected $appends = 'IdModalBS';

    public function lingkungan(){
        return $this->belongsTo('App\tbLingkungan','idLingkungan');
    }
    public function bibitDitanam(){
        return $this->hasMany('App\tbBibitDitanam','idVak');
    }
    public function koleksi(){
        return $this->hasMany('App\tbKoleksi','idVak');
    }
    public function relokasi(){
        return $this->hasMany('App\tbRelokasi','idVakLama');
    }
    public function getIdModalBSAttribute(){
        $idModal = "V".$this->idVak;
        return $idModal;
    }
}
