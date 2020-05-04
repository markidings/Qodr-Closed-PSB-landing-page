@extends('layouts.admin')

@section('title', 'Akikahkita | Konfirmasi Pembayaran')
@section('content-title', 'Konfirmasi Pembayaran')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12"> 
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Konfirmasi Pembayaran</h4>
                <div>
                    <a href="{{ route('purchase-confirms-partner.create') }}" class="btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i> Konfirmasi Pembayaran</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="purchaseConfirmTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">No Nota</th>
                                <th scope="col">Nominal</th>
                                <th scope="col">Status Bayar</th>
                                <th scope="col">Kekurangan</th>
                                <th scope="col">Total Bayar</th>
                                <th scope="col">Tanggal Konfirmasi</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->no_nota }}</td>
                                    <td>{{ format_rupiah($data->nominal) }}</td>
                                    <td>{{ strtoupper($data->status_purchase) }}</td>
                                    @php
                                        if ($data->status_purchase == 'dp') {
                                            $paid_off = $data->paid_off;
                                        } else {
                                            $paid_off = 0;
                                        }
                                    @endphp
                                    <td>{{ format_rupiah($paid_off) }}</td>
                                    <td>{{ format_rupiah($data->total_purchase) }}</td>
                                    <td>{{ $data->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('purchase-confirms-partner.edit', [
                                            'purchase_confirms_partner' => $data->id
                                        ]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#modal-del-purchase_confirm"
                                            onclick="setInfoModal({{ $data->id }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <div id="purchaseConfirmID-{{ $data->id }}"
                                            data_id="{{ $data->id }}"
                                            data_nota="{{ $data->no_nota }}"
                                            data_nominal="{{ format_rupiah($data->nominal) }}"
                                            data_status="{{ $data->status_purchase }}"
                                            data_total="{{ format_rupiah($data->total_purchase) }}"
                                            data_date="{{ $data->updated_at }}"
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
<div class="modal fade" id="modal-del-purchase_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="bold">Konfirmasi hapus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">No Nota</label>
                        <p id="modalNoNota">"No Nota"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Status Bayar</label>
                        <p id="modalStatus">"Status Bayar"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="bold">Nominal</label>
                        <p id="modalNominal">"Nominal"</p>
                    </div>
                    <div class="col-md-12">
                        <label class="bold">Total Bayar</label>
                        <p id="modalTotal">"Total Bayar"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="bold">Tanggal Konfirmasi</label>
                        <p id="modalDate">"Tanggal Konfirmasi"</p>
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
@endsection

@push('js')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $('#purchaseConfirmTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('purchase-confirms-partner.index') }}';

        function setInfoModal(purchaseConfirmID) {
            const divDataInfoID = document.getElementById(`purchaseConfirmID-${purchaseConfirmID}`);
            const dataID = divDataInfoID.getAttribute('data_id');
            const dataNota = divDataInfoID.getAttribute('data_nota');
            const dataNominal = divDataInfoID.getAttribute('data_nominal');
            const dataStatus = divDataInfoID.getAttribute('data_status');
            const dataTotal = divDataInfoID.getAttribute('data_total');
            const dataDate = divDataInfoID.getAttribute('data_date');

            const modalNoNota = document.getElementById('modalNoNota');
            const modalStatus = document.getElementById('modalStatus');
            const modalNominal = document.getElementById('modalNominal');
            const modalTotal = document.getElementById('modalTotal');
            const modalDate = document.getElementById('modalDate');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${dataID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalNoNota.innerHTML = dataNota;
            modalStatus.innerHTML = dataStatus;
            modalNominal.innerHTML = dataNominal;
            modalTotal.innerHTML = dataTotal;
            modalDate.innerHTML = dataDate;
        }
    </script>
@endpush
