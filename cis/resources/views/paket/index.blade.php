@extends('layouts.admin')

@section('title', 'Akikahkita | Paket Akikah')
@section('content-title', 'Paket Akikah')
@section('breadcrumb', 'Dashboard / Paket Akikah')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Data Paket Akikah</h4><hr>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#create" class="btn btn-success btn-sm modal-show mt-3"><i class="fas fa-plus"></i> Paket</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <ul class="navbar-nav float-right mr-auto mb-4 pl-1">
                                <li class="nav-item d-none d-md-block">
                                    <form>
                                        <div class="customize-input mt-4" style="margin-top:4px">
                                            <div id="datatables_filter" class="d-flex justify-content-lg-end justify-content-sm-start">
                                                <label class="float-left d-flex justify-content-end pt-1 pr-2">Search:</label>
                                                <div class="input-group mb-3">
                                                <input class="form-control form-control-sm font-weight-light" type="text" placeholder="Search by name" id="search-value">
                                                <div class="input-group-append">
                                                    <button type="button" id="search-submit" class="btn btn-sm font-weight-light btn-light border">Search</button>
                                                    <button type="button" id="search-reset" class="btn btn-sm font-weight-light btn-light border">Reset</button>
                                                    <div style="border: none; background: transparent; color:transparent; opacity: 0;">
                                                    <code id="url-value"></code>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                                {{-- <i class="form-control-icon" style="" data-feather="search"></i> --}}
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead> 
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Nama Paket</th>
                                    <th>Menu</th>
                                    <th>Porsi</th>
                                    <th>Harga Jantan</th>
                                    <th>Harga Betina</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-row"> 
                            {{-- CONTENT FROM JS TABLE ROW --}}
                            </tbody>
                            <form class="d-none" id="form-delete" method="delete">
                                @method('delete')
                                @csrf
                            </form>
                        </table>
                    </div>
                </div>
                <div class="card-footer border-top" style="background-color:#fff">
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <p class="mb-0 fs--1">
                            page
                            <span class="d-none d-sm-inline-block mr-1" id="current-page"></span>
                            from
                            <span class="d-none d-sm-inline-block mr-1" id="total-page"></span>
                            |
                            <span class="d-none d-sm-inline-block mr-1" id="total-rows"></span>
                            row(s)
                            </p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-light btn-sm" type="button" disabled="disabled" id="prev-nav">
                                <span>Previous</span>
                            </button>
                            <button class="btn btn-primary btn-sm px-4 ml-2" type="button" id="next-nav">
                                <span>Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade bd-example-modal-md" id="modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3" id="show-el-modal">
                        <div class="card-body border-top">
                            <h6 class="font-weight-semi-bold ls mb-3 text-uppercase text-center">Paket Form Information</h6>
                            <br>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">ID</b>
                                </div>
                                <div class="col" id="id-keahlian"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Nama Paket</b>
                                </div>
                                <div class="col" id="nama-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Menu</b>
                                </div>
                                <div class="col" id="menu-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Porsi</b>
                                </div>
                                <div class="col" id="porsi-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Keterangan</b>
                                </div>
                                <div class="col" id="keterangan-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Kategori</b>
                                </div>
                                <div class="col" id="kategori-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Harga Jantan</b>
                                </div>
                                <div class="col" id="harga-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Harga Betina</b>
                                </div>
                                <div class="col" id="price-paket"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Created at</b>
                                </div>
                                <div class="col" id="created-keahlian"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Updated at</b>
                                </div>
                                <div class="col" id="updated-keahlian"></div>
                            </div>
                            <div class="row">
                                <div class="col-3 col-sm-3">
                                    <b class="font-weight-semi-bold mb-1">Gambar</b>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col" id="gambar-paket"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3" id="edit-el-modal">
                        <div class="row">
                            <div class="col-12">
                                <form id="modal-form" action="#">
                                    @csrf
                                    @method('put')
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">
                                                Nama Paket
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <input
                                                class="form-control form-control-sm"
                                                id="nama-edit"
                                                type="text"
                                                placeholder="nama paket"
                                                name="nama"
                                                >
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">
                                                Menu
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <input
                                                class="form-control form-control-sm"
                                                id="menu-edit"
                                                type="text"
                                                placeholder="menu paket"
                                                name="menu"
                                                >
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">
                                                Porsi
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <input
                                                class="form-control form-control-sm"
                                                id="porsi-edit"
                                                type="number"
                                                placeholder="porsi paket"
                                                name="porsi"
                                                >
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">
                                                Keterangan
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <textarea
                                                class="form-control form-control-sm"
                                                id="keterangan-edit"
                                                type="text"
                                                placeholder="keterangan paket"
                                                name="keterangan"
                                                ></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">
                                                Kategori
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <select
                                                class="form-control form-control-sm"
                                                id="kategori-edit"
                                                type="text"
                                                placeholder="kategori paket"
                                                name="kategori"
                                                >
                                                <option value="">--Pilih Kategori--</option>
                                                <option value="hidup">Paket Hidup</option>
                                                <option value="matang">Paket Matang</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="jk">
                                                Jenis Kambing
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <select
                                                class="form-control form-control-sm"
                                                id="jk-edit"
                                                type="text"
                                                placeholder="jk paket"
                                                name="jk"
                                                >
                                                <option value="">--Pilih Jenis--</option>
                                                <option value="jantan">Jantan</option>
                                                <option value="betina">Betina</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">
                                                Harga
                                                <span class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Required">*</span>
                                            </label>
                                            <input
                                                class="form-control form-control-sm"
                                                id="harga-edit"
                                                type="number"
                                                placeholder="harga paket"
                                                name="harga"
                                                >
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                <button id="update-btn" class="btn btn-sm btn-primary saveMe" type="button">
                    <span class="fas fa-save mr-1" data-fa-transform="shrink-3"></span> <span id="text-update">Update</span>
                </button>
                <button id="save-btn" class="btn btn-sm btn-primary" type="submit">
                    <span class="fas fa-save mr-1" data-fa-transform="shrink-3"></span> Save
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
    @include('paket._js')
@endsection
