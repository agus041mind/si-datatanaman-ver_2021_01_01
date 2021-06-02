<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vak</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Tambah Vak
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

            <form action="{{route('adminVakSimpan')}}" method="post">
            @csrf
              <div class="form-group">
                <label for="lingkungan">Lingkungan</label>
                <select class="form-control select2Sindata" name="lingkungan">
                  @foreach($lingkungan as $item)
                  <option value="{{$item->idLingkungan}}" {{$item->idLingkungan==old('lingkungan') ? "selected=''" : ""}}>{{$item->nama}}</option>
                  @endforeach
                </select>
              </div>              
              <div class="form-group">
                <label for="vak">Vak</label>
                <input class="form-control" type="text" placeholder="" name="vak" value="{{old('vak')}}">
              </div>
              <div class="form-group">
                <label for="perawat">Perawat</label>
                <input class="form-control" type="text" placeholder="" name="perawat" value="{{old('perawat')}}">
              </div>
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" rows="3" name="keterangan">{{old('keterangan')}}</textarea>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminVak')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection