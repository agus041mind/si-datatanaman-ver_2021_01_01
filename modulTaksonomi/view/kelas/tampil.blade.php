<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelas</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Ubah Kelas
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

            <form action="{{route('adminKelasUbah',$kelas->idKelas)}}" method="post">
            @csrf
              <!-- Hidden -->
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="kelasHidden" value="{{$kelas->nama}}">
              </div>
              <!-- Hidden -->
              <div class="form-group">
                <label for="subDivisi">Sub Divisi</label>
                <select class="form-control select2Sindata" name="subDivisi">
                  @foreach($subDivisi as $item)
                  <option value="{{$item->idSubDivisi}}" {{$kelas->idSubDivisi == $item->idSubDivisi ? "selected=''" : ""}}>
                  D:{{$item->divisi->nama}} ~ SD:{{$item->nama}}
                  </option>
                  @endforeach
                </select>
                <small id="subDivisiHelp" class="form-text text-muted">D:Divisi ~ SD:SubDivisi</small>
              </div>
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <input class="form-control" type="text" placeholder="" name="kelas" value="{{$kelas->nama}}">
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminKelas')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection