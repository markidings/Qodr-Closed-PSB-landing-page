@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Admin CS')
@section('content-title', 'Edit Admin CS')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Admin CS</h4>
                    <div>
                        <a href="{{ route('user.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                    </div>
                    <form class="mt-5"
                        action="{{ route('user.update', $user[0]->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                    @csrf
                    @method('PUT')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            required
                                            placeholder="Nama Admin CS..."
                                            value="{{ old('name') ?? $user[0]->name }}"
                                        />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="text"
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            required
                                            placeholder="E-mail baru.."
                                            value="{{ old('email') ?? $user[0]->email }}"
                                        />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <input
                                            name="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password..."
                                        />
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Konfirmasi Password</label>
                                        <input name="password_confirmation" type="password" class="form-control" placeholder="Konfirmasi password...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select
                                            name="role"
                                            required
                                            class="form-control @error('role') is-invalid @enderror"
                                        />
                                            <option value="">-- pilih jabatan --</option>
                                            <option value="admin_system">Admin Sistem</option>
                                            <option value="admin_finance">Admin Finance</option>
                                            <option value="admin_cs">Admin CS</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Verifikasi</label>

                                        <div>
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        type="radio"
                                                        class="custom-control-input"
                                                        id="isVerifiedYes"
                                                        name="is_verified"
                                                        value="1"
                                                        {{ ($user[0]->is_verified == 1) ? 'checked' : '' }}
                                                    />
                                                    <label class="custom-control-label" for="isVerifiedYes">Yes</label>
                                                </div>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        type="radio"
                                                        class="custom-control-input"
                                                        id="isVerifiedNo"
                                                        name="is_verified"
                                                        value="0"
                                                        {{ ($user[0]->is_verified == 0) ? 'checked' : '' }}
                                                    />
                                                    <label class="custom-control-label" for="isVerifiedNo">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        @error('is_verified')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                output.src = reader.result;
                output.style.height = '200px';
            };

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
