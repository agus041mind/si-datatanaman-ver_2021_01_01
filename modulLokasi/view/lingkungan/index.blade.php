<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Lingkungan</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              @if(Session::has('sessPesanSindata'))
              <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <i class="fas fa-check-circle"></i> {{Session::get('sessPesanSindata')}}
              </div>
              @endif
              <h6 class="m-0 font-weight-bold text-primary">
              <a href="{{route('adminLingkunganTambah')}}">
						    <button type="button" class="btn btn-sm btn-primary" >
						    <i class='fas fa-plus'></i> Tambah
						    </button>
					    </a>
              </h6>
            </div>
            <div class="card-body" style="color:#000000">
              <div class="table-responsive-xl">
                <table class="table table-bordered table-striped table-sm" id="tableSindata" width="100%" cellspacing="0" style="color:#000000">
                  <thead class="text-center bg-dark text-light">
                    <tr>
                      <th>Lingkungan</th>
                      <th>Wilayah</th>
                      <th>#</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot class="text-center bg-dark text-light">
                    <tr>
                      <th>Lingkungan</th>
                      <th>Wilayah</th>
                      <th>#</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($lingkungan as $item)
                    <tr>
                      <td>{{$item->nama}}</td>
                      <td>{{$item->wilayah->nama}}</td>
                      <td class="text-center">
                      @if($jmlLingkungan > 1)
                        @if($item->indek == Sindata::indekLingkungan('min'))
                          <button type="button" class="btn btn-sm btn-primary" onClick="window.location.href='{{route('adminLingkunganTurun',$item->idLingkungan)}}'"><i class='fas fa-caret-square-down'></i></button>
                        @elseif($item->indek == Sindata::indekLingkungan('mak'))
                          <button type="button" class="btn btn-sm btn-primary" onClick="window.location.href='{{route('adminLingkunganNaik',$item->idLingkungan)}}'"><i class='fas fa-caret-square-up'></i></button>
                        @else
                          <button type="button" class="btn btn-sm btn-primary" onClick="window.location.href='{{route('adminLingkunganTurun',$item->idLingkungan)}}'"><i class='fas fa-caret-square-down'></i></button>
                          <button type="button" class="btn btn-sm btn-primary" onClick="window.location.href='{{route('adminLingkunganNaik',$item->idLingkungan)}}'"><i class='fas fa-caret-square-up'></i></button>                        
                        @endif
                      @endif
                      </td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#{{$item->IdModalBS}}">
                        <i class='fas fa-info'></i> Info
                        </button>
                      </td>
                      <td class="text-center">
                        <a href="{{route('adminLingkunganTampil',$item->idLingkungan)}}">
						              <button type="button" class="btn btn-sm btn-warning" >
						              <i class='fas fa-edit'></i> Ubah
						              </button>
					              </a>
                      </td>
                      <td class="text-center">
                        <a href="{{route('adminLingkunganHapus',$item->idLingkungan)}}">
						              <button type="button" class="btn btn-sm btn-danger" onClick="return confirm('Yakin mau dihapus?')" 
                          {{(($item->bibitDitanam->count() == null || $item->bibitDitanam->count() == 0) && ($item->koleksi->count() == null || $item->koleksi->count() == 0) && ($item->relokasi->count() == null || $item->relokasi->count() == 0)) ? "" : "disabled"}}
                          >
						              <i class='fas fa-trash'></i> Hapus
						              </button>
					              </a>
                      </td>
                    </tr>

<!-- Modal -->
<div class="modal fade" id="{{$item->IdModalBS}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <b>Lingkungan</b><br>
        {{$item->nama}}<p><p>
      <b>Wilayah</b><br>
        {{$item->wilayah->nama}}<p><p>
      <b>Pengamat</b><br>
        {{$item->pengamat}}<p>
      <b>Keterangan</b><br>
        {{$item->keterangan}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
                    
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
          
    </div>
    <!-- End Main Content -->

@endsection