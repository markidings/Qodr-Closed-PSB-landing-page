@extends('layouts.no-header-sidebar.app')

@section('title', 'Akikahkita | Customer')
@section('content-title', 'Input Data Customer')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
@endpush

 
@section('content')
	<div class="row justify-content-center hoverable">
		<div class="cardone">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<a href="{{ url('https://www.akikahkita.com/') }}" class="btn btn-warning btn-sm mt-3">&nbsp;&nbsp;<b>X</b> Close</a>
					</div>
					<br><br>
					<center>
					<img src="{{asset('images/big/akikah_logo.jpg')}}" width="100px" height="100px">
					
					<h2 class="mytext">Pemesanan Paket</h2> 
					</center>
					<hr>
					<div class="row">
						<div class="col-md-1" style="padding-right: 5px;">
							<h4 class="mt-3"><strong>Regional:</strong></h4>
						</div>
						<div class="col-md-4">
							@php
								$regional = [];
							@endphp
							<select required id="cities" class="form-control mt-2 cities" id="cities">
								<option value="">Pilih kota...</option>
								@foreach ($cities as $cite)
									@if (!in_array($cite->name, $regional))
										<option value="{{$cite->city_id}}">{{$cite->name}}</option>
									@endif
									@php
										array_push($regional, $cite->name);
									@endphp
								@endforeach
							</select>
						</div>
					</div>
					<form action="{{ route('formbooking.store') }}" method="post" enctype="multipart/form-data">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<h4 class="text-center"><strong> Informasi Paket </strong></h4>
					@csrf
					<center>
					@foreach ($brochures as $brochure)
						<img class="imagebrochure" src='{{$brochure->brochure_image_url}}' width="500px">	
					@endforeach
					<br><br>
					<div class="row text-capitalize">
						<div class="col-md-12">
							<div class="form-group">
								<h2>Regional {{ $city[0]->name }}</h2>
								<input value="{{ $city[0]->id }}" type="hidden" name="city_id" class="form-control" readonly placeholder="Nama Pemesan..."/>
							</div>
						</div>
					</div>
					</center>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="cardone">
			<div class="card">
				<div class="card-body">	
						<h3><strong>Informasi Data Pemesan </strong></h3>
						<hr>
						&nbsp;				
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
									<label>Pilih Paket</label>
									<br>
									<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#exampleModal">Pilih Paket</button>
									@error('packet_id')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
									<input type="hidden" name="packet_id" id="paket-id">
									<input type="text" id="paket-name" readonly>
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
					<br>
					<input
						name="status_transaction"
						type="hidden"
						value="online"
						readonly
					/>
					<div class="row text-capitalize">
						<div class="col-md-12">
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


	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Daftar Paket</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<table class="table table-striped table-responsive">
				<thead>
					<tr>
					<th scope="col">#</th>
					<th scope="col">Pilih</th>
					<th scope="col">Nama Paket</th>
					<th scope="col">Menu</th>
					<th scope="col">Porsi</th>
					<th scope="col">Keterangan</th>
					<th scope="col">Kategori</th>
					<th scope="col">Harga Jantan</th>
					<th scope="col">Harga Betina</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					@foreach ($pakets as $paket)

					<tr>
						<th scope="row">{{$no++}}</th>
						<td>
						    <button type="button" class="btn btn-success btn-sm"><i class="fas fa-hand-pointer" onclick="setPaket({{$paket->id}})"></i></button>
				    		<div id="InfoID-{{ $paket->id }}"
    							paket_id="{{ $paket->id }}"
    							paket_name="{!! $paket->nama !!}"
    						></div>
					    </td>
						<td>{{$paket->nama}}</td>
						<td>{{$paket->menu}}</td>
						<td>{{$paket->porsi}}</td>
						<td>{{$paket->keterangan}}</td>
						<td>{{$paket->kategori}}</td>
						@if($paket->harga != null)
							<td>{{$paket->harga}}</td>
						@else
							<td>-</td>
						@endif
						@if($paket->price != null)
							<td>{{$paket->price}}</td>
						@else
							<td>-</td>
						@endif
					</tr>
					@endforeach
				</tbody>
				</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
	</div>
@endsection
			
		{{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
		<script src="{{ asset('dist/js/jquery-3.3.1.min.js') }}"></script>
		<script>
				function setPaket(id) {
					const divPaketInfoID = document.getElementById(`InfoID-${id}`);
					const paketName = divPaketInfoID.getAttribute('paket_name');
					$('#paket-id').val(id)
					$('#paket-name').val(paketName) 
					$('#exampleModal').modal('hide');
				}
            $(document).ready(function(){
				$('.cities').on("change", function() {
						var city = parseInt($("#cities option:selected").val());
						// console.log(city);
						if (city) {
							window.location = "/formbooking/"+city;
						}
				});
            });
		</script>
		    {{-- Notify --}}
			@include('layouts.partials.noty')
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>