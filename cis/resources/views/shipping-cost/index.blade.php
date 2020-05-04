@extends('layouts.admin')

@section('title', 'Akikahkita | Biaya Pengiriman Mitra')
@section('content-title', 'Biaya Pengiriman Mitra')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Biaya Pengiriman Mitra</h4>
                <div>
                    <a href="{{ route('shipping-cost.edit') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>
                </div>
                <div class="row mt-5"> 
                    <div class="col-md-6">
                        <p class="font-weight-bold">Dalam Kota</p> 
                        @if (!$shippingCost)
                            <p>Belum ada data</p>
                        @else
                            <p>{{ $shippingCost->in_city_cost_text }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p class="font-weight-bold">Luar Kota</p>
                        @if (!$shippingCost)
                            <p>Belum ada data</p>
                        @else
                            <p>{{ $shippingCost->out_city_cost_text }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
