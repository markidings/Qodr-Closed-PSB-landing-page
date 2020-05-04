@extends('layouts.no-header-sidebar.app')

@section('title', 'Akikahkita | Customer')
@section('content-title', 'Input Data Customer')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
@endpush


@section('content')
	<div class="row justify-content-center hoverable">
		<div class="col-10">
			<div class="card">
				<div class="card-body">
					<div>
						<a href="{{ url('/etalase-paket') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
					</div>
					<br><br>
					<img src="{{asset('images/big/akikah_logo.jpg')}}" width="100px" height="100px">
					
					<h2 class="mytext">Pemesanan Paket</h2> 
					
					<form action="{{ route('formbooking.store') }}" method="post" enctype="multipart/form-data">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<h4><strong> Informasi Paket </strong></h4>
					<hr>
					@csrf
					<div class="row text-capitalize">
						<div class="col-md-3">
							<div class="form-group">
								<img width="100%" height="200px" src="{{ url('/storage/images/packets/'.$pakets->gambar) }}" alt="Image Menu">
							</div> 
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Nama Mitra</label>
								<input value="{{ $pakets->user->name }}" type="text" class="form-control" readonly placeholder="Nama Pemesan..."/>
							</div>
							<div class="form-group">
								<label>Nama Paket</label>
								<input value="{{ $pakets->nama }}" type="text" class="form-control" readonly placeholder="Nama Pemesan..."/>
							</div>
							<div class="form-group">
								<label>Jenis</label>
								<input value="{{ $pakets->jk }}" type="text" class="form-control" readonly placeholder="Jenis..." />
							</div> 
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Menu</label>
								<input value="{{ $pakets->menu }}" type="text" class="form-control" readonly placeholder="Alamat Pemesan..." />
							</div>
							<div class="form-group">
								<label>Porsi</label>
								<input value="{{ $pakets->porsi }}" type="text" class="form-control" readonly placeholder="Porsi..." />
							</div>
							<div class="form-group">
								<label>Harga</label>
								<input value="@currency($pakets->profitMitra->selling_price)" type="text" class="form-control" readonly placeholder="Alamat Pemesan..." />
							</div>
						</div> 
						<div class="col-md-3">
							<div class="form-group">
								<label>Kategori</label>
								<input value="{{ $pakets->kategori }}" type="text" class="form-control" readonly placeholder="Alamat Pemesan..." />
							</div>
							<div class="form-group">
								<label>Kelebihan</label>
								<input value="{{ $pakets->kelebihan }}" type="text" class="form-control" readonly placeholder="Nama Pemesan..."/>
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<textarea  class="form-control" readonly placeholder="Nama Pemesan...">{{ $pakets->keterangan }}</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-10">
			<div class="card">
				<div class="card-body">	
						<h3><strong>Informasi Data Pemesan </strong></h3>
						<hr>
						&nbsp;				
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Email *</label>
								<input name="user_email" type="email" class="form-control @error('user_email') is-invalid @enderror" required placeholder="Email Pemesan..."/>
								@error('user_email')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						{{-- inputan form --}}
						<input
							name="packet_id"
							type="hidden"
							class="form-control @error('id') is-invalid @enderror"
							required
							value="{{ $pakets->id }}"
						/>
						<input
							name="user_id"
							type="hidden"
							class="form-control @error('id') is-invalid @enderror"
							required
							value="{{ $pakets->user_id }}"
						/>
						</div>
						<div class="col-md-6">
							<div class="form-group"> 
								<div class="form-group">
									<label for="">Tanggal Pemotongan *</label>
									<input id="time_slaughter" name="time_slaughter" type="date" class="form-control @error('time_slaughter') is-invalid @enderror" placeholder="Tanggal Pemotongan" required>
									@error('time_slaughter')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Pemesan *</label>
								<input name="name" type="text" class="form-control @error('name') is-invalid @enderror" required placeholder="Nama Pemesan..."/>
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Alamat *</label>
								<input name="address" type="text" class="form-control @error('address') is-invalid @enderror" required placeholder="Alamat Pemesan..." />
								@error('address')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
									<label>No Whatsapp *</label>
									<br>
									<input name="no_whatsapp" type="number" class="form-control @error('no_whatsapp') is-invalid @enderror" required placeholder="No Whatsapp Pemesan..." />
									@error('no_whatsapp')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<span>Yang bertanda * WAJIB diisi</span>
							<br>
							<button type="submit" class="btn btn-primary">Submit</button>
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