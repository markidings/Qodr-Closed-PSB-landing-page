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
                    <option value="" selected>Pilih kota...</option>
                    @foreach ($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            @error('city_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6"> 
        <div class="form-group">
            <label>Foto Brosur</label>
            <div class="input-group mb-3"> 
                 <div class="custom-file">
                    <input
                        type="file"
                        required
                        class="custom-file-input @error('brochure_image') is-invalid @enderror"
                        id="inputGroupBrochurePhoto"
                        name="brochure_image"
                        accept="image/*" onchange="loadFile(event, 'previewBrochurePhoto')"
                    />
                    <label class="custom-file-label" for="inputGroupBrochurePhoto">Pilih file...</label>
                </div>
            </div>
              {{-- @error('brochure_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror --}}
            <span class="text-danger">{{ $errors->first('brochure_image') }}</span>
            <img class="img-responsive" id="previewBrochurePhoto"/> 
          
        </div>
    </div>
</div>