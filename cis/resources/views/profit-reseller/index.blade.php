@extends('layouts.admin')

@section('title', 'Akikahkita | Profit Reseller')
@section('content-title', 'Profit Reseller')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Profit Reseller</h4>
                <div>
                    <a href="{{ route('profit.edit') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>
                </div>
                <div class="row mt-5"> 
                    <div class="col-md-6">
                        <p class="font-weight-bold">Nominal</p> 
                        @if (!$profitReseller)
                            <p>Belum ada data</p>
                        @else
                            <p>@currency($profitReseller->profit_nominal)</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p class="font-weight-bold">Percent</p>
                        @if (!$profitReseller)
                            <p>Belum ada data</p>
                        @else
                            <p>{{$profitReseller->profit_percent}}&nbsp;%</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
