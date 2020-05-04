@extends('layouts.admin')

@section('title', 'Akikahkita | Profil Mitra')
@section('content-title', 'Profil Mitra')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Mitra</h4>
                    <div>
                        {{-- <a href="{{ route('profilepartners.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a> --}}
                    </div>
                    <form class="mt-5"
                        {{-- action="{{ route('profilepartners.update', [
                            'partner' => $partners->id
                        ]) }}" --}}
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
                                        <input
                                            name="name"
                                            type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            required
                                            placeholder="Nama mitra..."
                                            value="{{ old('name') ?? $partners->name }}"
                                        />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input
                                            name="email"
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            required
                                            placeholder="Email mitra..."
                                            value="{{ old('email') ?? $partners->email }}"
                                        />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input
                                            name="address"
                                            type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            required placeholder="Alamat mitra..."
                                            value="{{ old('address') ?? $partners->address }}"
                                        />
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kota</label>
                                        <div class="form-group mb-4">
                                            <select
                                                required
                                                name="city_id"
                                                class="custom-select mr-sm-2 @error('city_id') is-invalid @enderror"
                                                id="inlineFormCustomSelect"
                                            >
                                                <option selected>Pilih kota...</option>
                                                @foreach ($cities as $city)
                                                    <option
                                                        {{ ($city->id === $partners->city_id) ? 'selected' : '' }}
                                                        value="{{$city->id}}"
                                                    >{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('city_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
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
                                        <input
                                            name="password_confirmation"
                                            type="password"
                                            class="form-control"
                                            placeholder="Konfirmasi password..."
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
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
                                                        {{ ($partners->is_verified == 1) ? 'checked' : '' }}
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
                                                        {{ ($partners->is_verified == 0) ? 'checked' : '' }}
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
                            {{-- image  --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto Profil</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input
                                                    type="file"
                                                    class="custom-file-input @error('profile_photo') is-invalid @enderror"
                                                    id="inputGroupProfilePhoto"
                                                    name="profile_photo"
                                                    accept="image/*" onchange="loadFile(event, 'previewProfilePhoto')"
                                                />
                                                <label class="custom-file-label" for="inputGroupProfilePhoto">Pilih file...</label>
                                            </div>
                                        </div>
                                        @error('profile_photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <img class="img-responsive" id="previewProfilePhoto" src="{{ $partners->meta->profile_photo_url }}" style="height:200px;"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto Kantor</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input
                                                    type="file"
                                                    class="custom-file-input @error('office_photo') is-invalid @enderror"
                                                    id="inputGroupOfficePhoto"
                                                    name="office_photo"
                                                    accept="image/*" onchange="loadFile(event, 'previewOfficePhoto')"
                                                />
                                                <label class="custom-file-label" for="inputGroupOfficePhoto">Pilih file...</label>
                                            </div>
                                        </div>
                                        @error('office_photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <img class="img-responsive" id="previewOfficePhoto" src="{{ $partners->meta->office_photo_url }}" style="height:200px;"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto Dapur</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input
                                                    type="file"
                                                    class="custom-file-input @error('kitchen_photo') is-invalid @enderror"
                                                    id="inputGroupKitchenPhoto"
                                                    name="kitchen_photo"
                                                    accept="image/*" onchange="loadFile(event, 'previewKitchenPhoto')"
                                                />
                                                <label class="custom-file-label" for="inputGroupKitchenPhoto">Pilih file...</label>
                                            </div>
                                        </div>
                                        @error('kitchen_photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <img class="img-responsive" id="previewKitchenPhoto" src="{{ $partners->meta->kitchen_photo_url }}" style="height:200px;"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto Kandang</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input
                                                    type="file"
                                                    class="custom-file-input @error('shed_photo') is-invalid @enderror"
                                                    id="inputGroupShedPhoto"
                                                    name="shed_photo"
                                                    accept="image/*" onchange="loadFile(event, 'previewShedPhoto')"
                                                />
                                                <label class="custom-file-label" for="inputGroupShedPhoto">Pilih file...</label>
                                            </div>
                                        </div>
                                        @error('shed_photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <img class="img-responsive" id="previewShedPhoto" src="{{ $partners->meta->shed_photo_url }}" style="height:200px;"/>
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
        };
    </script>
@endpush
