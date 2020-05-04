@extends('layouts.admin')

@section('title', 'Akikahkita | Profit Mitra')
@section('content-title', 'Profit Mitra')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row"> 
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Mitra</h4>
                    {{-- <div>
                        <a href="" class="btn btn-success btn-sm mt-3"><i class="fas fa-plus"></i> Brosur</a>
                    </div> --}}
                    <div class="table-responsive mt-5">
                        <table id="profitTable" class="table">
                            <thead> 
                                <tr>
                                        <th scope="col">No</th>
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $p = 1; ?>
                                @foreach ($pakets as $paket)
                                    <tr>
                                        <td>
                                            {{$p++}}
                                        </td>
                                        <td>{{ $paket->nama }}</td>
                                        <td class="text-center">
                                            @if ($paket->profitMitra === null)
                                                <span class="badge badge-warning">Belum</span>
                                            @else
                                                <span class="badge badge-success">Sudah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/dashboard/detailpaket/{{ $paket->id }}" class="btn btn-primary btn-sm"><i class="fas fa-external-link-alt"></i> Detail Paket</a>
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
    
    @section('scripts')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $('#profitTable').DataTable();
    </script>
    @endsection

@endsection
