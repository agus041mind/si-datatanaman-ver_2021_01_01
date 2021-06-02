<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Habitus</h1>
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
              <a href="{{route('adminHabitusTambah')}}">
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
                      <th>Kode</th>
                      <th>Nama</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot class="text-center bg-dark text-light">
                    <tr>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($habitus as $item)
                    <tr>
                      <td>{{$item->kode}}</td>
                      <td>{{$item->nama}}</td>
                      <td class="text-center">
                        <a href="{{route('adminHabitusTampil',$item->idHabitus)}}">
						              <button type="button" class="btn btn-sm btn-warning" >
						              <i class='fas fa-edit'></i> Ubah
						              </button>
					              </a>
                      </td>
                      <td class="text-center">
                        <a href="{{route('adminHabitusHapus',$item->idHabitus)}}">
						              <button type="button" class="btn btn-sm btn-danger" onClick="return confirm('Yakin mau dihapus?')" 
                          {{(($item->detailPenerimaan->count() == null || $item->detailPenerimaan->count() == 0) && ($item->herbariumData->count() == null || $item->herbariumData->count() == 0)) ? "" : "disabled"}}
                          >
						              <i class='fas fa-trash'></i> Hapus
						              </button>
					              </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
          
    </div>
    <!-- End Main Content -->

@endsection