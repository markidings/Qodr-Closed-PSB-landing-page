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
                value="{{ old('name') ?? $partner->name }}"
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
                value="{{ old('email') ?? $partner->email }}"
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
                value="{{ old('address') ?? $partner->address }}"
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
                    <option selected value="">Pilih kota...</option>
                    @foreach ($cities as $city)
                        <option
                            {{ ($city->id == $partner->city_id) ? 'selected' : '' }}
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
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>No Whatsapp</label>
            <div class="input-group">
<!--                 <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                </div> -->
                <input
                    name="no_whatsapp"
                    type="number"
                    class="form-control @error('no_whatsapp') is-invalid @enderror"
                    placeholder="no_whatsapp..."
                    value="{{ old('no_whatsapp') ?? $partner->no_whatsapp }}"
                />
            </div>
            @error('no_whatsapp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
