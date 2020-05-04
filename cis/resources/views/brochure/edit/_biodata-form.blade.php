<div class="row">
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
                            {{ ($city->id === $brochure->city_id) ? 'selected' : '' }}
                            value="{{$city->id}}"
                        >{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            @error('city_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input
            name="id"
            type="hidden"
            class="form-control @error('id') is-invalid @enderror"
            required
            value="{{ $brochure->id }}"
        />
        <input
            name="old"
            type="hidden"
            class="form-control @error('brochure_image') is-invalid @enderror"
            required
            value="{{ $brochure->brochure_image }}"
        />
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Foto Brosur</label>
            <div class="input-group mb-3">
                <div class="custom-file"> 
                    <input
                        type="file"
                        class="custom-file-input @error('brochure_image') is-invalid @enderror"
                        id="inputGroupOfficePhoto"
                        name="brochure_image"
                        value="{{ $brochure->brochure_image }}"
                        accept="image/*" onchange="loadFile(event, 'previewOfficePhoto')"
                    />
                    <label class="custom-file-label" for="inputGroupOfficePhoto">Pilih file...</label>
                </div>
            </div>
            @error('brochure_image')
                <div class="invalid-feedback">{{  $message }}</div>
            @enderror
            <span class="text-danger">{{ $errors->first('brochure_image') }}</span>
        <img class="img-responsive" id="previewOfficePhoto" style="width:100px;" src="{{ $brochure->brochure_image_url}}"/>
        </div>
    </div>
</div>
