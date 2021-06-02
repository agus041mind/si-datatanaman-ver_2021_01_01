<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbMarga extends Model
{
    protected $table = 'tb_marga';
    protected $primaryKey = 'idMarga';
    protected $keyType = 'string';
    public $incrementing = false;

    public function suku(){
        return $this->belongsTo('App\tbSuku','idSuku');
    }
    public function jenis(){
        return $this->hasMany('App\tbJenis','idMarga');
    }
    public function detailPenerimaan(){
        return $this->hasManyThrough('App\tbDetailPenerimaan','App\tbJenis','idMarga','idJenis');
    }
    public function ubahNama(){
        return $this->hasManyThrough('App\tbUbahNama','App\tbJenis','idMarga','idJenisLama');
    }
    public function herbariumJenis(){
        return $this->hasManyThrough('App\tbHerbariumJenis','App\tbJenis','idMarga','idJenis');
    }
}
