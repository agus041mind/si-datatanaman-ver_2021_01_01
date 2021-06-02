<!-- Menghubungkan dengan view adMaster -->
@extends('masterPages.adMasterBS4')
 
@section('konten')

    <!-- Begin Main Content -->
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Habitus</h1>
        </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Ubah Habitus
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

            <form action="{{route('adminHabitusUbah',$habitus->idHabitus)}}" method="post">
            @csrf
              <!-- Hidden -->
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="kodeHidden" value="{{$habitus->kode}}">
              </div>
              <div class="form-group">
                <input class="form-control" type="hidden" placeholder="" name="habitusHidden" value="{{$habitus->nama}}">
              </div>
              <!-- Hidden -->
              <div class="form-group">
                <label for="kode">Kode</label>
                <input class="form-control" type="text" placeholder="" name="kode" value="{{$habitus->kode}}">
              </div>
              <div class="form-group">
                <label for="habitus">Habitus</label>
                <input class="form-control" type="text" placeholder="" name="habitus" value="{{$habitus->nama}}">
              </div>
              <button type="submit" class="btn btn-primary">Ubah</button>
              <button type="button" class="btn btn-primary" onClick="window.location.reload()">Reset</button>
              <button type="button" class="btn btn-primary" onClick="window.location.href='{{route('adminHabitus')}}'">Batal</button>
            </form>

            </div>
          </div>
          
    </div>
    <!-- End Main Content -->

@endsection