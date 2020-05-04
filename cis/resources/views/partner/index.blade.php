@extends('layouts.admin')

@section('title', 'Akikahkita | Mitra')
@section('content-title', 'Mitra')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Mitra</h4>
                <div>
                    <a href="{{ route('partners.create') }}" class="btn btn-success btn-sm mt-3"><i class="fas fa-plus"></i> Mitra</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="partnerTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">No Whatsapp</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Kota</th>
                                <th scope="col">Terverifikasi</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($partners as $partner) 
                                <tr>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->email }}</td>
                                    <td>{{ $partner->no_whatsapp }}</td>
                                    <td>{{ $partner->address }}</td>
                                    <td>{{ $partner->city->name }}</td>
                                    <td>
                                        @if ($partner->is_verified)
                                            <span class="badge badge-success">Ya</span>
                                        @else
                                            <span class="badge badge-danger">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('partners.edit', [
                                            'partner' => $partner->id
                                        ]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal" data-target="#modal-del-partner"
                                            onclick="setInfoModal({{ $partner->id }})"
                                        ><i class="fas fa-trash"></i></button>

                                        <div id="partnerInfoID-{{ $partner->id }}"
                                            partner_id="{{ $partner->id }}"
                                            partner_name="{{ $partner->name }}"
                                            partner_email="{{ $partner->email }}"
                                            partner_address="{{ $partner->address }}"
                                            partner_city="{{ $partner->city->name }}"
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
<div class="modal fade" id="modal-del-partner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <p id="modalPartnerName">"Nama"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Email</label>
                        <p id="modalPartnerEmail">"Email"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Alamat</label>
                        <p id="modalPartnerAddress">"Alamat"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Kota</label>
                        <p id="modalPartnerCity">"Kota"</p>
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
        $('#partnerTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('partners.index') }}';

        function setInfoModal(_partnerID) {
            const divPartnerInfoID = document.getElementById(`partnerInfoID-${_partnerID}`);
            const partnerID = divPartnerInfoID.getAttribute('partner_id');
            const partnerName = divPartnerInfoID.getAttribute('partner_name');
            const partnerEmail = divPartnerInfoID.getAttribute('partner_email');
            const partnerAddress = divPartnerInfoID.getAttribute('partner_address');
            const partnerCity = divPartnerInfoID.getAttribute('partner_city');

            const modalPartnerName = document.getElementById('modalPartnerName');
            const modalPartnerEmail = document.getElementById('modalPartnerEmail');
            const modalPartnerAddress = document.getElementById('modalPartnerAddress');
            const modalPartnerCity = document.getElementById('modalPartnerCity');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${partnerID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalPartnerName.innerHTML = partnerName;
            modalPartnerEmail.innerHTML = partnerEmail;
            modalPartnerAddress.innerHTML = partnerAddress;
            modalPartnerCity.innerHTML = partnerCity;
        }
    </script>
@endpush
