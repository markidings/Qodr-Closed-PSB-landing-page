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
                    <div class="col-12">
                        <label for="sel1">Pilih Pekan:</label>
                        <input class="form-control-week" id="datepickerweek" />
                        &nbsp;
                        <label>Pekan : </label>
                        <input class="form-control-week1" name="weekNumber" id="weekNumber" readonly />
                        &nbsp;
                        <label>Tahun : </label> 
                        <input class="form-control-week2" name="yearNumberWeek" id="yearNumberWeek" readonly />
                        &nbsp;
                        <button type="button" class="week btn btn-primary">Info</button> 
                        &nbsp;
                        <span>* Dihitung per pekan</span>
                    </div>
                    <hr>
                    <h4 class="card-title">Saring Berdasarkan Bulan</h4>
                    <div class="col-12">
                        <label for="sel1">Pilih Bulan:</label>
                        <input class="form-control-week" id="datepicker" />
                        &nbsp;
                        <label>Bulan : </label>
                        <input class="form-control-week1" name="monthNumber" id="monthNumber" readonly />
                        &nbsp;
                        <label>Tahun : </label> 
                        <input class="form-control-week2" name="yearNumber" id="yearNumber" readonly />
                        &nbsp;
                        <button type="button" class="pilih btn btn-primary">Info</button> 
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
                        {{-- bookingTable --}}
                        <table class="bookingTable table">
                            <thead> 
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pemesan</th>
                                    <th scope="col">Nama Mitra</th>
                                    <th scope="col">Regional</th>
                                    <th scope="col">No Nota</th>
                                    <th scope="col">No Whatsapp</th>
                                    <th scope="col">Tanggal Pemesanan</th>
                                    <th class="text-center" scope="col">Aksi</th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                ?>
                                @foreach ($bookings as $b)
                                    <tr class='text-capitalize'>
                                        <td>{{ $no++ }}.</td>
                                        <td {!! $b->status_time_index !!}>{{$b->name}}</td>
                                        <td {!! $b->status_time_index !!}>
                                        @php
                                        if($b->user_id) {
                                          echo $b->user->name;
                                        }
                                        @endphp 
                                        </td>
                                        <td {!! $b->status_time_index !!}>
                                        @php
                                        if($b->city_id) {
                                          echo $b->city->name;
                                        }
                                        @endphp
                                        </td>
                                        <td {!! $b->status_time_index !!}>{{$b->no_nota}}</td>
                                        <td {!! $b->status_time_index !!}>{{$b->no_whatsapp}}</td>
                                        <td {!! $b->status_time_index !!}>{{$b->created_at}}</td>
                                        <input type="hidden" name="booking_id2" id="booking-id" value="{{$b->id}}">
                                        <td class="text-center">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false" style="z-index: +10">
                                        <span class="fas fa-ellipsis-h fs--1"></span>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown1" style="z-index: +10" onclick="setDetailModal({{ $b->id }})">
                                        <a class="dropdown-item modal-show text-primary" data-toggle="modal" data-target="#modal-detail" data-id="${val.id}">
                                          <span class="fas fa-info-circle"></span>
                                          Detail
                                        </a>
                                        <a class="dropdown-item modal-show text-success" onclick="setUpdateId({{ $b->id }}, {{$b->city_id}})" data-id="${val.id}">
                                          <span class="fas fa-edit"></span>
                                          Tentukan Mitra
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete-me text-danger" data-toggle="modal" data-target="#modal-del-list" onclick="setInfoModal({{ $b->id }})" data-id="${val.id}">
                                          <span class="fas fa-minus-circle"></span>
                                          Delete
                                        </a>
                                      </div>
                                            <div id="detailInfoID-{{ $b->id }}" detail_id="{{ $b->id }}" detail_email="{{$b->user_email}}"
                                                detail_total_booking="{{$b->total_booking}}" detail_no_nota="{{$b->no_nota}}" detail_address_packet="{{$b->address}}"
                                                detail_name="{{$b->name}}" detail_name_aqiqah="{{$b->name_aqiqah}}" detail_name_father="{{$b->name_father}}" detail_name_mother="{{$b->name_mother}}"
                                                detail_postal_code="{{$b->postal_code}}" detail_total_purchase="@currency($b->total_purchase)" detail_type_purchase="{{ $b->type_purchase }}"
                                                detail_time_slaughter="{{$b->time_slaughter}}" detail_type_goat="{{ $b->type_goat }}"
                                            ></div>
                                            <div id="listInfoID-{{ $b->id }}"
                                                list_id="{{ $b->id }}"
                                                list_name="{{ $b->name }}"
                                                <?php
                                                if($b->user_id) {
                                                ?>
                                                list_packet="{{$b->user->name}}"
                                                <?php
                                                }
                                                ?>
                                                list_nota="{{$b->no_nota}}"
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
    </div>
    {{-- List Batal --}}
    <div class="row">  
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Pembatalan</h4>
                    <div id="tampil" class="table-responsive mt-5">
                        {{-- bookingTable --}}
                        <table class="bookingTable table">
                            <thead> 
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pemesan</th>
                                    <th scope="col">Nama Mitra</th>
                                    <th scope="col">Regional</th>
                                    <th scope="col">No Nota</th>
                                    <th scope="col">No Whatsapp</th>
                                    <th scope="col">Tanggal Pemesanan</th>
                                    {{-- <th class="text-center" scope="col">Aksi</th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                ?>
                                @foreach ($canceled as $c)
                                    <tr class='text-capitalize'>
                                        <td>{{ $no++ }}.</td>
                                        <td>{{$c->name}}</td>
                                        <td>
                                        @php
                                        if($c->user_id) {
                                          echo $c->user->name;
                                        }
                                        @endphp 
                                        </td>
                                        <td>
                                        @php
                                        if($c->city_id) {
                                          echo $c->city->name;
                                        }
                                        @endphp
                                        </td>
                                        <td>{{$c->no_nota}}</td>
                                        <td>{{$c->no_whatsapp}}</td>
                                        <td>{{$c->created_at}}</td>
                                        <input type="hidden" name="booking_id2" id="booking-id" value="{{$c->id}}">
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-del-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h3 class="bold">Konfirmasi Pembatalan</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('report-client.cancel') }}" enctype="multipart/form-data">
                    @method('post')
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="bold">No Nota</label>
                            <p id="modalListNota">"Nota"</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="bold">Nama Pemesan</label>
                            <p id="modalListName">"Nama"</p>
                        </div>
                        <div class="col-md-6">
                            <label class="bold">Nama Mitra</label>
                            <p id="modalListNameMitra">"Nama"</p>
                            <input type="hidden" id="modalListId" name="modalListId" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h4 class="bold">Anda yakin ingin membatalkan?</h4>
                </div>
                <div class="modal-footer">
                    {{-- <form
                        id="modalDeleteForm"
                        method="POST"
                        action=""
                    >
                        @method('delete')
                        @csrf --}}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya!</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    {{-- Partner List Modal --}}
    <div class="modal fade" id="modal-partner-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h3 class="bold">Cari Mitra</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="table-row">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                        <div class="col-md-3">
                            <label class="font-weight-bold">Tipe Kambing</label>
                            <p id="modalDetailTypeGoat">"Tipe Kambing"</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dist/js/jquery-ui.js')}}"></script>
    <script>
        $('.bookingTable').DataTable();
        $('.bookingTableweek').DataTable();
    </script>
        <script>

                const BASE_DELETE_URL = '{{ route('admin-cs-bookings.index') }}';
                function setUpdateId(id, city) {
                    $('[name="booking_id2"]').val(id)
                    const id2 = $('#booking-id').val()

                    $.ajax({
                        url: `{{ route('report-client.edit') }}`,
                        data: `city=${city}`,
                        success: function(res){

                            let tableRow = ``;
                            let no = 1;
                            let totalPrice = 0;
                            let rangePrice = 0;
                            let bookingId = id;
                            if (res.partners.length > 0) {
                                // Partner Name
                                $.each(res.partners, (key, val) => {
                                    tableRow += `<tr>
                                        <th scope="row">${no++}.</th>
                                        <td>${val.name}</td>
                                        <td>
                                            <form action="{{ route('report-client.store') }}" method="post">
                                                @method('post')
                                                @csrf 
                                            <input type="hidden" name="booking_id" value="${bookingId}">
                                            <input type="hidden" name="partner_id" value="${val.user_id}">
                                            <button type="submit" href="#edit" booking-id="${bookingId}" onclick="choicePartner(this)" partner-id="${val.user_id}" class="btn btn-danger">Pilih</button>
                                            </form>
                                        </td>
                                    </tr>`
                                })
                            } else {
                                tableRow = `<td colspan="5"><h3 class="text-center">Not Found</h3></td>`;
                            }
                            $("#table-row").html(tableRow)
                            $('#modal-partner-list').modal('show')
                            
                        },
                        error: function(err) {
                            console.log(err)
                        }
                    })
                }

                $('#updatePartner').on('click', function() {
                    console.log('update Partner')
                })

                function setDetailModal(_detailID) {
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
                    const detail_type_goat = divDetailInfoID.getAttribute('detail_type_goat');
                    let type_goat = [];
                    if (detail_type_goat == 'male') {
                         type_goat = 'jantan';
                    } else if (detail_type_goat == 'female'){
                         type_goat = 'betina';
                    }else{
                        type_goat = '-';
                    }
                    
                    
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
                    const modalDetailTypeGoat = document.getElementById('modalDetailTypeGoat');


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
                    modalDetailTypeGoat.innerHTML = type_goat;
                    
                }

                function setInfoModal(_listID) {
                    const divListInfoID = document.getElementById(`listInfoID-${_listID}`);
                    const listID = divListInfoID.getAttribute('list_id');
                    const listName = divListInfoID.getAttribute('list_name');
                    const listPacket = divListInfoID.getAttribute('list_packet');
                    const listNota = divListInfoID.getAttribute('list_nota');
                    const listNameMitra = divListInfoID.getAttribute('list_name_mitra');

                    const modalListName = document.getElementById('modalListName');
                    const modalListNameMitra = document.getElementById('modalListNameMitra');
                    const modalListNota = document.getElementById('modalListNota');
                    const modalListId = document.getElementById('modalListid');
                        
                    const modalDeleteForm = document.getElementById('modalDeleteForm');
                    const formDeleteAction = `${BASE_DELETE_URL}/${listID}`;
                    // modalDeleteForm.setAttribute('action', formDeleteAction);

                    modalListName.innerHTML = listName;
                    modalListNameMitra.innerHTML = listNameMitra;
                    modalListNota.innerHTML = listNota;
                    modalListNameMitra.innerHTML = listPacket;

                    $("#modalListId").val(listID);
                }

                function choicePartner(element){
                    console.log(element)
                }

                $('.week').click(function() {
        
                    var week = $("#weekNumber").val()
                    var year = $("#yearNumberWeek").val()
                     
                        $.ajax({
        
                            type:"GET",
                            url:"/weeksortingadmincs/"+week+"/"+year,
                            success: function(data) {
                                var myhtml = "";
                                myhtml += "<table class='bookingTableweek table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Pemesanwee</th><th scope='col'>Nama Mitra</th><th scope='col'>Nama Paket</th>"
                                myhtml += "<th scope='col'>No Whatsapp</th><th scope='col'>Tanggal Pemesanan</th></tr></thead><tbody>"

                                $.each(data, function(i, item) {

                                    if (item.user_id !== null) {
                                        var nama = item.user.name
                                    } else {
                                        nama = "-"
                                    }
                                    myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+ nama +"</td><td>"+ item.packet.nama +"</td><td>"+ item.no_whatsapp +"</td><td>"+ item.created_at +"</td></tr>"
                                });	
                                if (data.length == 0) {
                                    myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                                }
                                myhtml += "</tbody></table>"
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
                $( "#datepickerweek" ).datepicker({ 
                onSelect: function (dateText, inst) {
                        var d = new Date(dateText);
                        // var date = $(this).datepicker('getDate'),
                        year =  d.getFullYear();
                        $("#weekNumber").val($.datepicker.iso8601Week(d)) 
                        $("#yearNumberWeek").val(year)
                        
                }
                });
        </script>
    <script>
        $('.pilih').click(function() {

            var month = $("#monthNumber").val()
            var year = $("#yearNumber").val()
            
                $.ajax({

                    type:"GET",
                    url:"/sorting/"+month+"/"+year,
                    success: function(data) {
                        var myhtml = "";
                        myhtml += "<table class='bookingTableweek table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Pemesan</th><th scope='col'>Nama Mitra</th><th scope='col'>Nama Paket</th>"
                        myhtml += "<th scope='col'>No Whatsapp</th><th scope='col'>Tanggal Pemesanan</th><th scope='col'>Aksi</th><</tr></thead><tbody>"

                        $.each(data, function(i, item) {
                            if (item.user_id !== null) {
                                        var nama = item.user.name
                                    } else {
                                        nama = "-"
                                    }
                                myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+nama+"</td><td>"+ item.packet.nama +"</td><td>"+ item.no_whatsapp +"</td><td>"+ item.created_at +"</td></tr>"
                            // let number = (number+1)
                        });	
                        if (data.length == 0) {
                            myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                        }
                        myhtml += "</tbody></table>"
                        $("#tampil").html(myhtml)
                    }
                });
            // To Stop the loading of page after a button is clicked
            return false;
            });
    </script>
    <script>
        $( "#datepicker" ).datepicker({ 
        onSelect: function (dateText, inst) {
                var d = new Date(dateText);
                // var date = $(this).datepicker('getDate'),
                month = d.getMonth() + 1,
                year =  d.getFullYear();
            
                $("#monthNumber").attr("value",month) 
                $("#yearNumber").attr("value",year)
                
        }
        });
    </script>
    @endsection

@endsection
