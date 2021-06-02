<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jenis</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Tambah Jenis
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

            <form action="{{route('adminJenisSimpan')}}" method="post">
            @csrf
              <div class="form-group">
                <label for="marga">Marga</label>
                <select class="form-control select2Sindata" name="marga">
                  @foreach($marga as $item)
                  <option value="{{$item->idMarga}}" {{$item->idMarga==old('marga') ? "selected=''" : ""}}>
                  {{$item->nama}} ({{$item->suku->nama}})
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jenis">Jenis</label>
                    <input class="form-control" type="text" placeholder="" name="jenis" value="{{old('jenis')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="authorJenis">Author Jenis</label>
                    <select class="form-control select2Sindata" name="authorJenis">
                        @foreach($author as $item)
                        <option value="{{$item->idAuthor}}" {{$item->idAuthor==old('authorJenis') ? "selected=''" : ""}}>
                        {{($item->idAuthor == 'A0') ? "Tanpa Author" : $item->nama}}
                        </option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="subJenis">Sub Jenis</label>
                    <input class="form-control" type="text" placeholder="" name="subJenis" value="{{old('subJenis')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="authorSubJenis">Author Sub Jenis</label>
                    <select class="form-control select2Sindata" name="authorSubJenis">
                        @foreach($author as $item)
                        <option value="{{$item->idAuthor}}" {{$item->idAuthor==old('authorSubJenis') ? "selected=''" : ""}}>
                        {{($item->idAuthor == 'A0') ? "Tanpa Author" : $item->nama}}
                        </option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="kegunaan">Kegunaan</label>
                <select class="form-control select2Sindata" id="kegunaan" name="kegunaan[]" multiple="multiple">
                  @foreach($kegunaan as $item)
                  <option value="{{$item->nama}}" {{(collect(old('kegunaan'))->contains($item->nama)) ? "selected=''" : ""}}>
                  {{$item->nama}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="persebaran">Persebaran</label>
                    <textarea class="form-control" rows="3" name="persebaran">{{old('persebaran')}}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" rows="3" name="keterangan">{{old('keterangan')}}</textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminJenis')}}'">Batal</button>
            </form>            

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection