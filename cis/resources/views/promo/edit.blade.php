@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Promo')
@section('content-title', 'Edit Promo')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Promo</h4>
                <div>
                    <a href="{{ route('promos.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('promos.update', [
                        'promo' => $promo->id
                    ]) }}"
                    method="POST"
                >
                @csrf
                @method('PUT')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input
                                        name="code"
                                        type="text"
                                        class="form-control @error('code') is-invalid @enderror"
                                        required
                                        placeholder="Kode promo..."
                                        value="{{ old('code') ?? $promo->code }}"
                                    />
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea
                                        name="description"
                                        required
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Deskripsi snack..."
                                        rows="3"
                                    >{{ old('description') ?? $promo->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input
                                        name="start_date"
                                        type="date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        required
                                        placeholder="Nama snack..."
                                        value="{{ old('start_date') ?? $promo->start_date }}"
                                    />
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input
                                        name="end_date"
                                        type="date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        required
                                        placeholder="Nama snack..."
                                        value="{{ old('end_date') ?? $promo->end_date }}"
                                    />
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Promo</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input
                                                    type="radio"
                                                    class="custom-control-input"
                                                    id="price"
                                                    name="type"
                                                    value="price"
                                                    {{ ($promo->type == 'price') ? 'checked' : '' }}
                                                />
                                                <label class="custom-control-label" for="price">Harga</label>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input
                                                    type="radio"
                                                    class="custom-control-input"
                                                    id="percent"
                                                    name="type"
                                                    value="percent"
                                                    {{ ($promo->type == 'percent') ? 'checked' : '' }}
                                                />
                                                <label class="custom-control-label" for="percent">Percent</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nominal Diskon</label>
                                    <input
                                        name="discount_amount"
                                        type="number"
                                        min="0"
                                        class="form-control @error('discount_amount') is-invalid @enderror"
                                        required
                                        placeholder="Nominal diskon..."
                                        value="{{ old('discount_amount') ?? $promo->discount_amount }}"
                                    />
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-5">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
