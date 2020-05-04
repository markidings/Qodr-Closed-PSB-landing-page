@extends('layouts.no-header-sidebar.app')

@section('title', 'Akikahkita | Reseller')
@section('content-title', 'Form Reseller')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
@endpush


@section('content')
	<div class="row justify-content-center hoverable">
		<div class="col-10">
			<div class="card">
				<div class="card-body">
					<br>
					<div>
						<a href="etalase-paket" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i> Kembali</a>
					</div>
					<br><br>
					<img src="{{asset('images/big/akikah_logo.jpg')}}" width="100px" height="100px">
					
					<h2 class="mytext">Registrasi Reseller</h2>
					
					<form action="{{ route('formreseller.store') }}" method="post" enctype="multipart/form-data">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<hr>
					@csrf
						<div class="row text-capitalize">
							<div class="col-md-3">
								<div class="form-group">
									<label>Nama *</label>
									<input name="name" type="text" class="form-control @error('name') is-invalid @enderror" required placeholder="Nama Reseller..."/>
									@error('name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>No Rekening *</label>
									<input name="bank_account" type="text" class="form-control @error('bank_account') is-invalid @enderror" required placeholder="No Rekening..."/>
									@error('bank_account')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>No Whatsapp *</label>
									<input name="no_whatsapp" type="number" class="form-control @error('no_whatsapp') is-invalid @enderror" required placeholder="No Whatsapp..." />
									@error('no_whatsapp')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-3">
								<div class="row mt-4 p-1 text-capitalize">
										<button type="submit" class=" btn btn-primary">Daftar</button>
										&nbsp;&nbsp;&nbsp;
										<span class="" >Yang bertanda * WAJIB diisi</span>
								</div>
							</div> 
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
			
		{{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
		<script src="{{ asset('dist/js/jquery-3.3.1.min.js') }}"></script>

		    {{-- Notify --}}
			@include('layouts.partials.noty')
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>