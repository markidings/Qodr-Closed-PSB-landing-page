@extends('layouts.admin')

@section('title', 'Akikahkita | Tambah Prospek')
@section('content-title', 'Tambah Prospek')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Prospek</h4>
                <div>
                    <a href="{{ route('prospects.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('prospects.store') }}"
                    method="POST"
                >
                @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input
                                        name="name"
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        required
                                        placeholder="Nama..."
                                        value="{{ old('name') }}"
                                    />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input
                                        name="phone_number"
                                        type="text"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        required
                                        placeholder="No HP..."
                                        value="{{ old('phone_number') }}"
                                    />
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Perkiraan</label>
                                    <input
                                        name="estimated_date"
                                        type="date"
                                        class="form-control @error('estimated_date') is-invalid @enderror"
                                        required
                                        placeholder="Tanggal perkiraan..."
                                        value="{{ old('estimated_date') }}"
                                    />
                                    @error('estimated_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input
                                                    type="radio"
                                                    class="custom-control-input"
                                                    id="delay"
                                                    name="status"
                                                    value="delay"
                                                    checked
                                                />
                                                <label class="custom-control-label" for="delay">Delay</label>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input
                                                    type="radio"
                                                    class="custom-control-input"
                                                    id="success"
                                                    name="status"
                                                    value="success"
                                                />
                                                <label class="custom-control-label" for="success">Sukses</label>
                                            </div>
                                        </div>
                                    </div>
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
