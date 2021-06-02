<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbJenis extends Model
{
    protected $table = 'tb_jenis';
    protected $primaryKey = 'idJenis';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'kegunaan' => 'array'
    ];
    protected $appends = 'ItemKegunaan';
    
    public function marga(){
        return $this->belongsTo('App\tbMarga','idMarga');
    }
    public function authorJenis(){
        return $this->belongsTo('App\tbAuthor','idAuthorJenis');
    }
    public function authorSubJenis(){
        return $this->belongsTo('App\tbAuthor','idAuthorSubJenis');
    }
    public function guna(){
        return $this->belongsTo('App\tbGuna','idGuna');
    }
    public function detailPenerimaan(){
        return $this->hasMany('App\tbDetailPenerimaan','idJenis');
    }
    public function photoJenis(){
        return $this->hasMany('App\tbPhotoJenis','idJenis');
    }
    public function ubahNama(){
        return $this->hasMany('App\tbUbahNama','idJenisLama');
    }
    public function herbariumJenis(){
        return $this->hasMany('App\tbHerbariumJenis','idJenis');
    }
    public function getItemKegunaanAttribute(){
        $item = "";
        if($this->kegunaan <> '' && $this->kegunaan <> null){
            $jml = count($this->kegunaan);
            $i = 1;
            foreach($this->kegunaan as $key => $value){
                if($i <> $jml){
                    $item .= $value.", ";        
                }else{
                    $item .= $value;
                }
                $i++;
            }    
        }
        return $item;
    }
}
