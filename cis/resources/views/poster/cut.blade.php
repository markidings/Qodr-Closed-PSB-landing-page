@extends('layouts.no-header-sidebar.app-nodiv')

@section('title', 'Poster 2')
@section('content-title', 'Poster')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
	    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
@endpush


@section('content')
    <div class="row">
		<div class="imagepostercut">
            <div>
                <p class="cut">Nama Anak  : {{$booking->name_aqiqah}} bin {{$booking->name_father}}</p>
                <p class="cut">Nama Ayah : {{$booking->name_father}}</p>
                <p class="cut">Nama Ibu &nbsp;&nbsp;&nbsp;: {{$booking->name_mother}}</p>
                <p class="cut">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$booking->address}}</p>
            </div>
		</div>
    </div>
@endsection
