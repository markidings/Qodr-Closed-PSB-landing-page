@extends('layouts.admin')

@section('title', 'Akikahkita | Brosur')
@section('content-title', 'Brosur')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Brosur</h4>
                    <div>
                        <a href="{{ route('brochures.create') }}" class="btn btn-success btn-sm mt-3"><i class="fas fa-plus"></i> Brosur</a>
                    </div>
                    <div class="table-responsive mt-5">
                        <table id="brochureTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Region</th>
                                    <th scope="col">Gambar Brosur</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brochures as $b)
                                    <tr>
                                        <td>{{ $b->city ? $b->city->name : '-'  }}</td>
                                        <td>
                                            <img class="img-responsive" style="width:100px;" src="{{ $b->brochure_image_url }}"/>
                                        </td>
                                        <td>
                                            <a href="{{ route('brochures.edit', [
                                                'brochure' => $b->id
                                            ]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <button
                                                class="btn btn-sm btn-danger"
                                                data-toggle="modal" data-target="#modal-del-brochure"
                                                onclick="setInfoModal({{ $b->id }})"
                                            ><i class="fas fa-trash"></i></button>

                                            <div id="brochureInfoID-{{ $b->id }}"
                                                brochure_id="{{ $b->id }}"
                                                brochure_name="{{ $b->city->name }}"
                                            ></div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{-- {{ $brochures->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-del-brochure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                            <p id="modalBrochureName">"Nama"</p>
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
        $('#brochureTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('brochures.index') }}';

        function setInfoModal(_brochureID) {
            const divBrochureInfoID = document.getElementById(`brochureInfoID-${_brochureID}`);
            const brochureID = divBrochureInfoID.getAttribute('brochure_id');
            const brochureName = divBrochureInfoID.getAttribute('brochure_name');

            const modalBrochureName = document.getElementById('modalBrochureName');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${brochureID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalBrochureName.innerHTML = brochureName;
        }
    </script>
    @endsection

@endsection
