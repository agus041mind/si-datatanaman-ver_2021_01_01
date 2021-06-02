<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kolektor</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Tambah Kolektor
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

            <form action="{{route('adminKolektorSimpan')}}" method="post">
            @csrf
              
              <div class="form-group">
              <label for="jenis">Jenis</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis" id="jenis1" value="1" {{old('jenis')=='1' ? "checked=''" : ""}} onClick="
                javascript:document.getElementById('kodeSindata').readOnly=false;
                document.getElementById('kodeKolektor').readOnly=false;
                document.getElementById('kodeSindata').value='';
                document.getElementById('kodeKolektor').value='';
                ">
                <label class="form-check-label" for="jenis1">
                    Bukan donor
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis" id="jenis2" value="2" {{old('jenis')=='2' ? "checked=''" : ""}} onClick="
                    javascript:document.getElementById('kodeSindata').readOnly=true;
                    document.getElementById('kodeKolektor').readOnly=true;
                    document.getElementById('kodeSindata').value='{{Sindata::idKolektor('donor')}}';
                    document.getElementById('kodeKolektor').value='{{Sindata::idKolektor('donor')}}';
                ">
                <label class="form-check-label" for="jenis2">
                    Donor
                </label>
              </div>
              </div>              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="kodeSindata">Kode Sindata</label>
                    <input class="form-control" type="text" placeholder="" name="kodeSindata" id="kodeSindata" value="{{old('kodeSindata')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="kodeKolektor">Kode Kolektor</label>
                    <input class="form-control" type="text" placeholder="" name="kodeKolektor" id="kodeKolektor" value="{{old('kodeKolektor')}}">
                </div>
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input class="form-control" type="text" placeholder="" name="nama" value="{{old('nama')}}">
              </div>
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" rows="3" name="keterangan">{{old('keterangan')}}</textarea>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminKolektor')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection