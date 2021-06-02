<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbOrdo extends Model
{
    protected $table = 'tb_ordo';
    protected $primaryKey = 'idOrdo';
    protected $appends = ['DetailPenerimaan','UbahNama','HerbariumJenis'];

    public function kelas(){
        return $this->belongsTo('App\tbKelas','idKelas');
    }
    public function suku(){
        return $this->hasMany('App\tbSuku','idOrdo');
    }
    public function getDetailPenerimaanAttribute(){
        $jenisDP = DB::table('tb_detailpenerimaan')
        ->join('tb_jenis','tb_detailpenerimaan.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->where('tb_ordo.idOrdo','=',$this->idOrdo)
        ->count();        
        return $jenisDP;
    }
    public function getUbahNamaAttribute(){
        $jenisUN = DB::table('tb_ubahnama')
        ->join('tb_jenis','tb_ubahnama.idJenisLama','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->where('tb_ordo.idOrdo','=',$this->idOrdo)
        ->count();        
        return $jenisUN;
    }
    public function getHerbariumJenisAttribute(){
        $jenisHB = DB::table('tb_herbariumjenis')
        ->join('tb_jenis','tb_herbariumjenis.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->where('tb_ordo.idOrdo','=',$this->idOrdo)
        ->count();        
        return $jenisHB;
    }
}
