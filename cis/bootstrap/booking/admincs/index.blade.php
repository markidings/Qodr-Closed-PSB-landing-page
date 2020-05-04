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
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col">No Nota</th>
                                    <th scope="col">No Whatsapp</th>
                                    <th scope="col">Tanggal Potong</th>
                                    <th class="text-center" scope="col">Batalkan</th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($bookings as $b)
                                    <tr class='text-capitalize'>
                                        <td>{{ $no }}</td>
                                        <?php $no++ ?>
                                        <td>{{$b->name}}</td>
                                        <td>{{$b->user->name}}</td>
                                        <td>{{$b->packet->nama}}</td>
                                        <td>{{$b->no_nota}}</td>
                                        <td>{{$b->no_whatsapp}}</td>
                                        <td>{{$b->formatted_date}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-del-list" onclick="setInfoModal({{ $b->id }})"><i class="fas fa-trash"></i>
                                            </button>
                                            <div id="listInfoID-{{ $b->id }}"
                                                list_id="{{ $b->id }}"
                                                list_name="{{ $b->name }}"
                                                list_name_mitra="{{$b->user->name}}"
                                                list_packet="{{$b->packet->nama}}"
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
    <!-- Modal -->
    <div class="modal fade" id="modal-del-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h3 class="bold">Konfirmasi hapus</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="bold">Nama Pemesan</label>
                            <p id="modalListName">"Nama"</p>
                        </div>
                        <div class="col-md-6">
                            <label class="bold">Nama Mitra</label>
                            <p id="modalListNameMitra">"Nama"</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="bold">Nama Paket</label>
                            <p id="modalListPacket">"Nama"</p>
                        </div>
                        <div class="col-md-6">
                            <label class="bold">No Nota</label>
                            <p id="modalListNota">"Nota"</p>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h4 class="bold">Anda yakin ingin menghapus?</h4>
                </div>
                <div class="modal-footer">
                    <form
                        id="modalDeleteForm"
                        method="POST"
                        action=""
                    >
                        @method('delete')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya!</button>
                    </form>
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

                function setInfoModal(_listID) {
                    console.log(_listID)
                    const divListInfoID = document.getElementById(`listInfoID-${_listID}`);
                    const listID = divListInfoID.getAttribute('list_id');
                    const listName = divListInfoID.getAttribute('list_name');
                    const listPacket = divListInfoID.getAttribute('list_packet');
                    const listNota = divListInfoID.getAttribute('list_nota');
                    const listNameMitra = divListInfoID.getAttribute('list_name_mitra');

                    const modalListName = document.getElementById('modalListName');
                    const modalListNameMitra = document.getElementById('modalListNameMitra');
                    const modalListPacket = document.getElementById('modalListPacket');
                    const modalListNota = document.getElementById('modalListNota');
                        
                    const modalDeleteForm = document.getElementById('modalDeleteForm');
                    const formDeleteAction = `${BASE_DELETE_URL}/${listID}`;
                    modalDeleteForm.setAttribute('action', formDeleteAction);

                    modalListName.innerHTML = listName;
                    modalListNameMitra.innerHTML = listNameMitra;
                    modalListPacket.innerHTML = listPacket;
                    modalListNota.innerHTML = listNota;
                }

                $('.week').click(function() {
        
                    var week = $("#weekNumber").val()
                    var year = $("#yearNumberWeek").val()
                    
                        $.ajax({
        
                            type:"GET",
                            url:"/weeksortingadmincs/"+week+"/"+year,
                            success: function(data) {
                                var myhtml = "";
                                myhtml += "<table class='bookingTableweek table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Pemesanwee</th><th scope='col'>Nama Mitra</th><th scope='col'>Nama Paket</th><th scope='col'>Email</th>"
                                myhtml += "<th scope='col'>No Whatsapp</th></tr></thead><tbody>"

                                $.each(data, function(i, item) {
                                    myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+ item.user.name +"</td><td>"+ item.packet.nama +"</td><td>"+ item.user_email +"</td><td>0"+ item.no_whatsapp +"</td></tr>"
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
                        myhtml += "<table class='bookingTableweek table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Pemesan</th><th scope='col'>Nama Mitra</th><th scope='col'>Nama Paket</th><th scope='col'>Email</th>"
                        myhtml += "<th scope='col'>No Whatsapp</th></tr></thead><tbody>"

                        $.each(data, function(i, item) {
                                myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+item.user.name+"</td><td>"+ item.packet.nama +"</td><td>"+ item.user_email +"</td><td>0"+ item.no_whatsapp +"</td></tr>"
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
