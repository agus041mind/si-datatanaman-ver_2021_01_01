<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbMaterial extends Model
{
    protected $table = 'tb_material';
    protected $primaryKey = 'idMaterial';

    public function detailPenerimaan(){
        return $this->hasMany('App\tbDetailPenerimaan','idMaterial');
    }
}
