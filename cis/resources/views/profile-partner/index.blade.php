@extends('layouts.admin')

@section('title', 'Akikahkita | Profil Mitra')
@section('content-title', 'Profil Mitra')

@push('css')
    <style>
    .img-profile-meta {
        height: 200px;
    }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Profil Mitra</h4>
                <div>
                    <a href="{{ route('profile-partner.edit') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <p class="font-weight-bold">Nama</p>
                        <p>{{ $partner->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="font-weight-bold">Email</p>
                        <p>{{ $partner->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="font-weight-bold">No Whatsapp</p>
                        <p>{{ $partner->no_whatsapp }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <p class="font-weight-bold">Alamat</p>
                        <p>{{ $partner->address }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="font-weight-bold">Kota</p>
                        <p>{{ $partner->city->name }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="font-weight-bold">Foto Profil</p>
                        <img src="{{ $partner->meta->profile_photo_url }}" alt="Foto profil" class="img-responsive img-profile-meta">
                    </div>
                    <div class="col-md-6">
                        <p class="font-weight-bold">Foto Kantor</p>
                        <img src="{{ $partner->meta->office_photo_url }}" alt="Foto kantor" class="img-responsive img-profile-meta">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="font-weight-bold">Foto Dapur</p>
                        <img src="{{ $partner->meta->kitchen_photo_url }}" alt="Foto dapur" class="img-responsive img-profile-meta">
                    </div>
                    <div class="col-md-6">
                        <p class="font-weight-bold">Foto Kandang</p>
                        <img src="{{ $partner->meta->shed_photo_url }}" alt="Foto kandang" class="img-responsive img-profile-meta">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
