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
              <h6 class="m-0 font-weight-bold text-primary">
              Tambah Lokasi Eksplorasi
              </h6>
            </div>
            <div class="card-body py-3">

            @if($errors->any())
              <div class="alert alert-danger" role="alert">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{route('adminLokasiSimpan')}}" method="post">
            @csrf
              <div class="form-group">
                <label for="kab_kota">Kab./ Kota</label>
                <input class="form-control" type="text" placeholder="" name="kab_kota" value="{{old('kab_kota')}}">
              </div>
              <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input class="form-control" type="text" placeholder="" name="provinsi" value="{{old('provinsi')}}">
              </div>
              <div class="form-group">
                <label for="pulau">Pulau</label>
                <input class="form-control" type="text" placeholder="" name="pulau" value="{{old('pulau')}}">
              </div>
              <div class="form-group">
                <label for="negara">Negara</label>
                <input class="form-control" type="text" placeholder="" name="negara" value="{{old('negara')}}">
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminLokasi')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection