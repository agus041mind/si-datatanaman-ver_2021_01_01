<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Suku</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Ubah Suku
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

            <form action="{{route('adminSukuUbah',$suku->idSuku)}}" method="post">
            @csrf
              <!-- Hidden -->
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="sukuHidden" value="{{$suku->nama}}">
              </div>
              <!-- Hidden -->
              <div class="form-group">
                <label for="bangsa">Bangsa</label>
                <select class="form-control select2Sindata" name="bangsa">
                  @foreach($ordo as $item)
                  <option value="{{$item->idOrdo}}" {{$suku->idOrdo == $item->idOrdo ? "selected=''" : ""}}>
                  D:{{$item->kelas->subDivisi->divisi->nama}} ~ SD:{{$item->kelas->subDivisi->nama}} ~ K:{{$item->kelas->nama}} ~ B:{{$item->nama}}
                  </option>
                  @endforeach
                </select>
                <small id="bangsaHelp" class="form-text text-muted">D:Divisi ~ SD:SubDivisi ~ K:Kelas ~ B:Bangsa</small>
              </div>
              <div class="form-group">
                <label for="suku">Suku</label>
                <input class="form-control" type="text" placeholder="" name="suku" value="{{$suku->nama}}">
              </div>
              <div class="form-group">
                <label for="singkatan">Singkatan</label>
                <input class="form-control" type="text" placeholder="" name="singkatan" value="{{$suku->singkatan}}">
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminSuku')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection