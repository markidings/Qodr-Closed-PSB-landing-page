@extends('layouts.admin')

@section('title', 'Akikahkita | Pemesanan')
@section('content-title', 'List Pemesanan')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <!-- STYLE CSS OPTION -->
    <link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
        <!-- Style Datepicker -->
    <link rel="stylesheet" href="{{asset('dist/css/jquery-ui.css')}}">
@endpush

@section('content')
    <div id="accordion"> 
        <div class="row">
            <div class="col-sm-4">
                <div class="card" style="width: 25rem;">
                    <div class="card-header" id="headingKu">
                        <h5 class="mb-0">
                            <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseKu" aria-expanded="true" aria-controls="collapseKu">
                                Saring Per Pekan
                            </button>
                        </h5>
                    </div>
                    <div id="collapseKu" class="collapse show" aria-labelledby="headingKu" data-parent="#accordion">
                        <div class="card-body">
                                <label for="sel1">Pilih&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                <input class="form-control-week-report1" id="datepickerweek" />
                                &nbsp; 
                                <label>Pekan : </label>
                                <input class="form-control-week-report2" name="weekNumber" id="weekNumber" readonly />
                                &nbsp;<br>
                                <label>Tahun : </label> 
                                <input class="form-control-week-year mt-2" name="yearNumberWeek" id="yearNumberWeek" readonly />
                                &nbsp;<br>
                                <button type="button" class="week mt-2 btn btn-primary">Info</button> 
                                &nbsp;
                                <span>* Dihitung per pekan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card" style="width: 25rem;">
                    <div class="card-header" id="heading2">
                        <h5 class="mb-0">
                            <button class="btn btn-primary" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                Saring Per Bulan
                            </button>
                        </h5>
                    </div>
                    <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                        <div class="card-body">
                                <label for="sel1">Pilih&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                <input class="form-control-week-report1" id="datepickermonth" />
                                &nbsp;
                                <label>Bulan : </label>
                                <input class="form-control-week-report2" name="monthNumber" id="monthNumber" readonly />
                                &nbsp;
                                <label>Tahun : </label> 
                                <input class="form-control-week-year mt-2" name="yearNumber" id="yearNumber" readonly />
                                &nbsp;<br>
                                <button type="button" class="month mt-2 btn btn-primary">Info</button> 
                                &nbsp;
                                <span>* Dihitung per bulan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card" style="width: 25rem;">
                    <div class="card-header" id="heading3">
                        <h5 class="mb-0">
                            <button class="btn btn-primary" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                Saring Per Hari
                            </button>
                        </h5>
                    </div>
                    <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
                        <div class="card-body">
                                <label for="sel1">Pilih:</label>
                                <input class="form-control-week-report1" name="time" id="datepickerday" />
                                &nbsp;<br> 
                                <button type="button" class="day mt-2 btn btn-primary">Info</button> 
                                &nbsp;
                                <span>* Dihitung per hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">  
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Laporan Profit Pemesanan Online</h4>
                    <div id="tampil" class="table-responsive mt-5">
                        <table class="bookingTable table">
                            <thead> 
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Mitra</th>
                                    <th scope="col">No Nota </th>
                                    <th scope="col">Total Biaya </th>
                                    <th scope="col">Total Pembayaran</th>
                                    <th scope="col">Akikahkita</th>
                                    <th scope="col">Mitra</th>
                                    <th scope="col">Mitra Profit</th>
                                    <th scope="col">Reseller</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @php $no = 0; @endphp
                                 @foreach ($booking as $bookings)
                                    <tr class='text-capitalize'>
                                        @php $no++ ;
                                        if ($bookings->status_transaction == 'offline mandiri') {
                                            $profit = 0;
                                        } else {
                                            if ($bookings->type_goat == 'male') {
                                                $profit = $bookings->profit_male;
                                            } else {
                                                $profit = $bookings->profit_female;
                                            }
                                        }
                                        $price = ($bookings->status_transaction == 'offline mandiri') ? $bookings->total_purchase : $bookings->total_purchase - $profit;
                                        // $profit = ($bookings->status_transaction == 'offline mandiri') ? 0 : $bookings->profit_nominal;
                                        
                                        @endphp
                                        <td>{{ $no }}.</td>
                                        <td>{{$bookings->user->name}}</td>
                                        <td>{{$bookings->no_nota}}</td>
                                        <td>@currency($bookings->total_purchase)</td>
                                        <td>@currency($bookings->nominal)</td>
                                        <td>@currency($profit)</td>
                                        <td>@currency(($price))</td>
                                        <td>
                                            @if ($bookings->deposit_status == 'done')
                                                <span class="badge badge-success">Sudah</span>
                                            @elseif ($bookings->deposit_status == 'no')
                                                <span class="badge badge-secondary">Tidak Ada</span>
                                            @elseif ($bookings->deposit_status == null)
                                                <span class="badge badge-danger">Belum</span>
                                            @endif
                                        </td>
                                        <td>-</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">  
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Laporan Profit Pemesanan Offline</h4>
                    <div id="tampil" class="table-responsive mt-5">
                        <table class="bookingTable2 table">
                            <thead> 
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Mitra</th>
                                    <th scope="col">No Nota </th>
                                    <th scope="col">Total Biaya </th>
                                    <th scope="col">Total Pembayaran</th>
                                    <th scope="col">Akikahkita</th>
                                    <th scope="col">Akikahkita Profit</th>
                                    <th scope="col">Mitra</th>
                                    <th scope="col">Mitra Profit</th>
                                    <th scope="col">Tipe Pembayaran</th>
                                    <th scope="col">Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @php $no = 0; @endphp
                                 @foreach ($bookingOffline as $bookingsoffline)
                                    <tr class='text-capitalize'>
                                        @php $no++ ;
                                        if ($bookingsoffline->status_transaction == 'offline mandiri') {
                                            $profit = 0;
                                        } else {
                                            if ($bookingsoffline->type_goat == 'male') {
                                                $profit = $bookingsoffline->profit_male;
                                            } else {
                                                $profit = $bookingsoffline->profit_female;
                                            }
                                        }
                                        $price = ($bookingsoffline->status_transaction == 'offline mandiri') ? $bookingsoffline->total_purchase : $bookingsoffline->total_purchase - $profit;
                                        $typepayment = ($bookingsoffline->type_payment == 'offline') ? 'cash' : 'transfer' ;
                                        @endphp
                                    <td>{{ $no }}.</td>
                                    <td>{{$bookingsoffline->user->name}}</td>
                                    <td>{{$bookingsoffline->no_nota}}</td>
                                    <td>@currency($bookingsoffline->total_purchase)</td>
                                    <td>@currency($bookingsoffline->nominal)</td>
                                    <td>@currency($profit)</td>
                                    <td>
                                        @if($typepayment == 'cash')
                                            @if ($bookingsoffline->deposit_status == 'done')
                                                <span class="badge badge-success">Sudah</span>
                                            @elseif ($bookingsoffline->deposit_status == 'no')
                                                <span class="badge badge-secondary">Tidak Ada</span>
                                            @elseif ($bookingsoffline->deposit_status == null)
                                                <span class="badge badge-danger">Belum</span>
                                            @endif
                                        @else
                                                <span class="badge badge-light">-</span>
                                        @endif
                                    </td>
                                    <td>@currency(($price))</td>
                                    <td>
                                        @if($typepayment == 'transfer')
                                            @if ($bookingsoffline->deposit_status == 'done')
                                                <span class="badge badge-success">Sudah</span>
                                            @elseif ($bookingsoffline->deposit_status == 'no')
                                                <span class="badge badge-secondary">Tidak Ada</span>
                                            @elseif ($bookingsoffline->deposit_status == null)
                                                <span class="badge badge-danger">Belum</span>
                                            @endif
                                        @else
                                                <span class="badge badge-light">-</span>
                                        @endif
                                    </td>
                                    <td>{{$typepayment}}</td>
                                    <td>
                                        {{$bookingsoffline->status_purchase}}
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    {{-- <script src="{{asset('dist/js/jquery-ui.js')}}"></script> --}}
            {{-- @section('scripts') --}}
        {{-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> --}}
    <script src="{{asset('dist/js/jquery-ui.js')}}"></script>
    <script>
        $('.bookingTable').DataTable();
        $('.bookingTableweek').DataTable();
        $('.bookingTable2').DataTable();
    </script>
    <script>
        $( "#datepickerweek" ).datepicker({ 
        onSelect: function (dateText, inst) {
                var d = new Date(dateText);
                year =  d.getFullYear();
                week = $.datepicker.iso8601Week(d);
                $("#weekNumber").val(week)
                $("#yearNumberWeek").val(year)
                
        }
        });

        $('.week').click(function() {

            var week = $("#weekNumber").val()
            var year = $("#yearNumberWeek").val()
            
                $.ajax({
                    type:"GET",
                    url:"/weeksortingprofit/"+week+"/"+year,
                    success: function(data) {
                        var myhtml = "";
                        let booking = data.booking
                        let profit = data.profit

                        if(data === 'Data tidak ditemukan'){
                            myhtml += 'Data tidak ditemukan';  
                        }  else {
                            myhtml += "<table class='table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Mitra</th><th scope='col'>No Nota</th><th scope='col'>Totl Biaya</th><th scope='col'>Total Bayar</th>"
                            myhtml += "<th scope='col'>AkikahKita</th><th scope='col'>Mitra</th><th scope='col'>Reseller</th></tr></thead><tbody>"
                            $.each(booking, function(i, item) {
                                // return console.log(item.purchase_confirm);
                                if (item.purchase_confirm == null) {
                                    var nominal = 'Belum Bayar'
                                } else {
                                    var nominal = item.purchase_confirm.nominal 
                                }
                                
                                myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.user.name +"</td><td>"+ item.no_nota +"</td><td>Rp. "+ item.total_purchase +"</td><td>Rp. "+  nominal +"</td>"
                                $.each(profit, function(index, itemprofit) {
                                        if (item.packet_id == itemprofit.paket_id){ 
                                            var pro =  itemprofit.paket_id 
                                            myhtml +=  "<td>Rp. "+ itemprofit.profit_nominal +"</td><td>Rp."+ (item.total_purchase - itemprofit.profit_nominal) +"</td><td>-</td></tr>"
                                            } 
                                    });
                            }); 
                            if (booking.length == 0) {
                                myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                            }
                            myhtml += "</tbody></table>"
                        }
                        $("#tampil").html(myhtml)
                    }
                });
            // To Stop the loading of page after a button is clicked
            return false;
            });         
    </script>
    <script>
        $( "#datepickermonth" ).datepicker({ 
        onSelect: function (dateText, inst) {
                var d = new Date(dateText);
                month = d.getMonth() + 1,
                year =  d.getFullYear();
            
                $("#monthNumber").attr("value",month) 
                $("#yearNumber").attr("value",year)
                
        }
        });

        $('.month').click(function() {

            var month = $("#monthNumber").val()
            var year = $("#yearNumber").val()
            
                $.ajax({
                    type:"GET",
                    url:"/sortingprofit/"+month+"/"+year,
                    success: function(data) {
                        var myhtml = "";
                            let booking = data.booking
                            let profit = data.profit

                            if(data === 'Data tidak ditemukan'){
                                myhtml += 'Data tidak ditemukan';  
                            }  else {
                                myhtml += "<table class='table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Mitra</th><th scope='col'>No Nota</th><th scope='col'>Totl Biaya</th><th scope='col'>Total Bayar</th>"
                                myhtml += "<th scope='col'>AkikahKita</th><th scope='col'>Mitra</th><th scope='col'>Reseller</th></tr></thead><tbody>"
                                $.each(booking, function(i, item) {
                                    if (item.purchase_confirm == null) {
                                    var nominal = 'Belum Bayar'
                                } else {
                                    var nominal = item.purchase_confirm.nominal 
                                }
                                    myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.user.name +"</td><td>"+ item.no_nota +"</td><td>Rp. "+ item.total_purchase +"</td><td>Rp. "+ nominal +"</td>"
                                        $.each(profit, function(index, itemprofit) {
                                            if (item.packet_id == itemprofit.paket_id){ 
                                                var pro =  itemprofit.paket_id 
                                                myhtml +=  "<td>Rp. "+ itemprofit.profit_nominal +"</td><td>Rp."+ (item.total_purchase - itemprofit.profit_nominal) +"</td><td>-</td></tr>"
                                                } 
                                        });
                                    
                                }); 
                                if (booking.length == 0) {
                                    myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                                }
                                myhtml += "</tbody></table>"
                            }
                        $("#tampil").html(myhtml)
                    }
                });
            // To Stop the loading of page after a button is clicked
            return false;
            });
    </script>
    <script>
        $( function() {
            $('#datepickerday').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        } );

        $('.day').click(function() {

            var day = $("#datepickerday").val()

            $.ajax({

                type:"GET",
                url:"/sortingdayprofit/"+day,
                success: function(data) {
                    var myhtml = "";
                        let booking = data.booking
                        let profit = data.profit

                        if(data === 'Data tidak ditemukan'){
                            myhtml += 'Data tidak ditemukan';  
                        }  else {
                            myhtml += "<table class='table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Mitra</th><th scope='col'>No Nota</th><th scope='col'>Totl Biaya</th><th scope='col'>Total Bayar</th>"
                            myhtml += "<th scope='col'>AkikahKita</th><th scope='col'>Mitra</th><th scope='col'>Reseller</th></tr></thead><tbody>"
                            $.each(booking, function(i, item) {
                                if (item.purchase_confirm == null) {
                                    var nominal = 'Belum Bayar'
                                } else {
                                    var nominal = item.purchase_confirm.nominal 
                                }
                                myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.user.name +"</td><td>"+ item.no_nota +"</td><td>Rp. "+ item.total_purchase +"</td><td>Rp. "+ nominal +"</td>"
                                    $.each(profit, function(index, itemprofit) {
                                        if (item.packet_id == itemprofit.paket_id){ 
                                            var pro =  itemprofit.paket_id 
                                            myhtml +=  "<td>Rp. "+ itemprofit.profit_nominal +"</td><td>Rp."+ (item.total_purchase - itemprofit.profit_nominal) +"</td><td>-</td></tr>"
                                            } 
                                    });
                                
                            }); 
                            if (booking.length == 0) {
                                myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                            }
                            myhtml += "</tbody></table>"
                        }
                    $("#tampil").html(myhtml)
                }
                });
                // To Stop the loading of page after a button is clicked
                return false;

            });
    </script>
    @endsection

@endsection
