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
    <div class="row">  
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Saring Berdasarkan Pekan</h4>
                    <div class="col-8">
                        <label for="sel1">Pilih Pekan:</label>
                        <input class="form-control-week" id="datepicker" />
                        <label>Pekan : </label>
                        <input class="form-control-week1" name="weekNumber" id="weekNumber" readonly />
                        <label>Tahun : </label> 
                        <input class="form-control-week2" name="yearNumber" id="yearNumber" readonly />
                        &nbsp;
                        <button type="button" class="pilih btn btn-primary">Info</button> 
                        &nbsp;
                        <span>* Dihitung per pekan</span>
                    </div>
                    <hr>
                    <h4 class="card-title">Saring Berdasarkan Bulan</h4>
                    <div class="col-8">
                        <label for="sel1">Pilih Bulan:</label>
                        <input class="form-control-week" id="datepickermonth" />
                        <label>Bulan : </label>
                        <input class="form-control-week1" name="monthNumber" id="monthNumber" readonly />
                        <label>Tahun : </label> 
                        <input class="form-control-week2" name="yearNumbermonth" id="yearNumbermonth" readonly />
                        &nbsp;
                        <button type="button" class="bulan btn btn-primary">Info</button> 
                        &nbsp;
                        <span>* Dihitung per bulan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">  
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Pemesanan</h4>
                    <div id="tampil" class="table-responsive mt-5">
                        <table class="bookingTable table">
                            <thead> 
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pemesan</th>
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col">Kode Pemesanan</th>
                                    <th scope="col">No Whatsapp</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php $no = 1; ?>
                                @foreach ($bookings as $b)
                                    <tr class="text-capitalize"> 
                                        <td>{{ $no }}</td>
                                        <?php $no++ ?>
                                        <td>{{ $b->name }}</td>
                                        <td>{{ $b->packet->nama }}</td>
                                        <td>{{ $b->no_nota }}</td>
                                        <td>{{ $b->no_whatsapp }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-detail" onclick="setInfoModal({{ $b->id }})"><i class="fas fa-external-link-alt"></i></button>

                                            <div id="detailInfoID-{{ $b->id }}" detail_id="{{ $b->id }}" detail_email="{{$b->user_email}}"
                                                    detail_total_booking="{{$b->total_booking}}" detail_no_nota="{{$b->no_nota}}" detail_address_packet="{{$b->address_packet}}"
                                                    detail_name="{{$b->name}}" detail_name_aqiqah="{{$b->name_aqiqah}}" detail_name_father="{{$b->name_father}}" detail_name_mother="{{$b->name_mother}}"
                                                    detail_postal_code="{{$b->postal_code}}" detail_total_purchase="@currency($b->total_purchase)" detail_type_purchase="{{ $b->type_purchase }}"
                                                    detail_time_slaughter="{{$b->time_slaughter}}"
                                                ></div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody> 
                        </table>
                        <div class="d-flex justify-content-center">
                            {{-- {{ $bookings->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
		<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Pemesanan Paket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Nama Pemesan</label>
                                    <p id="modalDetailName" class="text-capitalize">"Nama Pemesan"</p>
                            </div>
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Nama Anak</label>
                                    <p id="modalDetailNameAqiqah" class="text-capitalize">"Nama Anak"</p>
                            </div>
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Nama Ayah</label>
                                    <p id="modalDetailNameFather" class="text-capitalize">"Nama Ayah"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Nama Ibu</label>
                                <p id="modalDetailNameMother" class="text-capitalize">"Nama Ibu"</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Email</label>
                                    <p id="modalDetailEmail">"Email"</p>
                            </div>
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Kode Pemesanan</label>
                                    <p id="modalDetailNoNota">"Kode Pemesanan"</p>
                            </div>
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Kode Pos</label>
                                    <p id="modalDetailKodePos">"Kode Pos"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Alamat</label>
                                <p id="modalDetailAlamat">"Alamat"</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                    <label class="font-weight-bold">Total Biaya</label>
                                    <p id="modalDetailTotalPurchase">"Total Biaya"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Tipe Pembayaran</label>
                                <p id="modalDetailTypePurchase">"Tipe Pembayaran"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Tanggal Pemotongan</label>
                                <p id="modalDetailTimeSlaughter">"Tanggal Pemotongan"</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
                </div>
            </div>
    </div>
    @section('scripts')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $('#bookingTable').DataTable();

        function setInfoModal(_detailID) {
            const divDetailInfoID = document.getElementById(`detailInfoID-${_detailID}`);
            const detailID = divDetailInfoID.getAttribute('detail_id');
            const detailEmail = divDetailInfoID.getAttribute('detail_email');
            const detail_no_nota = divDetailInfoID.getAttribute('detail_no_nota');
            const detail_address_packet = divDetailInfoID.getAttribute('detail_address_packet');
            const detail_name = divDetailInfoID.getAttribute('detail_name');
            const detail_name_aqiqah = divDetailInfoID.getAttribute('detail_name_aqiqah');
            const detail_name_father = divDetailInfoID.getAttribute('detail_name_father');
            const detail_name_mother = divDetailInfoID.getAttribute('detail_name_mother');1
            const detail_postal_code = divDetailInfoID.getAttribute('detail_postal_code');
            const detail_total_purchase = divDetailInfoID.getAttribute('detail_total_purchase');
            const detail_type_purchase = divDetailInfoID.getAttribute('detail_type_purchase');
            const detail_time_slaughter = divDetailInfoID.getAttribute('detail_time_slaughter');
            
            
            
            const modalDetailEmail = document.getElementById('modalDetailEmail');
            const modalDetailNoNota = document.getElementById('modalDetailNoNota');
            const modalDetailAlamat = document.getElementById('modalDetailAlamat');
            const modalDetailName = document.getElementById('modalDetailName');
            const modalDetailNameAqiqah = document.getElementById('modalDetailNameAqiqah');
            const modalDetailNameFather = document.getElementById('modalDetailNameFather');
            const modalDetailNameMother = document.getElementById('modalDetailNameMother');
            const modalDetailKodePos = document.getElementById('modalDetailKodePos');
            const modalDetailTotalPurchase = document.getElementById('modalDetailTotalPurchase');
            const modalDetailTypePurchase = document.getElementById('modalDetailTypePurchase');
            const modalDetailTimeSlaughter = document.getElementById('modalDetailTimeSlaughter');


            modalDetailEmail.innerHTML = detailEmail;
            modalDetailNoNota.innerHTML = detail_no_nota;
            modalDetailAlamat.innerHTML = detail_address_packet;
            modalDetailName.innerHTML = detail_name;
            modalDetailNameAqiqah.innerHTML = detail_name_aqiqah;
            modalDetailNameFather.innerHTML = detail_name_father;
            modalDetailNameMother.innerHTML = detail_name_mother;
            modalDetailKodePos.innerHTML = detail_postal_code;
            modalDetailTotalPurchase.innerHTML = detail_total_purchase;
            modalDetailTypePurchase.innerHTML = detail_type_purchase;
            modalDetailTimeSlaughter.innerHTML = detail_time_slaughter;
            
        }
    </script>
    <script>
            $('.pilih').click(function() {
    
                var week = $("#weekNumber").val()
                var year = $("#yearNumber").val()

                
                    $.ajax({
    
                        type:"GET",
                        url:"/weeksorting/"+week+"/"+year,
                        success: function(data) {
                            var myhtml = "";
                            $.each(data, function(i, item) {

                                    myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+ item.packet.nama +"</td><td>"+ item.no_nota +"</td><td>0"+ item.no_whatsapp +"</td>"
                                    myhtml += "<td><button class='btn btn-sm btn-info' data-toggle='modal' data-target='#modal-detail' onclick='setInfoModal("+ item.id +")'><i class='fas fa-external-link-alt'></i></button>"
                                    myhtml += "<div id='detailInfoID-"+item.id+"' detail_id='"+item.id+"' detail_email='"+item.user_email+"'"
                                    myhtml += "detail_total_booking='"+item.total_booking+"' detail_no_nota='"+item.no_nota+"' detail_address_packet='"+item.address_packet+"'"
                                    myhtml += "detail_name='"+item.name+"' detail_name_aqiqah='"+item.name_aqiqah+"' detail_name_father='"+item.name_father+"' detail_name_mother='"+item.name_mother+"'" 
                                    myhtml += "detail_postal_code='"+item.postal_code+"' detail_total_purchase='"+item.total_purchase+"' detail_type_purchase='"+item.type_purchase+"' detail_time_slaughter='"+item.time_slaughter+"'></div></td></tr>"
                            });	
                            if (data.length == 0) {
                                myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                            }
                            $("#tampil").html(myhtml)
                        }
                    });
                // To Stop the loading of page after a button is clicked
                return false;
                });         
    </script>
    {{-- @section('scripts') --}}
    {{-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> --}}
    <script src="{{asset('dist/js/jquery-ui.js')}}"></script>
    <script>
            $( "#datepicker" ).datepicker({ 
            onSelect: function (dateText, inst) {
                    var d = new Date(dateText);
                    // var date = $(this).datepicker('getDate'),
                    year =  d.getFullYear();
                    $("#weekNumber").attr("value",$.datepicker.iso8601Week(d)) 
                    $("#yearNumber").attr("value",year)
                    
            }
            });
    </script>
    <script>
            $('.bulan').click(function() {
    
                var month = $("#monthNumber").val()
                var year = $("#yearNumbermonth").val()
                
                    $.ajax({
    
                        type:"GET",
                        url:"/sortingmitra/"+month+"/"+year,
                        success: function(data) {
                            var myhtml = "";
                            $.each(data, function(i, item) {
                                myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+ item.packet.nama +"</td><td>"+ item.no_nota +"</td><td>0"+ item.no_whatsapp +"</td>"
                                    myhtml += "<td><button class='btn btn-sm btn-info' data-toggle='modal' data-target='#modal-detail' onclick='setInfoModal("+ item.id +")'><i class='fas fa-external-link-alt'></i></button>"
                                    myhtml += "<div id='detailInfoID-"+item.id+"' detail_id='"+item.id+"' detail_email='"+item.user_email+"'"
                                    myhtml += "detail_total_booking='"+item.total_booking+"' detail_no_nota='"+item.no_nota+"' detail_address_packet='"+item.address_packet+"'"
                                    myhtml += "detail_name='"+item.name+"' detail_name_aqiqah='"+item.name_aqiqah+"' detail_name_father='"+item.name_father+"' detail_name_mother='"+item.name_mother+"'" 
                                    myhtml += "detail_postal_code='"+item.postal_code+"' detail_total_purchase='"+item.total_purchase+"' detail_type_purchase='"+item.type_purchase+"' detail_time_slaughter='"+item.time_slaughter+"' ></div></td></tr>"
                            });	
                            if (data.length == 0) {
                                myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
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
                    // var date = $(this).datepicker('getDate'),
                    month = d.getMonth() + 1,
                    year =  d.getFullYear();
                
                    $("#monthNumber").attr("value",month)  
                    $("#yearNumbermonth").attr("value",year)
                    
            }
            });
        </script>
{{-- @endsection --}}

    @endsection

@endsection
