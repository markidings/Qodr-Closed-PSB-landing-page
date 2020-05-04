@extends('layouts.admin')

@section('title', 'Akikahkita | Broadcast')
@section('content-title', 'Broadcast')

@push('css')
<link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content') 
<div class="row">  
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kirim Broadcast</h4>
                <form class="mt-5"
                    {{-- action="{{ route('cities.store') }}" --}}
                    method="POST"
                    id="user-role-form"
                >
                @csrf
                @method('post')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Template Pesan</label>
                                    <select class="form-control select2-multiple tuek select2-w-100 form-control-sm" required name="mitra_id" id="message-template">
                                        <option value="">--Cari Template--</option>
                                        @foreach ($messageTemplates as $message)
                                            <option value="{{ $message->message }}">{{$message->title}}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Isi Pesan</label>
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
                                        required
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kirim ke setiap jabatan</h4>
                <form class="mt-5"
                    action="{{ route('cities.store') }}" 
                    method="POST"
                >
                @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Cari Target</label>
                                    <select class="form-control select2-multiple select2-w-100 form-control-sm" name="user[]" id="user-option">
                                        <option value="partner">Mitra</option>
                                        <option value="reseller">Reseller</option>
                                    </select>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                {{-- <button class="btn btn-sm btn-circle btn-success" type="button" onclick="sendOne({{ $customer->id }}, {{ $customer->no_whatsapp }})"><i class="far fa-paper-plane"></i></button> --}}
                                <button type="button" class="btn btn-xlp btn-circle btn-danger" style="width: 150px; height: 150px; margin-top: 60px" id="btn-role-send"><i class="far fa-paper-plane"></i> KIRIM</button>
                            </div>
                        </div>
                        <div style="margin-top:50px;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar User</h4>
                <div class="table-responsive mt-5">
                    <table id="broadcastTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col"></th>
                                <th scope="col">Nama</th>
                                <th scope="col">No WhatsApp</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                        <form method="POST" >
                            @csrf
                            @foreach ($customers as $customer)
                                <tr>
                                    
                                    <td>{{ $no++ }}.</td>
                                    <td><input type="checkbox" name="userlist[]" id="user-checked" value="{{ $customer->id }}"></td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->no_whatsapp }}</td>
                                    <td>Customer</td>
                                    <td><button class="btn btn-sm btn-circle btn-success" type="button" onclick="sendOne({{ $customer->id }}, {{ $customer->no_whatsapp }})"><i class="far fa-paper-plane"></i></button></td>
                                    
                                </tr>
                            @endforeach
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(90deg, #1CB5E0 0%, #000851 100%);">
                <h4 class="card-title text-white">Kirim ke user tertentu</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                    <button type="button" class="btn btn-info col-12" id="check-all-user">Pilih Semua User</button>
                    <button type="button" class="btn btn-warning col-12 mt-2" id="reset-checked">Reset</button>
                    <button type="button" class="btn btn-danger col-12 mt-5" id="send-user-list"><i class="far fa-paper-plane"></i> Kirim Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/js/waiting.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>

<script>

    $("#broadcastTable").DataTable()

    $('#message-template').select2({
        width: '100%'
    });

    $('#user-option').select2({
        multiple: true,
        width: '100%'
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

    /* Message Template */
    $(document).ready(function(){
        $("#message-template").on('change', function(){
            const selectedVal = $(this).val()
            $("#messageTextArea").text(selectedVal)
        })
    })

    /* Check All User List */
    $("#check-all-user").click(function(){
        $('input[type="checkbox"]').prop("checked", true);    
    })

    /* Reset All User List */
    $("#reset-checked").click(function(){
        $('input[type="checkbox"]').prop("checked", false);
    })

    /* Send Broadcast by User Role */
    $("#btn-role-send").click(function(){
        const user = $("#user-option").val()
        const message = $("#messageTextArea").val()
        const token = $('input[name="_token"]').val()
        const data = `_token=${token}&_method=post&mitra_id=${user}&message=${message}`

        if(message === '') {
            return Swal.fire({  
                type: 'warning',
                title: 'Format pesan masih kosong!',
                // showClass: {
                //     popup: 'animated fadeInDown faster'
                // },
                // hideClass: {
                //     popup: 'animated fadeOutUp faster'
                // }
            })
        }

        if(user.length < 1) {
            return Swal.fire({
                type: 'warning',
                title: 'Target pesan masih kosong!',
            })
        }
        
        waitingDialog.show('Sedang mengirim pesan &nbsp;<img src="../images/wa.png" width="25px"> WhatsApp...');
        
        $.ajax({
            url: '{{ url('dashboard/broadcast') }}/storeRole',
            method: 'post',
            data,
            success: function(res) {
                waitingDialog.hide();
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil mengirim broadcast!',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(err) {
                console.log(err)
            }
        })
    })

    /* Send Broadcast by User list */
    $("#send-user-list").click(function(){
        const message = $("#messageTextArea").val()
        const token = $('input[name="_token"]').val()
        var user = [];

        $(':checkbox:checked').each(function(i){
          user[i] = $(this).val();
        });

        if(user.length < 1) {
            return Swal.fire({
                type: 'warning',
                title: 'Target pesan masih kosong!',
            })
        }

        if(message === '') {
            return Swal.fire({  
                type: 'warning',
                title: 'Format pesan masih kosong!',
            })
        }
        const data = `_token=${token}&_method=post&mitra_id=${user}&message=${message}`

        waitingDialog.show('Sedang mengirim pesan &nbsp;<img src="../images/wa.png" width="25px"> WhatsApp...');

        $.ajax({
            url: '{{ url('dashboard/broadcast') }}/storeAll',
            method: 'post',
            data,
            success: function(res) {
            	waitingDialog.hide();
                $('.modal-backdrop').remove();
                $('#modal-alert').remove();
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil mengirim broadcast!',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(err) {
                waitingDialog.hide();
                console.log(err)
            }
        })
    })

    /* Send One Broadcast */
    function sendOne(id, phone){
        const message = $("#messageTextArea").val()
        const token = $('input[name="_token"]').val()
        const data = `_token=${token}&_method=post&user_id=${id}&message=${message}&phone_number=${phone}`

        if(message === '') {
            return Swal.fire({  
                type: 'warning',
                title: 'Format pesan masih kosong!',
            })
        }

        waitingDialog.show('Sedang mengirim pesan &nbsp;<img src="../images/wa.png" width="25px"> WhatsApp...');
        
        $.ajax({
            url: '{{ url('dashboard/broadcast') }}/store',
            method: 'post',
            data,
            success: function(res) {
            	waitingDialog.hide();
                $('.modal-backdrop').remove();
                $('#modal-alert').remove();
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil mengirim broadcast!',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(err) {
                waitingDialog.hide();
                console.log(err)
            }
        })
    }
</script>
@endsection