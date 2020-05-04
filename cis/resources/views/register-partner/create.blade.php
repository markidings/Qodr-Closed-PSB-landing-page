@extends('layouts.no-header-sidebar.app')

@section('title', 'Akikahkita | Register Mitra')
@section('content-title', 'Register Mitra')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <a href="../etalase-paket" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <br>
                    <h4 class="card-title">Registrasi Mitra</h4> 
                    <form class="mt-5"
                        action="{{ route('register-partner.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                    @csrf
                        <div class="form-body">

                            @include('register-partner.create._biodata-form')

                            @include('register-partner.create._photo-form')

                        </div>
                        <div class="form-actions mt-5">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function loadFile(event, idSelector) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(idSelector);
                console.log(reader);
                output.src = reader.result;
                output.style.height = '200px';
            };

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
