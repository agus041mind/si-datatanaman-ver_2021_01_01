<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbHabitus extends Model
{
    protected $table = 'tb_habitus';
    protected $primaryKey = 'idHabitus';

    public function detailPenerimaan(){
        return $this->hasMany('App\tbDetailPenerimaan','idHabitus');
    }
    public function herbariumData(){
        return $this->hasMany('App\tbHerbariumData','idHabitus');
    }
}
