<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jenis</h1>
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
              <a href="{{route('adminJenisTambah')}}">
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
                      <th>Nama</th>
                      <th>Suku</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot class="text-center bg-dark text-light">
                    <tr>
                      <th>Nama</th>
                      <th>Suku</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($jenis as $item)
                    <tr>
                      <td><i>{{$item->marga->nama}} {{$item->nama}}</i> {{$item->authorJenis->nama}} <i>{{$item->subJenis}}</i> {{$item->authorSubJenis->nama}}</td>
                      <td>{{$item->marga->suku->nama}}</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#{{$item->idJenis}}">
                        <i class='fas fa-info'></i> Info
                        </button>
                      </td>
                      <td class="text-center">
                        <a href="{{route('adminJenisTampil',$item->idJenis)}}">
						              <button type="button" class="btn btn-sm btn-warning" 
                          {{($item->ubahNama->count() == null || $item->ubahNama->count() == 0) ? "" : "disabled"}}
                          >
						              <i class='fas fa-edit'></i> Ubah
						              </button>
					              </a>
                      </td>
                      <td class="text-center">
                        <a href="{{route('adminJenisHapus',$item->idJenis)}}">
						              <button type="button" class="btn btn-sm btn-danger" onClick="return confirm('Yakin mau dihapus?')" 
                          {{(
                             ($item->detailPenerimaan->count() == null || $item->detailPenerimaan->count() == 0) && ($item->ubahNama->count() == null || $item->ubahNama->count() == 0) && ($item->herbariumJenis->count() == null || $item->herbariumJenis->count() == 0)
                               ) ? "" : "disabled"}}
                          >
						              <i class='fas fa-trash'></i> Hapus
						              </button>
					              </a>
                      </td>
                    </tr>

<!-- Modal -->
<div class="modal fade" id="{{$item->idJenis}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <b>Nama Tanaman</b><br>
        <i>{{$item->marga->nama}} {{$item->nama}}</i> {{$item->authorJenis->nama}} <i>{{$item->subJenis}}</i> {{$item->authorSubJenis->nama}}<p><p>
      <b>Kegunaan</b><br>
        {{($item->ItemKegunaan <> '') ? $item->ItemKegunaan : ''}}<p>
      <b>Persebaran</b><br>
        {{$item->distribusi}}<p>
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