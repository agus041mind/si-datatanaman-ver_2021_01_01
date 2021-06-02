<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Lokasi Eksplorasi</h1>
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
              <a href="{{route('adminLokasiTambah')}}">
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
                      <th>Kab./ Kota</th>
                      <th>Provinsi</th>
                      <th>Pulau</th>
                      <th>Negara</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot class="text-center bg-dark text-light">
                    <tr>
                      <th>Kab./ Kota</th>
                      <th>Provinsi</th>
                      <th>Pulau</th>
                      <th>Negara</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($lokasi as $item)
                    <tr>
                      <td>{{$item->kab_kota}}</td>
                      <td>{{$item->provinsi}}</td>
                      <td>{{$item->pulau}}</td>
                      <td>{{$item->negara}}</td>
                      <td class="text-center">
                        <a href="{{route('adminLokasiTampil',$item->idLokasi)}}">
						              <button type="button" class="btn btn-sm btn-warning" >
						              <i class='fas fa-edit'></i> Ubah
						              </button>
					              </a>
                      </td>
                      <td class="text-center">
                        <a href="{{route('adminLokasiHapus',$item->idLokasi)}}">
						              <button type="button" class="btn btn-sm btn-danger" onClick="return confirm('Yakin mau dihapus?')" 
                          {{($item->penerimaan->count() == null || $item->penerimaan->count() == 0) ? "" : "disabled"}}
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