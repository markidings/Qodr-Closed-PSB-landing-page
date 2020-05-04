@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Konfirmasi Bayar')
@section('content-title', 'Edit Konfirmasi Bayar')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Konfirmasi Bayar</h4>
                <div>
                    <a href="{{ route('purchase-confirms-partner.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('purchase-confirms-partner.update', [
                        'purchase_confirms_partner' => $purchase_confirms_partner->id
                    ]) }}"
                    method="POST"
                >
                @csrf
                @method('PUT')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>No Nota</label>
                                    <p>{{ $purchase_confirms_partner->no_nota }}</p>
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
                                        value=""
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
