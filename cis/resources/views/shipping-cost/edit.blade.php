@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Biaya Pengiriman Mitra')
@section('content-title', 'Edit Biaya Pengiriman Mitra')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card"> 
                <div class="card-body">
                    <h4 class="card-title">Edit Biaya Pengiriman Mitra</h4>
                    <div>
                        <a href="{{ route('shipping-cost') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                    </div>
                    <form class="mt-5"
                        action="{{ route('shipping-cost.update') }}"
                        method="POST"
                    >
                    @csrf
                    @method('PUT')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dalam Kota</label>
                                        <input
                                            name="in_city_cost"
                                            type="number"
                                            class="form-control @error('in_city_cost') is-invalid @enderror"
                                            required
                                            min="0"
                                            placeholder="Biaya dalam kota..."
                                            value="{{ old('in_city_cost') ?? ($shippingCost ? $shippingCost->in_city_cost : 0) }}"
                                        />
                                        @error('in_city_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Luar Kota</label>
                                        <input
                                            name="out_city_cost"
                                            type="number"
                                            class="form-control @error('out_city_cost') is-invalid @enderror"
                                            required
                                            min="0"
                                            placeholder="Biaya luar kota..."
                                            value="{{ old('out_city_cost') ?? ($shippingCost ? $shippingCost->out_city_cost : 0) }}"
                                        />
                                        @error('out_city_cost')
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
