@extends('layouts.admin')

@section('title', 'Akikahkita | Pesan Template')
@section('content-title', 'Pesan Template')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pesan Template</h4>
                <div>
                    <a href="{{ route('message-templates.create') }}" class="btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i> Template</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="templateTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Judul</th>
                                <th scope="col">Tipe</th>
                                <th scope="col">Pesan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messageTemplates as $template)
                                <tr>
                                    <td>{{ $template->title }}</td>
                                    <td>{{ $template->type_text }}</td>
                                    <td>{{ Str::limit($template->message, 50) }}</td>
                                    <td>
                                        <a href="{{ route('message-templates.edit', [
                                            'message_template' => $template->id
                                        ]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#modal-del-template"
                                            onclick="setInfoModal({{ $template->id }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <div id="templateInfoID-{{ $template->id }}"
                                            template_id="{{ $template->id }}"
                                            template_title="{{ $template->title }}"
                                            template_type="{{ $template->type_text }}"
                                            template_message="{{ $template->message }}"
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
<div class="modal fade" id="modal-del-template" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="bold">Konfirmasi hapus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Judul</label>
                        <p id="modalTemplateTitle">"Judul"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Tipe</label>
                        <p id="modalTemplateType">"Tipe"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="bold">Pesan</label>
                        <p id="modalTemplateMessage">"Pesan"</p>
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
        $('#templateTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('message-templates.index') }}';

        function setInfoModal(_templateID) {
            const divTemplateInfoID = document.getElementById(`templateInfoID-${_templateID}`);
            const templateID = divTemplateInfoID.getAttribute('template_id');
            const templateTitle = divTemplateInfoID.getAttribute('template_title');
            const templateType = divTemplateInfoID.getAttribute('template_type');
            const templateMessage = divTemplateInfoID.getAttribute('template_message');

            const modalTemplateTitle = document.getElementById('modalTemplateTitle');
            const modalTemplateType = document.getElementById('modalTemplateType');
            const modalTemplateMessage = document.getElementById('modalTemplateMessage');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${templateID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalTemplateTitle.innerHTML = templateTitle;
            modalTemplateType.innerHTML = templateType;
            modalTemplateMessage.innerHTML = templateMessage;
        }
    </script>
@endpush
