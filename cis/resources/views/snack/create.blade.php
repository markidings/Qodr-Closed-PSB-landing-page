@extends('layouts.admin')

@section('title', 'Akikahkita | Tambah Menu Tambahan')
@section('content-title', 'Tambah Menu Tambahan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Menu</h4>
                <div>
                    <a href="{{ route('snacks.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('snacks.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input
                                        name="name"
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        required
                                        placeholder="Nama snack..."
                                        value="{{ old('name') }}"
                                    />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input
                                        name="price"
                                        type="number"
                                        min="0"
                                        class="form-control @error('price') is-invalid @enderror"
                                        {{-- required --}}
                                        placeholder="Harga snack..."
                                        value="{{ old('price') }}"
                                    />
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea
                                        name="description"
                                        required
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Deskripsi snack..."
                                        rows="3"
                                    >{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input
                                                type="file"
                                                class="custom-file-input @error('photo') is-invalid @enderror"
                                                id="inputGroupProfilePhoto"
                                                name="photo"
                                                accept="image/*" onchange="loadFile(event, 'previewPhoto')"
                                            />
                                            <label class="custom-file-label" for="inputGroupProfilePhoto">Pilih file...</label>
                                        </div>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                                    <img class="img-responsive" id="previewPhoto"/>
                                </div>
                            </div>
                        </div>
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
        }
    </script>
@endpush
