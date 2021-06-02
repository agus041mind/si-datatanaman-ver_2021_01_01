<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bangsa</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Ubah Bangsa
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

            <form action="{{route('adminOrdoUbah',$ordo->idOrdo)}}" method="post">
            @csrf
              <!-- Hidden -->
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="bangsaHidden" value="{{$ordo->nama}}">
              </div>
              <!-- Hidden -->
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <select class="form-control select2Sindata" name="kelas">
                  @foreach($kelas as $item)
                  <option value="{{$item->idKelas}}" {{$ordo->idKelas == $item->idKelas ? "selected=''" : ""}}>
                  D:{{$item->subDivisi->divisi->nama}} ~ SD:{{$item->subDivisi->nama}} ~ K:{{$item->nama}}
                  </option>
                  @endforeach
                </select>
                <small id="kelasHelp" class="form-text text-muted">D:Divisi ~ SD:SubDivisi ~ K:Kelas</small>
              </div>
              <div class="form-group">
                <label for="bangsa">Bangsa</label>
                <input class="form-control" type="text" placeholder="" name="bangsa" value="{{$ordo->nama}}">
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminOrdo')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection