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
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <span class="centered-element-tagline tagline">Akikah Kita</span>
      <p class="centered-element-desc">
          Menyediakan berbagai paket akikah untuk putera dan puteri Anda dengan harga bersaing. Langsung terhubung dengan mitra terbaik seluruh Indonesia!
      </p>
      <p class="centered-element-quality quality">Good Quality and Best Price!</p>
      <div class="carousel-item active"> 
      <img class="d-block w-100" src="{{asset('etalase-paket/wp-content/themes/BootSTheme/image/cute-baby-photo-shoot.jpg')}}" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="{{asset('etalase-paket/wp-content/themes/BootSTheme/image/tes2.jpg')}}" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="{{asset('etalase-paket/wp-content/themes/BootSTheme/image/s.jpg')}}" alt="Third slide">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div>
    <div class="text-center">
        <div class="row mt-3"> 
            <div class="col-md-12">
                <img src="{{ $partner->meta->profile_photo_url }}" alt="Foto profil" class="imagecenterprofile">
            </div>
        </div>
    </div>
    <p class="textcenter1">{{ $partner->name }}</p>
    <p class="textcenter">{{ $partner->address }}</p>
    <p class="textcenter">{{ $partner->city->name }}</p>
    <p class="textcenter">{{$partner->no_whatsapp}}</p>
    <div class="row mt-3">
        {{-- <div class="col-md-6">
            <p class="font-weight-bold">Foto Profil</p>
            <img src="{{ $partner->meta->profile_photo_url }}" alt="Foto profil" class="img-responsive img-profile-meta">
        </div> --}}
        {{-- <div class="col-md-3">
            <p class="font-weight-bold">Foto Kantor</p>   class="img-responsive img-profile-meta"
            <img src="{{ $partner->meta->office_photo_url }}" alt="Foto kantor" class="imagecenter ">
        </div> --}}
    </div>
    <div class="text-center">
        <div class="row mt-3">
            <div class="col-md-12">
                <p class="font-weight-bold">Foto Kantor</p>
                <img src="{{ $partner->meta->office_photo_url }}" alt="Foto kantor" class="imagecenter ">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <p class="font-weight-bold">Foto Dapur</p>
                <img src="{{ $partner->meta->kitchen_photo_url }}" alt="Foto dapur" class="imagecenter">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <p class="font-weight-bold">Foto Kandang</p>
                <img src="{{ $partner->meta->shed_photo_url }}" alt="Foto kandang" class="imagecenter">
            </div>
        </div>
    </div>
  </div>
  @endsection