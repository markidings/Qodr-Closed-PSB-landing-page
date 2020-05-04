@extends('layouts.admin')

@section('title', 'Akikahkita | Tambah Konfirmasi Bayar')
@section('content-title', 'Tambah Konfirmasi Bayar')

@push('css')
<link href="{{ asset('/extra-libs/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Konfirmasi Bayar</h4>
                <div>
                    <a href="{{ route('purchase-confirms.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('purchase-confirms.store') }}"
                    method="POST"
                >
                @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>No Nota</label>
                                    <select name="booking_id" class="form-control select2">
                                        @foreach ($bookings as $booking)
                                            <option value="{{ $booking->id }}">{{ $booking->no_nota }}, {{ $booking->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('no_nota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input
                                        type="number"
                                        name="nominal"
                                        min="0"
                                        required
                                        class="form-control @error('nominal') is-invalid @enderror"
                                        placeholder="Nominal pembayaran..."
                                        value="{{ old('nominal') }}"
                                    />
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

@push('js')
<script src="{{ asset('/extra-libs/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
