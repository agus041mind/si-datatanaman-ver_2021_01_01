<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tbDivisi extends Model
{
    protected $table = 'tb_divisi';
    protected $primaryKey = 'idDivisi';
    protected $appends = ['DetailPenerimaan','UbahNama','HerbariumJenis'];
    
    public function kingdom(){
        return $this->belongsTo('App\tbKingdom','idKingdom');
    }
    public function subDivisi(){
        return $this->hasMany('App\tbSubDivisi','idDivisi');
    }
    public function getDetailPenerimaanAttribute(){
        $jenisDP = DB::table('tb_detailpenerimaan')
        ->join('tb_jenis','tb_detailpenerimaan.idJenis','=','tb_jenis.idJenis')
        ->join('tb_marga','tb_jenis.idMarga','=','tb_marga.idMarga')
        ->join('tb_suku','tb_marga.idSuku','=','tb_suku.idSuku')
        ->join('tb_ordo','tb_suku.idOrdo','=','tb_ordo.idOrdo')
        ->join('tb_kelas','tb_ordo.idKelas','=','tb_kelas.idKelas')
        ->join('tb_subdivisi','tb_kelas.idSubDivisi','=','tb_subdivisi.idSubDivisi')
        ->join('tb_divisi','tb_subdivisi.idDivisi','=','tb_divisi.idDivisi')
        ->where('tb_divisi.idDivisi','=',$this->idDivisi)
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
        ->join('tb_divisi','tb_subdivisi.idDivisi','=','tb_divisi.idDivisi')
        ->where('tb_divisi.idDivisi','=',$this->idDivisi)
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
        ->join('tb_divisi','tb_subdivisi.idDivisi','=','tb_divisi.idDivisi')
        ->where('tb_divisi.idDivisi','=',$this->idDivisi)
        ->count();        
        return $jenisHB;
    }
}
