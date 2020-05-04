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
                <h4 class="card-title">Manajemen User</h4> 
                <div>
                    <a href="{{ route('user.create') }}" class="btn btn-success btn-sm mt-3"><i class="fas fa-plus"></i> Admin</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="admincsTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Email</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $value) 
                                @php
                                    $role = $value->role;
                                    if($role === 'admin_system') $role = 'Admin Sistem';
                                    if($role === 'admin_cs') $role = 'Admin CS';
                                    if($role === 'admin_finance') $role = 'Admin Finance';
                                    if($role === 'partner') $role = 'Mitra';
                                @endphp
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $role }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $value->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal" data-target="#modal-del-admincs"
                                            onclick="setInfoModal({{ $value->id }})"
                                        ><i class="fas fa-trash"></i></button>

                                        <div id="admincsInfoID-{{ $value->id }}"
                                            admincs_id="{{ $value->id }}"
                                            admincs_name="{{ $value->name }}"
                                            admincs_email="{{ $value->email }}"
                                            admincs_address="{{ $value->address }}"
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
<div class="modal fade" id="modal-del-admincs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="bold">Konfirmasi hapus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold"><b>Nama</b></label>
                        <p id="modalAdminCSName">"Nama"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold"><b>Email</b></label>
                        <p id="modalAdminCSEmail">"Email"</p>
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
        $('#admincsTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('user.index') }}';

        function setInfoModal(_admincsID) {
            const divAdminCSInfoID = document.getElementById(`admincsInfoID-${_admincsID}`);
            const admincsID = divAdminCSInfoID.getAttribute('admincs_id');
            const admincsName = divAdminCSInfoID.getAttribute('admincs_name');
            const admincsEmail = divAdminCSInfoID.getAttribute('admincs_email');
            const admincsAddress = divAdminCSInfoID.getAttribute('admincs_address');
            const admincsCity = divAdminCSInfoID.getAttribute('admincs_city');

            const modalAdminCSName = document.getElementById('modalAdminCSName');
            const modalAdminCSEmail = document.getElementById('modalAdminCSEmail');
            const modalAdminCSAddress = document.getElementById('modalAdminCSAddress');
            const modalAdminCSCity = document.getElementById('modalAdminCSCity');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${admincsID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalAdminCSName.innerHTML = admincsName;
            modalAdminCSEmail.innerHTML = admincsEmail;
            modalAdminCSAddress.innerHTML = admincsAddress;
            modalAdminCSCity.innerHTML = admincsCity;
        }
    </script>
@endpush
