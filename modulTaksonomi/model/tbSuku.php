<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbSuku extends Model
{
    protected $table = 'tb_suku';
    protected $primaryKey = 'idSuku';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['DetailPenerimaan','UbahNama','HerbariumJenis'];
    
    public function ordo(){
        return $this->belongsTo('App\tbOrdo','idOrdo');
    }
    public function marga(){
        return $this->hasMany('App\tbMarga','idSuku');
    }
    public function getDetailPenerimaanAttribute(){
        $jenisDP = DB::table('tb_detailpenerimaan')
        ->join('tb_jenis','tb_detailpenerimaan.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->where('tb_suku.idSuku','=',$this->idSuku)
        ->count();        
        return $jenisDP;
    }
    public function getUbahNamaAttribute(){
        $jenisUN = DB::table('tb_ubahnama')
        ->join('tb_jenis','tb_ubahnama.idJenisLama','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->where('tb_suku.idSuku','=',$this->idSuku)
        ->count();        
        return $jenisUN;
    }
    public function getHerbariumJenisAttribute(){
        $jenisHB = DB::table('tb_herbariumjenis')
        ->join('tb_jenis','tb_herbariumjenis.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->where('tb_suku.idSuku','=',$this->idSuku)
        ->count();        
        return $jenisHB;
    }
}
