@extends('layouts.admin')

@section('title', 'Akikahkita | Profit Reseller')
@section('content-title', 'Profit Reseller')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row"> 
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Profit Reseller</h4>
                    <div>
                            <a href="{{ route('profitReseller') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                        </div>
                                <form class="mt-5"
                                id="link"
                                action="{{ route('profitReseller.store') }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                            @csrf
                            {{-- @method('PUT') --}}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profit Nominal</label>
                                                <input
                                                    name="profit_nominal"
                                                    id="nominalprofit"
                                                    type="number"
                                                    class="countnominal form-control @error('in_city_cost') is-invalid @enderror"
                                                    required
                                                    min="0"
                                                    value="{{ old('profit_nominal') ?? ($profitReseller ? $profitReseller->profit_nominal : 0) }}"
                                                />
                                                @error('profit_nominal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profit Persen % </label>
                                                <input
                                                    name="profit_percent"
                                                    id="percentprofit"
                                                    type="number"
                                                    class="countpercent form-control @error('out_city_cost') is-invalid @enderror"
                                                    required
                                                    min="0"
                                                    value="{{ old('profit_percent') ?? ($profitReseller ? $profitReseller->profit_percent : 0) }}"
                                                />
                                                @error('profit_percent')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            <input type="hidden" id="id" value="{{ ($profitReseller ? $profitReseller->id : 0) }}">
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

    @section('scripts')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $('#profitTable').DataTable();
    </script>
    <script>
        $(document).ready(function(){
            let paket = $("#id").val()
            if (paket > 0) {  
                    var gabung = "/dashboard/update/"+paket;
                    $("#link").attr("action",gabung)
                }

                $(".countnominal").keyup(function(){
                $("#percentprofit").val(0) 
 
            }); 
            
            $(".countpercent").keyup(function(){
                $("#nominalprofit").val(0)
            });
        });
    </script>
    @endsection

@endsection
