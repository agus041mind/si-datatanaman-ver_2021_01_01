<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbKolektor extends Model
{
    protected $table = 'tb_kolektor';
    protected $primaryKey = 'idKolektor';
    protected $keyType = 'string';
    public $incrementing = false;

    public function detailPenerimaan(){
        return $this->hasMany('App\tbDetailPenerimaan','idKolektor');
    }
    public function herbariumData(){
        return $this->hasMany('App\tbHerbariumData','idKolektor');
    }
}
