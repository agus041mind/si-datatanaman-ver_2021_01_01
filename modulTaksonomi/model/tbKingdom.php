<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbKingdom extends Model
{
    protected $table = 'tb_kingdom';
    protected $primaryKey = 'idKingdom';
    
    public function divisi(){
        return $this->hasMany('App\tbDivisi','idKingdom');
    }
}
