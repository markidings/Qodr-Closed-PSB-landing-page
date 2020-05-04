@extends('layouts.admin')

@section('title', 'Akikahkita | Tambah Mitra')
@section('content-title', 'Edit Mitra')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Mitra</h4>
                    <div>
                        <a href="{{ route('partners.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                    </div>
                    <form class="mt-5"
                        action="{{ route('partners.update', [
                            'partner' => $partner->id
                        ]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                    @csrf
                    @method('PUT')
                        <div class="form-body">

                            @include('partner.edit._biodata-form')

                            @include('partner.edit._photo-form')

                        </div>
                        <div class="form-actions mt-5">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-dark">Reset</button>
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
