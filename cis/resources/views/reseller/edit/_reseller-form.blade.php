<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama</label>
            <input
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                required
                placeholder="Nama Reseller..."
                value="{{ $reseller->name }}"
            />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>No Whatsapp</label>
            <div class="input-group">
                <input
                    name="no_whatsapp"
                    type="number"
                    class="form-control @error('no_whatsapp') is-invalid @enderror"
                    required
                    placeholder="No Whatsapp..."
                    value="{{ $reseller->no_whatsapp }}"
                />
            </div>
            @error('no_whatsapp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Bank</label>
            <input
                name="bank_name"
                type="text"
                class="form-control @error('bank_name') is-invalid @enderror"
                required
                placeholder="Nama Bank..."
                value="{{ $reseller->bank_name }}"
            />
            @error('bank_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>No Rekening</label>
            <input
                name="bank_account"
                type="text"
                class="form-control @error('bank_account') is-invalid @enderror"
                required
                placeholder="No Rekening..."
                value="{{ $reseller->bank_account }}"
            />
            @error('bank_account')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <input
    name="id"
    type="hidden"
    class="form-control @error('id') is-invalid @enderror"
    required
    value="{{ $reseller->id }}"
/>
</div>
