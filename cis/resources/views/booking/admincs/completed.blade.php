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
                                    <th scope="col">Tanggal Potong</th>
                                    <th scope="col">Detail</th>
                                    <th class="text-center" scope="col">Status Proses</th>
                                    <th class="text-center" scope="col">Proses Pemesanan</th>
                                    <th class="text-center" scope="col">Batalkan</th>
                                    <th class="text-center" scope="col">Print</th>
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
                                        <td>{{$b->formatted_date}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-detail-booking" onclick="setInfoModalDetail({{ $b->id }})"><i class="fas fa-external-link-alt"></i></button>
                                            <div id="detailInfoID-{{ $b->id }}" detail_id="{{ $b->id }}" detail_email="{{$b->user_email}}"
                                                    detail_total_booking="{{$b->total_booking}}" detail_no_nota="{{$b->no_nota}}" detail_address_packet="{{$b->address}}"
                                                    detail_name="{{$b->name}}" detail_name_aqiqah="{{$b->name_aqiqah}}" detail_name_father="{{$b->name_father}}" detail_name_mother="{{$b->name_mother}}"
                                                    detail_postal_code="{{$b->postal_code}}" detail_total_purchase="@currency($b->total_purchase)" detail_type_purchase="{{ $b->type_purchase }}"
                                                    detail_time_slaughter="{{$b->time_slaughter}}" detail_type_goat="{{ $b->type_goat }}" detail_status_transaction="{{ $b->status_transaction }}"
                                                    detail_snack="{{$b->snack_id}}" detail_no_whatsapp="{{$b->no_whatsapp}}"
                                                ></div>
                                        </td>
                                        <td class="text-center">
                                            @if ($b->status_processing === null)
                                                <span class="badge badge-secondary">Delay</span>
                                            @elseif($b->status_processing == 'Kiriman sampai')
                                                <span class="badge badge-success">Sampai</span>
                                            @else
                                                <span class="badge badge-info">{{ $b->status_processing }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-report" onclick="reportClient({{ $b->id }}, {{ $b->no_whatsapp }})"><i class="fas fa-people-carry text-white"></i>
                                            </button>
                                        </td>
                                        <div id="report-process"
                                            list_id="{{ $b->id }}"
                                        ></div>
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
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1"
                                                    data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                                    <span class="fas fa-ellipsis-h fs--1"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown1">
                                                    <a class="dropdown-item" target="_blank" href="{{ route('cut', [
                                                        'nota' => $b->no_nota
                                                    ]) }}">
                                                        <span class="fas fa-print"></span>
                                                        Pemotongan
                                                    </a>
                                                    <a class="dropdown-item" target="_blank" href="{{ route('delivery', [
                                                        'nota' => $b->no_nota
                                                    ]) }}">
                                                        <span class="fas fa-print"></span>
                                                        Delivery
                                                    </a>
                                                    <a class="dropdown-item" target="_blank" href="{{ route('greeting', [
                                                        'nota' => $b->no_nota
                                                    ]) }}">
                                                        <span class="fas fa-print"></span>
                                                        Ucapan
                                                    </a>
                                                </div>
                                            </div>
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
    {{-- Canceled --}}
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
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col">No Nota</th>
                                    <th scope="col">No Whatsapp</th>
                                    <th scope="col">Tanggal Potong</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($canceled as $c)
                                    <tr class='text-capitalize'>
                                        <td>{{ $no }}</td>
                                        <?php $no++ ?>
                                        <td>{{$c->name}}</td>
                                        <td>{{$c->user->name}}</td>
                                        <td></td>
                                        <td>{{$c->no_nota}}</td>
                                        <td>{{$c->no_whatsapp}}</td>
                                        <td>{{$c->formatted_date}}</td>
                                        {{-- <td class="text-center">
                                            @if ($c->status_processing === null)
                                                <span class="badge badge-secondary">Delay</span>
                                            @elseif($c->status_processing == 'Kiriman sampai')
                                                <span class="badge badge-success">Sampai</span>
                                            @else
                                                <span class="badge badge-info">{{ $c->status_processing }}</span>
                                            @endif
                                        </td> --}}
                                        {{-- <td class="text-center">
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-report" onclick="reportClient({{ $c->id }}, {{ $c->no_whatsapp }})"><i class="fas fa-people-carry text-white"></i>
                                            </button>
                                        </td> --}}
                                        {{-- <div id="report-process"
                                            list_id="{{ $c->id }}"
                                        ></div> --}}
                                        {{-- <td class="text-center">
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-del-list" onclick="setInfoModal({{ $c->id }})"><i class="fas fa-trash"></i>
                                            </button>
                                            <div id="listInfoID-{{ $c->id }}"
                                                list_id="{{ $c->id }}"
                                                list_name="{{ $c->name }}"
                                                list_name_mitra="{{$c->user->name}}"
                                                list_packet="{{$c->packet->nama}}"
                                                list_nota="{{$c->no_nota}}"
                                            ></div>
                                        </td> --}}
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
    {{-- End canceled --}}
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
                            <input type="hidden" id="modalListId" name="modalListId" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h4 class="bold">Anda yakin ingin membatalkan?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya!</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    {{-- Report Client Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="bold">Proses Pemesanan</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('report-client.updateCompleted') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="id" id="id-booking">
                                <input type="hidden" name="phone_number" id="phone-booking">
                                <label for="name">
                                    Proses Pemesanan
                                    <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                </label>
                                <select
                                    class="form-control form-control-sm"
                                    id="process-edit"
                                    name="status_processing"
                                    required
                                    >
                                    <option value="">-- pilih proses pemesanan --</option>
                                    <option value="Potong">Potong</option>
                                    <option value="Masak & Packing">Masak & Packing</option>
                                    <option value="Kirim">Kirim</option>
                                    <option value="Kiriman sampai">Kiriman sampai</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">
                                    Template Pesan
                                </label>
                                <select
                                    class="form-control form-control-sm"
                                    id="message-template"
                                    >
                                    <option value="">-- pilih template pesan --</option>
                                    @foreach ($messages as $message)
                                    <option value="{{ $message->message }}">{{$message->title}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">
                                    Isi Pesan
                                </label>
                                <div style="margin-bottom:.5rem;">
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('{Halo|Selamat Siang|Hai kak}')">Spiner</button>
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%paket%')">%paket%</button>
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%pemesan%')">%pemesan%</button>
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%anak%')">%anak%</button>
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%ayah%')">%ayah%</button>
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%ibu%')">%ibu%</button>
                                    <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%status_proses%')">%status_proses%</button>
                                </div>
                                <textarea
                                    id="messageTextArea"
                                    name="message"
                                    class="form-control @error('message') is-invalid @enderror"
                                    placeholder="Sangat direkomendasikan menggunakan spiner, contoh: {Halo|Selamat Siang|Hai kak}"
                                    rows="5"
                                >{{ old('message') }}</textarea>
                                <div style="margin-top:.5rem;">
                                    <button class="btn btn-outline-danger btn-sm btn-rounded" type="button" onclick="clipTextWith('*')">
                                        <span class="fas fa-bold" data-fa-transform="shrink-3"></span>&nbsp;&nbsp;Bold
                                    </button>
                                    <button class="btn btn-outline-success btn-sm btn-rounded" type="button" onclick="clipTextWith('_')">
                                        <span class="fas fa-italic" data-fa-transform="shrink-3"></span>&nbsp;&nbsp;Italic
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm btn-rounded" type="button" onclick="clipTextWith('~')">
                                        <span class="fas fa-strikethrough" data-fa-transform="shrink-3"></span>&nbsp;&nbsp;Strikethrough
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">
                                    Upload Gambar
                                </label>
                                <input
                                    class="form-control"
                                    id="harga-edit"
                                    type="file"
                                    name="image"
                                    >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Ya!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                <!-- Modal -->
		<div class="modal fade" id="modal-detail-booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <label class="font-weight-bold">Jumlah Pesan</label>
                                <p id="modalDetailTotalBooking">"Jumlah Pesan"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Tanggal Pemotongan</label>
                                <p id="modalDetailTimeSlaughter">"Tanggal Pemotongan"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Tipe Kambing</label>
                                <p id="modalDetailTypeGoat">"Tipe Kambing"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Tambahan Menu</label>
                                <p id="modalDetailSnack">"Tambahan Menu"</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">No Whatsapp</label>
                                <p id="modalDetailNoWhatsapp">"No Whatsapp"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Total Biaya</label>
                                <p id="modalDetailTotalPurchase">"Total Biaya"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Tipe Pembayaran</label>
                                <p id="modalDetailTypePurchase">"Tipe Pembayaran"</p>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">Status Transaksi</label>
                                <p id="modalDetailStatusTransaction">"Status Transaksi"</p>
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
                const BASE_DELETE_URL = '{{ route('report-client.index') }}';

                function reportClient(id, phone){
                    $('#id-booking').val(id)
                    $('#phone-booking').val(phone)
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
                    const modalListPacket = document.getElementById('modalListPacket');
                    const modalListNota = document.getElementById('modalListNota');
                    const modalListId = document.getElementById('modalListid');

                    const modalDeleteForm = document.getElementById('modalDeleteForm');
                    const formDeleteAction = `${BASE_DELETE_URL}/${listID}`;
                    // modalDeleteForm.setAttribute('action', formDeleteAction);

                    modalListName.innerHTML = listName;
                    modalListNameMitra.innerHTML = listNameMitra;
                    modalListPacket.innerHTML = listPacket;
                    modalListNota.innerHTML = listNota;

                    $("#modalListId").val(listID);
                }

                function setInfoModalDetail(_detailID) {
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
                    const detail_total_booking = divDetailInfoID.getAttribute('detail_total_booking');
                    const detail_status_transaction = divDetailInfoID.getAttribute('detail_status_transaction');
                    const detail_snack = divDetailInfoID.getAttribute('detail_snack');
                    const detail_no_whatsapp = divDetailInfoID.getAttribute('detail_no_whatsapp');
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
                    const modalDetailTotalBooking = document.getElementById('modalDetailTotalBooking');
                    const modalDetailStatusTransaction = document.getElementById('modalDetailStatusTransaction');
                    const modallDetailSnack = document.getElementById('modalDetailSnack');
                    const modallDetailNoWhatsapp = document.getElementById('modalDetailNoWhatsapp');


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
                    modalDetailTotalBooking.innerHTML = detail_total_booking;
                    modalDetailStatusTransaction.innerHTML = detail_status_transaction;
                    modallDetailSnack.innerHTML = detail_snack;
                    modallDetailNoWhatsapp.innerHTML = detail_no_whatsapp;
                    
                }

                $('.week').click(function() {

                    var week = $("#weekNumber").val()
                    var year = $("#yearNumberWeek").val()

                        $.ajax({

                            type:"GET",
                            url:"/weeksortingadmincsCompleted/"+week+"/"+year,
                            success: function(data) {
                                var myhtml = "";
                                myhtml += "<table class='bookingTableweek table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Pemesan</th><th scope='col'>Nama Mitra</th><th scope='col'>Nama Paket</th>"
                                myhtml += "<th scope='col'>No Nota</th><th scope='col'>No Whatsapp</th><th scope='col'>Tanggal Potong</th><th scope='col'>Status Proses</th></tr></thead><tbody>"

                                $.each(data, function(i, item) {
                                    if (item.user_id !== null) {
                                        var nama = item.user.name
                                    } else {
                                        nama = "-"
                                    }

                                    if(item.status_processing === null){
                                        $status = "<span class='badge badge-secondary'>Delay</span>"
                                    } else if (item.status_processing == 'Kiriman sampai') {
                                        $status = "<span class='badge badge-success'>Sampai</span>"
                                    } else {
                                        $status = "<span class='badge badge-info'>"+ item.status_processing +"</span>"
                                    }
                                    myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+nama+"</td><td>"+ item.packet.nama +"</td><td>"+ item.no_nota +"</td><td>"+ item.no_whatsapp +"</td><td>"+ item.time_slaughter +"</td><td>"+ $status +"</td></tr>"
                                });
                                if (data.length == 0) {
                                    myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
                                }
                                myhtml += "</tbody></table>"
                                $("#tampil").html(myhtml)
                            }
                        });
                    // To Stop the loading of page after a button is clicked
                    return false;
                    });

                /* Message Template */
                $(document).ready(function(){
                    $("#message-template").on('change', function(){
                        const selectedVal = $(this).val()
                        $("#messageTextArea").text(selectedVal)

                    })
                })
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

                /* TextArea */
                function appendMessageText(text) {
                    const messageTextAreaElm = document.getElementById('messageTextArea');
                    const newValue = `${messageTextAreaElm.value} ${text} `;
                    messageTextAreaElm.value = newValue;
                }

                function clipTextWith(sign) {
                    const messageTextAreaElm = document.getElementById('messageTextArea');
                    const textValue = messageTextAreaElm.value;

                    let startText = '';
                    let endText = '';
                    let selectedText = '';

                    if (messageTextAreaElm.selectionStart != undefined) {
                        const startPos = messageTextAreaElm.selectionStart;
                        const endPos = messageTextAreaElm.selectionEnd;

                        selectedText = messageTextAreaElm.value.substring(startPos, endPos);
                        startText = messageTextAreaElm.value.substring(0, startPos);
                        endText = messageTextAreaElm.value.substring(endPos, textValue.length);
                    }

                    messageTextAreaElm.value = startText + sign + selectedText + sign + endText;
                }

        </script>
    <script>
        $('.pilih').click(function() {

            var month = $("#monthNumber").val()
            var year = $("#yearNumber").val()

                $.ajax({

                    type:"GET",
                    url:"/sortingCompleted/"+month+"/"+year,
                    success: function(data) {
                        var myhtml = "";
                                myhtml += "<table class='bookingTableweek table'><thead><tr><th scope='col'>No</th><th scope='col'>Nama Pemesan</th><th scope='col'>Nama Mitra</th><th scope='col'>Nama Paket</th>"
                                myhtml += "<th scope='col'>No Nota</th><th scope='col'>No Whatsapp</th><th scope='col'>Tanggal Potong</th><th scope='col'>Status Proses</th></tr></thead><tbody>"

                        $.each(data, function(i, item) {
                            if (item.user_id !== null) {
                                        var nama = item.user.name
                                    } else {
                                        nama = "-"
                                    }

                                    if(item.status_processing === null){
                                        $status = "<span class='badge badge-secondary'>Delay</span>"
                                    } else if (item.status_processing == 'Kiriman sampai') {
                                        $status = "<span class='badge badge-success'>Sampai</span>"
                                    } else {
                                        $status = "<span class='badge badge-info'>"+ item.status_processing +"</span>"
                                    }
                                    myhtml += "<tr class='text-capitalize'><td>"+ (i+1) +"</td><td>"+ item.name +"</td><td>"+nama+"</td><td>"+ item.packet.nama +"</td><td>"+ item.no_nota +"</td><td>"+ item.no_whatsapp +"</td><td>"+ item.time_slaughter +"</td><td>"+ $status +"</td></tr>"
                                });
                                if (data.length == 0) {
                                    myhtml += "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>"
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
