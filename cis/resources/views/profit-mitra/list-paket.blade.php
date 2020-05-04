@extends('layouts.admin')

@section('title', 'Akikahkita | Profit Mitra')
@section('content-title', 'Profit Mitra')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row"> 
        <div class="col-12">
            <div class="card"> 
                <div class="card-body">
                    <h4 class="card-title">Profit Mitra</h4>
                    <div>
                        <a href="{{ route('profitMitra.index') }}" class="btn btn-success btn-sm mt-3"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="table-responsive mt-5">
                        <table id="profitTable" class="table">
                            <thead> 
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col">Harga Jantan</th>
                                    <th scope="col">Harga Betina</th>
                                    <th scope="col">Profit Jantan</th>
                                    <th scope="col">Profit Betina</th>
                                    <th scope="col">Aksi</th>    
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($pakets))
                                <tr>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                </tr>
                                @else
                                    <?php $no=1; ?>
                                    @foreach ($pakets as $paket)
                                        <tr> 
                                            <td>{{ $no }}</td>
                                            <?php $no++ ?>
                                            <td>{{ $paket->nama }}</td>
                                            <td>@currency($paket->harga)</td>
                                            <td>@currency($paket->price)</td>
                                            <td>
                                                @if (!$paket->profitMitra)
                                                <p>Belum ada data</p>
                                                @else
                                                @currency($paket->profitMitra['profit_male'])
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$paket->profitMitra)
                                                <p>Belum ada data</p>
                                                @else
                                                @currency($paket->profitMitra['profit_female'])
                                                @endif
                                            </td>
                                            {{-- <td>{{ ($paket->profitMitra) ? $paket->profitMitra['profit_percent'] : "Belum ada data" }}</td> --}}
                                            {{-- <td>{{ ($paket->profitMitra) ? $paket->profitMitra['mitra_income'] : "Belum ada data" }}</td> --}}
                                            {{-- <td>
                                                @if (!$paket->profitMitra)
                                                <p>Belum ada data</p>
                                                @else
                                                @currency($paket->profitMitra['mitra_income'])
                                                @endif
                                            </td> --}}
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-success"
                                                    data-toggle="modal" data-target="#modal-detail"
                                                    onclick="setInfoModal({{ $paket->id }})"
                                                >Detail</button>
                                                <button
                                                    class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#modal-detail-setting"
                                                    onclick="setInfoModal({{ $paket->id }})"
                                                >Setting Profit</button>

                                                <div id="detailInfoID-{{ $paket->id }}" paket_id="{{ $paket->id }}" detail_harga="{{$paket->harga}}" detail_price="{{$paket->price}}"
                                                    city_id="{{ $paket->city->id }}" percentMale="{{ $paket->profitMitra['percent_male'] }}" percentFemale="{{ $paket->profitMitra['percent_female'] }}"
                                                    nominalMale="{{ $paket->profitMitra['profit_male'] }}" nominalFemale="{{ $paket->profitMitra['profit_female'] }}" incomeMale="{{ $paket->profitMitra['income_male'] }}"
                                                    incomeFemale="{{ $paket->profitMitra['income_female'] }}" paket="{{ $paket->profitMitra['paket_id'] }}"
                                                ></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Modal Detail -->
            <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content"> 
                        <div class="modal-header">
                            <h3 class="bold">Detail Profit</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class=" modal-body"> 
                            <div class=" row text-capitalize">
                                <div class="col-md-6">
                                        <label class="font-weight-bold">Harga Paket Jantan</label>
                                        <p id="modaldetailharga"></p>
                                </div>
                                <div class="col-md-6">
                                        <label class="font-weight-bold">Harga Paket Betina</label>
                                        <p id="modaldetailprice"></p>
                                </div>
                            </div>
                            <div class="show_male row text-capitalize">
                                <div class="col-md-4">
                                        <label class="font-weight-bold">Pendapatan Mitra Dari Kambing Jantan</label>
                                        <p id="modalincomemale"></p>
                                </div>
                                <div class="col-md-4">
                                        <label class="font-weight-bold">Profit *</label>
                                        <p id="modalnominalmale"></p>
                                </div>
                                <div class="col-md-4">
                                        <label class="font-weight-bold">% Profit *</label>
                                        <p id="modalpercentmale"></p>
                                </div>
                            </div>
                            <div class="show_female row text-capitalize">
                                <div class="col-md-4">
                                        <label class="font-weight-bold">Pendapatan Mitra Dari Kambing Betina</label>
                                        <p id="modalincomefemale"></p>
                                </div>
                                <div class="col-md-4">
                                        <label class="font-weight-bold">Profit *</label>
                                        <p id="modalnominalfemale"></p>
                                </div>
                                <div class="col-md-4">
                                        <label class="font-weight-bold">% Profit *</label>
                                        <p id="modalpercentfemale"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Setting -->
        <div class="modal fade" id="modal-detail-setting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <h3 class="bold">Setting Profit</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class=" modal-body"> 
                            <form class="mt-5" id="link" action="{{ route('profitMitra.store') }}" method="post" enctype="multipart/form-data">
                    
                        @csrf
                        <div class="row text-capitalize">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Paket Jantan</label>
                                    <input name="male_price" id="male_price" type="text" class="form-control @error('male_price') is-invalid @enderror" readonly placeholder="Harga Paket..."/>
                                    @error('male_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Paket Betina</label>
                                    <input name="female_price" id="female_price" type="text" class="form-control @error('female_price') is-invalid @enderror" readonly placeholder="Harga Paket..."/>
                                    @error('female_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="show_male row text-capitalize" id="show_male">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pendapatan Mitra Dari Kambing Jantan</label>
                                    {{-- <input type="text" value="{{$pakets->keterangan}}"> --}}
                                    <input name="income_male" type="text" id="income_male" class="form-control @error('income_male') is-invalid @enderror" readonly placeholder="Harga Jual..." />
                                    @error('income_male')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Profit *</label>
                                    <input name="profit_male" type="number" id="profit_male" class="countprofitmale form-control @error('profit_male') is-invalid @enderror" required placeholder="Nominal Profit..." />
                                    @error('profit_male')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>% Profit *</label>
                                    <input name="percent_male" type="number" step="any" id="percent_male" class=" countpercentmale form-control @error('percent_male') is-invalid @enderror" required placeholder="Percent Profit..." />
                                    @error('percent_male')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <input name="paket_id" id="paket_id" type="hidden" class="form-control @error('paket_id') is-invalid @enderror">
                                    <input name="city_id" id="city_id" type="hidden" class="form-control @error('city_id') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                        <div class="show_female row text-capitalize" id="show_female">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pendapatan Mitra Dari Kambing Betina</label>
                                    <input name="income_female" type="text" id="income_female" class="form-control @error('income_female') is-invalid @enderror" readonly placeholder="Harga Jual..." />
                                    @error('income_female')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Profit *</label>
                                    <input name="profit_female" type="number" id="profit_female" class="countprofitfemale form-control @error('profit_female') is-invalid @enderror" required placeholder="Nominal Profit..." />
                                    @error('profit_female')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>% Profit *</label>
                                    <input name="percent_female" type="number" step="any" id="percent_female" class=" countpercentfemale form-control @error('percent_female') is-invalid @enderror" required placeholder="Percent Profit..." />
                                    @error('percent_female')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <h4 class="bold">Anda yakin ingin menambahkan profit?</h4>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Confirm!</button>
                        </form>
                    </div>
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

    function setInfoModal(_detailID) {
                const divDetailInfoID = document.getElementById(`detailInfoID-${_detailID}`);
                const paket_id = divDetailInfoID.getAttribute('paket_id');
                const detail_harga = divDetailInfoID.getAttribute('detail_harga');
                const detail_price = divDetailInfoID.getAttribute('detail_price');
                const city_id = divDetailInfoID.getAttribute('city_id');
                const percent_male = divDetailInfoID.getAttribute('percentMale');
                const percent_female = divDetailInfoID.getAttribute('percentFemale');
                const nominal_male = divDetailInfoID.getAttribute('nominalMale');
                const nominal_female = divDetailInfoID.getAttribute('nominalFemale');
                const income_male = divDetailInfoID.getAttribute('incomeMale');
                const income_female = divDetailInfoID.getAttribute('incomeFemale');
                const paket = divDetailInfoID.getAttribute('paket');
            
                const modaldetailharga = document.getElementById('modaldetailharga');
                const modaldetailprice = document.getElementById('modaldetailprice');
                const modalpercentmale = document.getElementById('modalpercentmale');
                const modalnominalmale = document.getElementById('modalnominalmale');
                const modalincomemale = document.getElementById('modalincomemale');
                const modalpercentfemale = document.getElementById('modalpercentfemale');
                const modalnominalfemale = document.getElementById('modalnominalfemale');
                const modalincomefemale = document.getElementById('modalincomefemale');

                modaldetailharga.innerHTML = detail_harga;
                modaldetailprice.innerHTML = detail_price;
                modalpercentmale.innerHTML = percent_male;
                modalnominalmale.innerHTML = nominal_male;
                modalincomemale.innerHTML = income_male;
                modalpercentfemale.innerHTML = percent_female;
                modalnominalfemale.innerHTML = nominal_female;
                modalincomefemale.innerHTML = income_female;
                
                
                
                // const harga_paket = document.getElementById('harga_paket');
                if (paket) {  
                    var gabung = "/dashboard/list/update/"+paket;
                    $("#link").attr("action",gabung)
                }

                // harga_paket.innerHTML = detail_harga;
                if(detail_harga == '' ){
                    $(".show_male").hide();
                    $("#percent_male").removeAttr('required');
                    $("#profit_male").removeAttr('required');
                }else{
                    $(".show_male").show();
                }
                if(detail_price == '' ){
                    $(".show_female").hide();
                    $("#percent_female").removeAttr('required');
                    $("#profit_female").removeAttr('required');
                }else{
                    $(".show_female").show();
                }
                $("#male_price").val(detail_harga)
                $("#female_price").val(detail_price)
                $("#paket_id").val(paket_id)
                $("#city_id").val(city_id) 
                $("#profit_male").val(nominal_male)
                $("#profit_female").val(nominal_female)
                $("#percent_male").val(percent_male)
                $("#percent_female").val(percent_female)
                $("#income_male").val(income_male)
                $("#income_female").val(income_female)
                $("#paket").val(paket)
                
            }
        // }
    </script>
    <script>
        $(document).ready(function(){
            // $('.numbers').keyup(function () { 
            //     this.value = this.value.replace(/[^0-9\.]/g,'');
            // });

            $(".countprofitmale").keyup(function(){
                let harga_paket = parseInt($("#male_price").val()) 
                let nominalprofit = parseInt($("#profit_male").val())
                let percent = nominalprofit * 100 / harga_paket || 0
                let countprofit = harga_paket - nominalprofit || harga_paket

                $("#income_male").val(countprofit)
                $("#percent_male").val(percent) 
 
            }); 
            
            $(".countpercentmale").keyup(function(){
                let harga_paket = parseInt($("#male_price").val()) 
                let percentprofit = parseInt($("#percent_male").val())
                
                let nominal = Math.round(percentprofit / 100 * harga_paket || 0)
                let countprofitp = harga_paket - nominal || harga_paket
                
                
                $("#income_male").val(countprofitp)
                $("#profit_male").val(nominal)
            });
            $(".countprofitfemale").keyup(function(){
                let harga_paket = parseInt($("#female_price").val()) 
                let nominalprofit = parseInt($("#profit_female").val())
                let percent = nominalprofit * 100 / harga_paket || 0
                let countprofit = harga_paket - nominalprofit || harga_paket

                $("#income_female").val(countprofit)
                $("#percent_female").val(percent) 
 
            }); 
            
            $(".countpercentfemale").keyup(function(){
                let harga_paket = parseInt($("#female_price").val()) 
                let percentprofit = parseInt($("#percent_female").val())
                
                let nominal = Math.round(percentprofit / 100 * harga_paket || 0)
                let countprofitp = harga_paket - nominal || harga_paket
                
                
                $("#income_female").val(countprofitp)
                $("#profit_female").val(nominal)
            });
        });
    </script>
    @endsection

@endsection
