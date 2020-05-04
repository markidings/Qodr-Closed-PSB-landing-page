@extends('layouts.admin')

@section('title', 'Akikahkita | Promo')
@section('content-title', 'Promo')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Promo</h4>
                <div>
                    <a href="{{ route('promos.create') }}" class="btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i> Promo</a>
                </div>
                <div class="table-responsive mt-5">
                    <table id="promoTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Kode</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Tanggal Berakhir</th> 
                                <th scope="col">Diskon</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promos as $promo)
                                <tr>
                                    <td>{{ $promo->code }}</td>
                                    <td>{{ $promo->formatted_start_date }}</td>
                                    <td>{{ $promo->formatted_end_date }}</td>
                                    <td>{{ $promo->discount_amount_text }}</td>
                                    <td>
                                        <a href="{{ route('promos.edit', [
                                            'promo' => $promo->id
                                        ]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#modal-del-promo"
                                            onclick="setInfoModal({{ $promo->id }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <div id="promoInfoID-{{ $promo->id }}"
                                            promo_id="{{ $promo->id }}"
                                            promo_code="{{ $promo->code }}"
                                            promo_start_date="{{ $promo->start_date }}"
                                            promo_end_date="{{ $promo->end_date }}"
                                            promo_discount="{{ $promo->discount_amount_text }}"
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
<div class="modal fade" id="modal-del-promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="bold">Konfirmasi hapus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Kode</label>
                        <p id="modalPromoCode">"Kode"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Diskon</label>
                        <p id="modalPromoDiscount">"Diskon"</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="bold">Tanggal Mulai</label>
                        <p id="modalPromoStartDate">"Tanggal Mulai"</p>
                    </div>
                    <div class="col-md-6">
                        <label class="bold">Tanggal Berakhir</label>
                        <p id="modalPromoEndDate">"Tanggal Berakhir"</p>
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
        $('#promoTable').DataTable();
    </script>
    <script>
        const BASE_DELETE_URL = '{{ route('promos.index') }}';

        function setInfoModal(_promoID) {
            const divPromoInfoID = document.getElementById(`promoInfoID-${_promoID}`);

            const promoID = divPromoInfoID.getAttribute('promo_id');
            const promoCode = divPromoInfoID.getAttribute('promo_code');
            const promoStartDate = divPromoInfoID.getAttribute('promo_start_date');
            const promoEndDate = divPromoInfoID.getAttribute('promo_end_date');
            const promoDiscount = divPromoInfoID.getAttribute('promo_discount');

            const modalPromoCode = document.getElementById('modalPromoCode');
            const modalPromoDiscount = document.getElementById('modalPromoDiscount');
            const modalPromoStartDate = document.getElementById('modalPromoStartDate');
            const modalPromoEndDate = document.getElementById('modalPromoEndDate');

            const modalDeleteForm = document.getElementById('modalDeleteForm');
            const formDeleteAction = `${BASE_DELETE_URL}/${promoID}`;
            modalDeleteForm.setAttribute('action', formDeleteAction);

            modalPromoCode.innerHTML = promoCode;
            modalPromoDiscount.innerHTML = promoDiscount;
            modalPromoStartDate.innerHTML = promoStartDate;
            modalPromoEndDate.innerHTML = promoEndDate;
        }
    </script>
@endpush
