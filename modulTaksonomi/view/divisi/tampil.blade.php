<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Divisi</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Ubah Divisi
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

            <form action="{{route('adminDivisiUbah',$divisi->idDivisi)}}" method="post">
            @csrf
              <!-- Hidden -->
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="divisiHidden" value="{{$divisi->nama}}">
              </div>
              <!-- Hidden -->
              <div class="form-group">
                <label for="divisi">Divisi</label>
                <input class="form-control" type="text" placeholder="" name="divisi" value="{{$divisi->nama}}">
              </div>
              <button type="submit" class="btn btn-primary">Ubah</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminDivisi')}}'">Batal</button>
            </form>

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection