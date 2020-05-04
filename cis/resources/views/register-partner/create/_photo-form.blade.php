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
            <img class="img-responsive" id="previewProfilePhoto"/>
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
            <img class="img-responsive" id="previewOfficePhoto"/>
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
            <img class="img-responsive" id="previewKitchenPhoto"/>
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
            <img class="img-responsive" id="previewShedPhoto"/>
        </div>
    </div>
</div>
