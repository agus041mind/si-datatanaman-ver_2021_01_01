<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbLokasi extends Model
{
    protected $table = 'tb_lokasi';
    protected $primaryKey = 'idLokasi';
    
    public function penerimaan(){
        return $this->hasMany('App\tbPenerimaan','idLokasi');
    }   
}
