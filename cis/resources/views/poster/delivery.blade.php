@extends('layouts.no-header-sidebar.app-nodiv')

@section('title', 'Poster 3')
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
		<div class="posterdelivery">
            <div class="row">
                <div class="col-3">
                    <img src="{{asset('images/big/akikah_logo.jpg')}}" alt="Logo Akikah" class="imageakikah">
                </div>
                <div class="col-6">
                    <p class="high1">{{$booking->user->name}}</p>
                    <p class="high2">Akikahkita.com</p>
                    <p class="high3">{{$booking->user->address}}</p>
                </div>
                <div class="col-3">
                    <img src="{{$partner->meta->profile_photo_url}}" alt="Logo Akikah" class="imageakikah">
                </div>
            </div>
            <hr class="mt-2">
            <p class="text-delivery">Nama Konsumen : {{$booking->name}}</p>
            <p class="text-delivery">Tanggal : {{$booking->time_slaughter}}</p>
            <br>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Qtty</th>
                            <th scope="col">Nama Paket</th>
                            <th scope="col">Biaya</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">{{$booking->total_booking}}</th>
                            <td>{{$booking->packet->nama}}</td>
                            <td>@currency($booking->total_purchase)</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-2"></div>
            </div>
            <br>

            {{-- Snack --}}
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Qtty</th>
                            <th scope="col">Nama Snack</th>
                            <th scope="col">Biaya</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">{{ $booking->snack ? $booking->total_booking : 0 }}</th>
                            <td>{{ $booking->snack ? $booking->snack->name : '-'}}</td>
                            <?php if ($booking->snack !== null) { ?>
                                 <td>@currency($booking->snack->price)</td>
                            <?php } else { ?>
                                <td>-</td>
                            <?php  } ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-2"></div>
            </div>
            <br>

            <div class="row">
                <div class="col-6">
                    <p class="text-tanda-left">Tanda Terima</p>
                </div>
                <div class="col-6">
                    <p class="text-tanda-right">Tanda Tangan</p>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-12 text-center">*** Terima kasih atas kunjungan anda ***</div>
            </div>
		</div>
    </div>
@endsection
