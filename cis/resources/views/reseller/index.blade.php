@extends('layouts.admin')

@section('title', 'Akikahkita | Reseller')
@section('content-title', 'Reseller')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Reseller</h4>
                    <div>
                        <a href="{{ route('resellers.create') }}" class="btn btn-success btn-sm mt-3"><i class="fas fa-plus"></i> Reseller</a>
                    </div>
                    <div class="table-responsive mt-5">
                        <table id="resellerTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Reseller</th>
                                    <th scope="col">Bank</th>
                                    <th scope="col">No Rekening</th>
                                    <th scope="col">No Whatsapp</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resellers as $r)
                                    <tr>
                                        <td>{{ $r->name }}</td>
                                        <td>{{ $r->bank_name }}</td>
                                        <td>{{ $r->bank_account }}</td>
                                        <td>{{ $r->no_whatsapp }}</td>
                                        <td>
                                            <a href="{{ route('resellers.edit', [
                                                'reseller' => $r->id
                                            ]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <button
                                                class="btn btn-sm btn-danger"
                                                data-toggle="modal" data-target="#modal-del-reseller"
                                                onclick="setInfoModal({{ $r->id }})"
                                            ><i class="fas fa-trash"></i></button>

                                            <div id="resellerInfoID-{{ $r->id }}"
                                                reseller_id="{{ $r->id }}"
                                                reseller_name="{{ $r->name }}"
                                                reseller_bank_name="{{ $r->bank_name }}"
                                                reseller_bank="{{ $r->bank_account }}"
                                                reseller_whatsapp="{{ $r->no_whatsapp }}"
                                            ></div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-del-reseller" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="bold">Konfirmasi hapus</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="bold">Nama</label>
                            <p id="modalResellerName">"Nama"</p>
                        </div>
                        <div class="col-md-6">
                            <label class="bold">No Whatsapp</label>
                            <p id="modalResellerWhatsapp">"No Whatsapp"</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="bold">Nama Bank</label>
                            <p id="modalResellerBankName">"Nama Bank"</p>
                        </div>
                        <div class="col-md-6">
                            <label class="bold">No Rekening</label>
                            <p id="modalResellerBank">"No Rekening"</p>
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
    <script>
        $('#resellerTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('resellers.index') }}';

        function setInfoModal(_resellerID) {
            const divResellerInfoID = document.getElementById(`resellerInfoID-${_resellerID}`);
            const resellerID = divResellerInfoID.getAttribute('reseller_id');
            const resellerName = divResellerInfoID.getAttribute('reseller_name');
            const resellerBank = divResellerInfoID.getAttribute('reseller_bank');
            const resellerBankName = divResellerInfoID.getAttribute('reseller_bank_name');
            const resellerWhatsapp = divResellerInfoID.getAttribute('reseller_whatsapp');

            const modalResellerName = document.getElementById('modalResellerName');
            const modalResellerBank = document.getElementById('modalResellerBank');
            const modalResellerBankName = document.getElementById('modalResellerBankName');
            const modalResellerWhatsapp = document.getElementById('modalResellerWhatsapp');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${resellerID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalResellerName.innerHTML = resellerName;
            modalResellerBank.innerHTML = resellerBank;
            modalResellerBankName.innerHTML = resellerBankName;
            modalResellerWhatsapp.innerHTML = resellerWhatsapp;
        }
    </script>
    @endsection
@endsection
