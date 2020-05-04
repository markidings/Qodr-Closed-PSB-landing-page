@extends('layouts.admin')

@section('title', 'Akikahkita | Menu Tambahan')
@section('content-title', 'Menu Tambahan')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Menu Tambahan</h4>
                <div>
                    <a href="{{ route('snacks.create') }}" class="btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i> Menu Tambahan</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="snackTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Mitra</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($snacks as $snack)
                                <tr>
                                    <td>{{ $snack->name }}</td>
                                    <td>{{ $snack->price }}</td>
                                    <td>
                                        <img class="img-responsive" style="width:100px;" src="{{ $snack->photo_url }}"/>
                                    </td>
                                    <td>{{ $snack->partner->name }}</td>
                                    <td>
                                        <a href="{{ route('snacks.edit', [
                                            'snack' => $snack->id
                                        ]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#modal-del-snack"
                                            onclick="setInfoModal({{ $snack->id }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <div id="snackInfoID-{{ $snack->id }}"
                                            snack_id="{{ $snack->id }}"
                                            snack_name="{{ $snack->name }}"
                                            snack_price="{{ $snack->price }}"
                                            snack_partner="{{ $snack->partner->name }}"
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
<div class="modal fade" id="modal-del-snack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <p id="modalSnackName">"Nama"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Harga</label>
                        <p id="modalSnackPrice">"Harga"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Mitra</label>
                        <p id="modalSnackPartner">"Mitra"</p>
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
        $('#snackTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('snacks.index') }}';

        function setInfoModal(_snackID) {
            const divSnackInfoID = document.getElementById(`snackInfoID-${_snackID}`);
            const snackID = divSnackInfoID.getAttribute('snack_id');
            const snackName = divSnackInfoID.getAttribute('snack_name');
            const snackPrice = divSnackInfoID.getAttribute('snack_price');
            const snackPartner = divSnackInfoID.getAttribute('snack_partner');

            const modalSnackName = document.getElementById('modalSnackName');
            const modalSnackPrice = document.getElementById('modalSnackPrice');
            const modalSnackPartner = document.getElementById('modalSnackPartner');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${snackID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalSnackName.innerHTML = snackName;
            modalSnackPrice.innerHTML = snackPrice;
            modalSnackPartner.innerHTML = snackPartner;
        }
    </script>
@endpush
