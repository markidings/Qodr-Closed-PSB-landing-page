@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Kota')
@section('content-title', 'Edit Kota')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Kota</h4>
                <div>
                    <a href="{{ route('cities.index') }}" class="btn btn-sm btn-warning mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('cities.update', [
                        'city' => $city->id
                    ]) }}"
                    method="POST"
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
                                        placeholder="Nama kota..."
                                        value="{{ old('name') ?? $city->name }}"
                                    />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
