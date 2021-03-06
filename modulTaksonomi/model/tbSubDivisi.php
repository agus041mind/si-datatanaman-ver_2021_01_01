<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbSubDivisi extends Model
{
    protected $table = 'tb_subdivisi';
    protected $primaryKey = 'idSubDivisi';
    protected $appends = ['DetailPenerimaan','UbahNama','HerbariumJenis'];
    
    public function divisi(){
        return $this->belongsTo('App\tbDivisi','idDivisi');
    }
    public function kelas(){
        return $this->hasMany('App\tbKelas','idSubDivisi');
    }
    public function getDetailPenerimaanAttribute(){
        $jenisDP = DB::table('tb_detailpenerimaan')
        ->join('tb_jenis','tb_detailpenerimaan.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->join('tb_kelas','tb_ordo.idKelas','=','tb_kelas.idKelas')
        ->join('tb_subdivisi','tb_kelas.idSubDivisi','=','tb_subdivisi.idSubDivisi')
        ->where('tb_subdivisi.idSubDivisi','=',$this->idSubDivisi)
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
        ->join('tb_subdivisi','tb_kelas.idSubDivisi','=','tb_subdivisi.idSubDivisi')
        ->where('tb_subdivisi.idSubDivisi','=',$this->idSubDivisi)
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
        ->join('tb_subdivisi','tb_kelas.idSubDivisi','=','tb_subdivisi.idSubDivisi')
        ->where('tb_subdivisi.idSubDivisi','=',$this->idSubDivisi)
        ->count();        
        return $jenisHB;
    }
}
