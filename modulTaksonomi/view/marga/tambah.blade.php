<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Marga</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Tambah Marga
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

            <form action="{{route('adminMargaSimpan')}}" method="post">
            @csrf
              <div class="form-group">
                <label for="suku">Suku</label>
                <select class="form-control select2Sindata" name="suku">
                  @foreach($suku as $item)
                  <option value="{{$item->idSuku}}" {{$item->idSuku==old('suku') ? "selected=''" : ""}}>
                  D:{{$item->ordo->kelas->subDivisi->divisi->nama}} ~ SD:{{$item->ordo->kelas->subDivisi->nama}} ~ K:{{$item->ordo->kelas->nama}} ~ B:{{$item->ordo->nama}} ~ S:{{$item->nama}}
                  </option>
                  @endforeach
                </select>
                <small id="sukuHelp" class="form-text text-muted">D:Divisi ~ SD:SubDivisi ~ K:Kelas ~ B:Bangsa ~ S:Suku</small>
              </div>
              <div class="form-group">
                <label for="marga">Marga</label>
                <input class="form-control" type="text" placeholder="" name="marga" value="{{old('marga')}}">
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminMarga')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection