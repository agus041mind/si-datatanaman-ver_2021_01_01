<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbAuthor extends Model
{
    protected $table = 'tb_author';
    protected $primaryKey = 'idAuthor';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['DetailPenerimaan','UbahNama','HerbariumJenis'];

    public function jenis(){
        return $this->hasMany('App\tbJenis','idAuthor');
    }
    public function getDetailPenerimaanAttribute(){
        $jenisDP = DB::table('tb_detailpenerimaan')
        ->join('tb_jenis','tb_detailpenerimaan.idJenis','=','tb_jenis.idJenis')
        ->join('tb_author',function($join){
            $join->on('tb_jenis.idAuthorJenis','=','tb_author.idAuthor');
            $join->orOn('tb_jenis.idAuthorSubJenis','=','tb_author.idAuthor');
        })
        ->where('tb_author.idAuthor','=',$this->idAuthor)
        ->count();        
        return $jenisDP;
    }
    public function getUbahNamaAttribute(){
        $jenisUN = DB::table('tb_ubahnama')
        ->join('tb_jenis','tb_ubahnama.idJenisLama','=','tb_jenis.idJenis')
        ->join('tb_author',function($join){
            $join->on('tb_jenis.idAuthorJenis','=','tb_author.idAuthor');
            $join->orOn('tb_jenis.idAuthorSubJenis','=','tb_author.idAuthor');
        })
        ->where('tb_author.idAuthor','=',$this->idAuthor)
        ->count();        
        return $jenisUN;
    }
    public function getHerbariumJenisAttribute(){
        $jenisHB = DB::table('tb_herbariumjenis')
        ->join('tb_jenis','tb_herbariumjenis.idJenis','=','tb_jenis.idJenis')
        ->join('tb_author',function($join){
            $join->on('tb_jenis.idAuthorJenis','=','tb_author.idAuthor');
            $join->orOn('tb_jenis.idAuthorSubJenis','=','tb_author.idAuthor');
        })
        ->where('tb_author.idAuthor','=',$this->idAuthor)
        ->count();        
        return $jenisHB;
    }
}
