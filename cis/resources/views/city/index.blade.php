@extends('layouts.admin')

@section('title', 'Akikahkita | Kota')
@section('content-title', 'Kota')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kota</h4>
                <div>
                    <a href="{{ route('cities.create') }}" class="btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i> Kota</a>
                </div>  
                <div class="table-responsive mt-5">
                    <table id="cityTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $city)
                                <tr>
                                    <td>{{ $city->name }}</td>
                                    <td>
                                        <a href="{{ route('cities.edit', [
                                            'city' => $city->id
                                        ]) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal" data-target="#modal-del-city"
                                            onclick="setInfoModal({{ $city->id }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <div id="cityInfoID-{{ $city->id }}"
                                            city_id="{{ $city->id }}"
                                            city_name="{{ $city->name }}"
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
<div class="modal fade" id="modal-del-city" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="bold">Konfirmasi hapus</h3>  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Kota</label>
                        <p id="modalCityName">"Name"</p>
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
        $('#cityTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('cities.index') }}';

        function setInfoModal(_cityID) {
            const divCityInfoID = document.getElementById(`cityInfoID-${_cityID}`);
            const cityID = divCityInfoID.getAttribute('city_id');
            const cityName = divCityInfoID.getAttribute('city_name');

            const modalCityName = document.getElementById('modalCityName');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${cityID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalCityName.innerHTML = cityName;
        }
    </script>
@endpush
