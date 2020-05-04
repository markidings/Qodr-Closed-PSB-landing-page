@extends('layouts.admin')

@section('title', 'Akikahkita | Prospek')
@section('content-title', 'Prospek')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Prospek</h4>
                <div>
                    <a href="{{ route('prospects.create') }}" class="btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i> Prospek</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="prospectTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal Perkiraan</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prospects as $prospect)
                                <tr>
                                    <td>{{ $prospect->name }}</td>
                                    <td @if ($prospect->estimated_date <= date("Y-m-d")) 
                                        style="color:red"
                                    @endif>{{ $prospect->formatted_estimated_date }}</td>
                                    <td>{{ $prospect->phone_number }}</td>
                                    <td>{!! $prospect->status_badge !!}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#modal-del-prospect"
                                            onclick="setInfoModal({{ $prospect->id }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <div id="prospectInfoID-{{ $prospect->id }}"
                                            prospect_id="{{ $prospect->id }}"
                                            prospect_name="{{ $prospect->name }}"
                                            prospect_estimated_date="{{ $prospect->formatted_estimated_date }}"
                                            prospect_phone_number="{{ $prospect->phone_number }}"
                                            prospect_status="{{ $prospect->status_badge }}"
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
<div class="modal fade" id="modal-del-prospect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <p id="modalProspectName">"Nama"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">No HP</label>
                        <p id="modalProspectPhone">"No HP"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Perkiraan Tanggal</label>
                        <p id="modalProspectEstimatedDate">"Perkiraan Tanggal"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Status</label>
                        <p id="modalProspectStatus">"Status"</p>
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
        $('#prospectTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('prospects.index') }}';

        function setInfoModal(_prospectID) {
            const divProspectInfoID = document.getElementById(`prospectInfoID-${_prospectID}`);

            const prospectID = divProspectInfoID.getAttribute('prospect_id');
            const prospectName = divProspectInfoID.getAttribute('prospect_name');
            const prospectEstimatedDate = divProspectInfoID.getAttribute('prospect_estimated_date');
            const prospectPhoneNumber = divProspectInfoID.getAttribute('prospect_phone_number');
            const prospectStatus = divProspectInfoID.getAttribute('prospect_status');

            const modalProspectName = document.getElementById('modalProspectName');
            const modalProspectPhone = document.getElementById('modalProspectPhone');
            const modalProspectEstimatedDate = document.getElementById('modalProspectEstimatedDate');
            const modalProspectStatus = document.getElementById('modalProspectStatus');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${prospectID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalProspectName.innerHTML = prospectName;
            modalProspectPhone.innerHTML = prospectPhoneNumber;
            modalProspectEstimatedDate.innerHTML = prospectEstimatedDate;
            modalProspectStatus.innerHTML = prospectStatus;
        }
    </script>
@endpush
