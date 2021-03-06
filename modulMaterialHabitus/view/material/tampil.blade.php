<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Material</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Ubah Material
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

            <form action="{{route('adminMaterialUbah',$material->idMaterial)}}" method="post">
            @csrf
              <!-- Hidden -->
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="kodeHidden" value="{{$material->kode}}">
              </div>
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="materialHidden" value="{{$material->nama}}">
              </div>
              <!-- Hidden -->
              <div class="form-group">
                <label for="kode">Kode</label>
                <input class="form-control" type="text" placeholder="" name="kode" value="{{$material->kode}}">
              </div>
              <div class="form-group">
                <label for="material">Material</label>
                <input class="form-control" type="text" placeholder="" name="material" value="{{$material->nama}}">
              </div>
              <button type="submit" class="btn btn-primary">Ubah</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminMaterial')}}'">Batal</button>
            </form>

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection