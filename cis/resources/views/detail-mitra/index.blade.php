@extends('layouts.no-header-sidebar.app-nodiv')

@section('title', 'Akikahkita | Detail Mitra')
@section('content-title', 'Detail Mitra')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
	    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
@endpush


@section('content')
<div class="container mt-5">
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header" style="background-image: url('public/images/bgfarm.jpg');">
        <div class="text-center">
          <div class="col-md-12 text-right">
           <button class="btn btn-warning btn-sm" onclick="goBack()">X Close</button>
          </div>
          <div class="row mt-3">  
              <div class="col-md-12">
                  <img src="{{ $partner->meta->profile_photo_url }}" alt="Foto profil" class="imagecenterprofile">
              </div>
          </div> 
        </div>
        <h1 class="text-center" style="color:black;"><b>{{ $partner->name }}</b></h1>
      </div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">No Telepon/HP</label>
            <input type="text" class="form-control" readonly value="{{$partner->no_whatsapp}}">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Regional</label>
            <input type="text" class="form-control" readonly value="{{$partner->city->name}}">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Alamat</label>
            <textarea class="form-control" readonly id="exampleFormControlTextarea1" rows="2">{{$partner->address}}</textarea>
          </div>
        </form>
        <div class="row mt-5"></div>
        <hr>
        <div class="text-center">
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Foto Kantor</h3>
                    <img src="{{ $partner->meta->office_photo_url }}" class="img-fluid mt-3" width="800px" alt="Responsive image">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Foto Dapur</h3>
                    <img src="{{ $partner->meta->kitchen_photo_url }}" class="img-fluid mt-3" width="800px" alt="Responsive image">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Foto Kandang</h3>
                    <img src="{{ $partner->meta->shed_photo_url }}" class="img-fluid mt-3" width="800px" alt="Responsive image">
                </div>
            </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="col-md-12 text-right">
          <button class="btn btn-warning btn-sm" onclick="goBack()">Kembali</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('js')
<script>
  function goBack() {
    window.history.back();
  }
</script>
@endpush