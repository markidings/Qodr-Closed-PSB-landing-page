@extends('layouts.admin')

@section('title', 'Akikahkita | Setting Akun Bank')
@section('content-title', 'Setting Akun Bank')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Setting Akun Bank</h4>
                <div>
                    <a href="{{ route('setting.bank-account.edit') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12">
                        <p class="font-weight-bold">Bank</p>
                        @if (!$bankAccount)
                            <p>Belum ada data</p>
                        @else
                            <p>{{ $bankAccount->bank }}</p>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <p class="font-weight-bold">Nama</p>
                        @if (!$bankAccount)
                            <p>Belum ada data</p>
                        @else
                            <p>{{ $bankAccount->name }}</p>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <p class="font-weight-bold">Nomor Rekening</p>
                        @if (!$bankAccount)
                            <p>Belum ada data</p>
                        @else
                            <p>{{ $bankAccount->account_number }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
