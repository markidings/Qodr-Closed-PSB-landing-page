@extends('layouts.no-header-sidebar.app-nodiv')

@section('title', 'Poster 1')
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
        <div class="imageposter">
            <p class="centered-element-poster poster">Alhamdulillah, Aqiqah anak kami :</p>
            <p class="centered-element-poster1 poster1">{{$booking->name_aqiqah}} bin {{$booking->name_father}}</p>
            <p class="centered-element-poster2 poster2">Kami mengharap doa Bapak/Ibu/Saudara/i, Semoga Allah menjadikan anak yang bermanfaat Aamiin Ya Robbal 'Aalaamin</p>
            <img class="imageposter img-fluid" src="{{asset('storage/images/poster/flower.jpg')}}" alt="Kartu" >
        </div>
    </div>
@endsection