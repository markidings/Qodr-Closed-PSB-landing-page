@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Akun Bank')
@section('content-title', 'Edit Akun Bank')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Akun Bank</h4>
                    <div>
                        <a href="{{ route('setting.bank-account') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                    </div>
                    <form class="mt-5"
                        action="{{ route('setting.bank-account.update') }}"
                        method="POST"
                    >
                    @csrf
                    @method('PUT')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bank</label>
                                        <input
                                            name="bank"
                                            type="text"
                                            class="form-control @error('bank') is-invalid @enderror"
                                            required
                                            placeholder="Nama bank..."
                                            value="{{ old('bank') ?? ($bankAccount ? $bankAccount->bank : '') }}"
                                        />
                                        @error('bank')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input
                                            name="name"
                                            type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            required
                                            placeholder="Nama pemilik rekening..."
                                            value="{{ old('name') ?? ($bankAccount ? $bankAccount->name : '') }}"
                                        />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>No Rekening</label>
                                        <input
                                            name="account_number"
                                            type="text"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            required
                                            placeholder="No rekening..."
                                            value="{{ old('account_number') ?? ($bankAccount ? $bankAccount->account_number : '') }}"
                                        />
                                        @error('account_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions mt-5">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
