<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbKelas extends Model
{
    protected $table = 'tb_kelas';
    protected $primaryKey = 'idKelas';
    protected $appends = ['DetailPenerimaan','UbahNama','HerbariumJenis'];
    
    public function subDivisi(){
        return $this->belongsTo('App\tbSubDivisi','idSubDivisi');
    }
    public function ordo(){
        return $this->hasMany('App\tbOrdo','idKelas');
    }
    public function getDetailPenerimaanAttribute(){
        $jenisDP = DB::table('tb_detailpenerimaan')
        ->join('tb_jenis','tb_detailpenerimaan.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->join('tb_kelas','tb_ordo.idKelas','=','tb_kelas.idKelas')
        ->where('tb_kelas.idKelas','=',$this->idKelas)
        ->count();        
        return $jenisDP;
    }
    public function getUbahNamaAttribute(){
        $jenisUN = DB::table('tb_ubahnama')
        ->join('tb_jenis','tb_ubahnama.idJenisLama','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->join('tb_kelas','tb_ordo.idKelas','=','tb_kelas.idKelas')
        ->where('tb_kelas.idKelas','=',$this->idKelas)
        ->count();        
        return $jenisUN;
    }
    public function getHerbariumJenisAttribute(){
        $jenisHB = DB::table('tb_herbariumjenis')
        ->join('tb_jenis','tb_herbariumjenis.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->join('tb_kelas','tb_ordo.idKelas','=','tb_kelas.idKelas')
        ->where('tb_kelas.idKelas','=',$this->idKelas)
        ->count();        
        return $jenisHB;
    }
}
