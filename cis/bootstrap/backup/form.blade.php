@extends('layouts.no-header-sidebar.app')

@section('title', 'Akikahkita | Customer')
@section('content-title', 'Input Data Customer')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
		{{-- <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet"> --}}
@endpush


@section('content')
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
					<img src="{{asset('images/big/akikah_logo.jpg')}}" width="100px" height="100px">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<h2 class="mytext">Pemesanan Paket</h2>
					
					<form class="mt-5" action="/fullformbooking/update/{{ $bookings->no_nota  }}" method="post" enctype="multipart/form-data">
						<h4><strong> Informasi Paket </strong></h4>
						<hr>
						&nbsp;
						@csrf
						@method('post')
						<div class="form-body">
							<div class="row text-capitalize">
									<div class="col-md-3">
										<div class="form-group">
											<img width="100%" height="200px" src="{{ url('/storage/images/packets/'.$bookings->packet->gambar) }}" alt="Image Menu">
										</div> 
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Nama Mitra</label>
											<input value="{{ $bookings->packet->user->name }}" type="text" class="form-control" readonly placeholder="Nama Pemesan..."/>
										</div>
										<div class="form-group">
											<label>Nama Paket</label>
											<input value="{{ $bookings->packet->nama }}" type="text" class="form-control" readonly placeholder="Nama Pemesan..."/>
										</div>
										<div class="form-group">
											<label>Jenis</label>
											<input value="{{ $bookings->packet->jk }}" type="text" class="form-control" readonly placeholder="Jenis..." />
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Menu</label>
											<input value="{{ $bookings->packet->menu }}" type="text" class="form-control" readonly placeholder="Alamat Pemesan..." />
										</div>
										<div class="form-group">
											<label>Porsi</label>
											<input value="{{ $bookings->packet->porsi }}" type="text" class="form-control" readonly placeholder="Porsi..." />
										</div>
										<div class="form-group">
											<label>Harga</label> 
											@foreach ($profitMitra as $profitMitras)
											<input value="@currency($profitMitras->selling_price)" type="text" class="form-control" readonly placeholder="Alamat Pemesan..." />
											@endforeach
										</div>
									</div> 
									<div class="col-md-3">
										<div class="form-group">
											<label>Kategori</label>
											<input value="{{ $bookings->packet->kategori }}" type="text" class="form-control" readonly placeholder="Alamat Pemesan..." />
										</div>
										<div class="form-group">
											<label>Kelebihan</label>
											<input value="{{ $bookings->packet->kelebihan }}" type="text" class="form-control" readonly placeholder="Nama Pemesan..."/>
										</div>
										<div class="form-group">
											<label>Keterangan</label>
											<textarea  class="form-control" readonly placeholder="Nama Pemesan...">{{ $bookings->packet->keterangan }}</textarea>
										</div>
									</div>
								</div>
							{{-- inputan form --}}
						<input
							name="packet_id"
							type="hidden"
							value="{{ $bookings->packet->id }}"
						/>
						@foreach ($profitMitra as $profitMitras)
							<input
								id="purchase"
								name="purchase"
								type="hidden"
								value="{{ $profitMitras->selling_price }}"
							/>
						@endforeach
						<input
							id="purchase"
							name="purchase"
							type="hidden"
							value="{{ $bookings->packet->harga }}"
						/>
						<input
							id="shipping_in"
							name="shipping_in"
							type="hidden"
							value="{{ $shippings->in_city_cost }}"
						/>
						<input
							id="shipping_out"
							name="shipping_out" 
							type="hidden"
							value="{{ $shippings->out_city_cost }}"
						/>
						<input
							id="user_city"
							name="user_city"
							type="hidden"
							value="{{ $bookings->user->city_id }}"
						/>
						<input
							id="user_id"
							name="user_id"
							type="hidden"
							value="{{ $bookings->user_id }}"
						/>
						<input
							name="id"
							type="hidden"
							value="{{ $bookings->id }}"
						/>
				</div>
			</div>
		</div>
	</div>
	<div class="col-10">
		<div class="card">
			<div class="card-body">
				<h3><strong>Informasi Data Pemesan </strong></h3>
				<hr>
				&nbsp;
				<div class="form-body">
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama *</label>
								<input name="name" type="text" class="form-control @error('name') is-invalid @enderror" required placeholder="Nama Pemesan..." value="{{ $bookings->name }}"/>
								<span>^ Nama Pemesan</span>
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email *</label>
								<input name="user_email" type="email" class="form-control @error('user_email') is-invalid @enderror" required placeholder="Email Pemesan..." value="{{ $bookings->user_email }}"/>
								@error('user_email')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Alamat Lengkap *</label>
								<input name="address_packet" type="text" class="form-control @error('address_packet') is-invalid @enderror" required placeholder="Alamat Lengkap..." value="{{ $bookings->address }}"/>
								<span>^ Isi Alamat dengan lengkap</span>
								@error('address_packet')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Kota *</label>
									<select required id="cities" name="city_id" class="cities form-control @error('city_id') is-invalid @enderror" >
										<option value="">Pilih kota...</option>
										@foreach ($cities as $city)
											<option value="{{$city->id}}">{{$city->name}}</option>
										@endforeach
									</select>
								@error('city_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>No Whatsapp *</label>
								{{-- <input type="text" class="form-control-phone-62" placeholder="+62" readonly> --}}
								<input name="no_whatsapp" type="number" class="form-control @error('no_whatsapp') is-invalid @enderror" required placeholder="No Whatsapp..." value="{{ $bookings->no_whatsapp }}"/>
								<span>^ Contoh 85123456789</span>
								@error('no_whatsapp')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Anak *</label>
								<input name="name_aqiqah" type="text" class="form-control @error('name_aqiqah') is-invalid @enderror" required placeholder="Nama Anak..." value="{{ $bookings->name_aqiqah }}"/>
								<span>^ Nama yang akan di aqiqah</span>
								@error('name_aqiqah')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Ayah *</label>
								<input name="name_father" type="text" class="form-control @error('name_father') is-invalid @enderror" required placeholder="Nama Ayah..." value="{{ $bookings->name_father }}"/>
								@error('name_father')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Ibu *</label>
								<input name="name_mother" type="text" class="form-control @error('name_mother') is-invalid @enderror" required placeholder="Nama Ibu..."/>
								@error('name_mother')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Kode Pos *</label>
								<input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" required placeholder="Kode Pos..."/>
								@error('postal_code')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-10">
		<div class="card">
			<div class="card-body">
					<h3><strong>Pemesananan </strong></h3>
					<hr>
					&nbsp;
				<div class="form-body">
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Pilih Snack : </label>
								&nbsp;
								<button type="button" class="form-control btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-booking">Pilih Snack</button>
							</div>
							<input
								id="snack_id"
								name="snack_id"
								type="hidden"
							/>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Jumlah Pemesanan *</label>
								<input name="total_booking" id="total_booking" type="number" class="perhitungan form-control @error('total_booking') is-invalid @enderror" required placeholder="Jumlah Pemesanan..."/>
								@error('total_booking')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Harga Pesanan Snack</label>
								<input id="snack" name="snack" type="text" class="form-control" placeholder="Harga Pesanan Snack" readonly>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Promo</label>
								<br>
								<input name="kodepromo" id="kodepromo" type="text" class="perhitungan form-control-promos" placeholder="Kode promo..."/>
								&nbsp;
								<button type="button" class="promoss btn btn-primary">cek</button>
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Subtotal untuk Produk</label>
								<input id="total_product" name="total_product" type="text" class="form-control" placeholder="Total Untuk Produk" readonly>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Total Diskon Pembayaran</label>
								<input id="totaldiscount" name="totaldiscount" type="text" class="form-control" placeholder="Total Potongan Harga" readonly>
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Biaya Kirim</label>
								<input id="shipping_charge" name="shipping_charge" type="text" class="form-control" placeholder="Biaya Pengiriman" readonly>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Total Pembayaran</label>
								<input id="total" name="total_purchase" type="text" class="form-control" placeholder="Total Biaya" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Tipe Pembayaran *</label>
								<div class="form-control-type-purchace @error('total_booking') is-invalid @enderror">
									<input type='radio' id="full" value="full" name="type_purchase" required> 
									<label for="full">Full</label>
									&nbsp;&nbsp;&nbsp;
									<input type='radio' id="dp" value="dp" name="type_purchase" required>
									<label for="dp">DP (50%)</label>
									@error('type_purchase')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
					</div>
						<div class="row text-capitalize">
						<div class="col-md-6">
							<span>Yang bertanda * WAJIB diisi</span>
						</div>
						</div>
						<br>
						<button type="submit" class="btn btn-primary">Buat Pesanan</button>
				</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade bd-example-modal-lg" id="modal-booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="myModalLabel">Pemesanan Snack</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive mt-5">
							<table class="table">
								<thead>
									<tr>
										<th scope="col"></th>
										<th scope="col">Nama</th>
										<th scope="col">Harga</th>
										<th scope="col">Deskripsi</th>
										<th scope="col">Foto</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($snacks as $snack)
										<tr>
											<td><input type='checkbox' id="{{ $snack->price }}" target="{{ $snack->id }}" value='{{ $snack->price }}' name='snack'></td>
											<td>{{ $snack->name }}</td>
											<td>@currency($snack->price)</td>
											<td>{{ $snack->description }}</td>
											<td>
												<img class="img-responsive" style="width:100px;" src="{{ $snack->photo_url }}"/>
											</td>	
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<h4 class="bold">Pesan Snack Ini?</h4>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="snack btn btn-primary" data-dismiss="modal">Pesan</button>
			</div>
		</div>
		</div>
	</div>
@endsection

			
		{{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
		<script src="{{ asset('dist/js/jquery-3.3.1.min.js') }}"></script>

		<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
		<script src="{{ asset('libs/popper.js/dist/umd/popper.min.js') }}"></script>
		<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

		{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}

		<script type ="text/javascript">
			$(document).ready(function(){
				$(".perhitungan").keyup(function(){
					var user_city = parseInt($("#user_city").val()) 
					var jumlah = parseInt($("#total_booking").val())
					var harga = parseInt($("#purchase").val())
					var shippings = parseInt($("#shipping_charge").val())
					var total_snack = parseInt($("#snack").val())

					
					const total_product = harga * jumlah || '-';

					// var myInput = document.getElementById("snack");
					if (total_snack) {
						// alert("My input has a value!");
						var total = harga * jumlah + shippings + total_snack || '-';
					}else{
						var total = harga * jumlah + shippings || '-';
					}

					$("#total_product").val(total_product)
					$("#total").val(total)
					
					$('.cities').click( function() {
						var city = parseInt($("#cities").val())
						var total_snack = parseInt($("#snack").val())

						if (city == user_city) {
							var shipping = parseInt($("#shipping_in").val())
						}else{
							var shipping = parseInt($("#shipping_out").val())
						}
							
						$("#shipping_charge").val(shipping)
						
						if (total_snack) {
							// alert("My input has a value!");
							var total = harga * jumlah + shipping + total_snack || '-';
						}else{
							var total = harga * jumlah + shipping || '-';
						}
						$("#total").val(total)
					});
					$(".snack").click(function(){
						var favorite = [];
						$.each($("input[name='snack']:checked"), function(){            
							favorite.push(parseInt($(this).val()));
						});
						var id_snack = [];
						$.each($("input[name='snack']:checked"), function(){            
						    id_snack.push(parseInt(document.getElementById($(this).val()).getAttribute("target")));
						});
						$("#snack_id").val(id_snack)
						var total_snack = 0;
						for(i = 0; i <favorite.length; i++){
							total_snack += favorite[i];
						}
						$("#snack").val(total_snack)
						$('#modal-booking').modal('hide');
						
						// alert("My favourite sports are: " + );
						var jumlah = parseInt($("#total_booking").val())
						var harga = parseInt($("#purchase").val())
						var shippings = parseInt($("#shipping_charge").val())
						var total = harga * jumlah + shippings + total_snack || '-';
						$("#total").val(total)
					});
				});
			
					$('.cities').click( function() {
						var harga = parseInt($("#purchase").val())
						var user_city = parseInt($("#user_city").val())
						var city = parseInt($("#cities").val())

						if (city == user_city) {
							var shipping = parseInt($("#shipping_in").val())
						}else{
							var shipping = parseInt($("#shipping_out").val())
						}
							
						$("#shipping_charge").val(shipping)
					});
					$(".snack").click(function(){
						var favorite = [];
						$.each($("input[name='snack']:checked"), function(){            
							favorite.push(parseInt($(this).val()));
						});
						var id_snack = [];
						$.each($("input[name='snack']:checked"), function(){            
						    id_snack.push(parseInt(document.getElementById($(this).val()).getAttribute("target")));
						});
						$("#snack_id").attr("value",id_snack)
						var total_snack = 0;
						for(i = 0; i <favorite.length; i++){
							total_snack += favorite[i];
						}
						$("#snack").val(total_snack)
						$('#modal-booking').modal('hide');
						
						// alert("My favourite sports are: " + );
						var jumlah = parseInt($("#total_booking").val())
						var harga = parseInt($("#purchase").val())
						var shippings = parseInt($("#shipping_charge").val())
						var total = harga * jumlah + shippings + total_snack || '-';
						$("#total").val(total)
					});
					$('.promoss').click(function() {

					var kode = $("#kodepromo").val() || '-'
					var user_id = $("#user_id").val()

						$.ajax({

							type:"GET",
							url:"/cari/"+kode+"/"+user_id,
							success: function(data) {
								var totald = data.code || '-';
								var totalt = data.type;
								var totalp = data.discount_amount;

								// jumlah pemesanan
								var jumlah = parseInt($("#jumlah").val())
								// harga paket
								var harga = parseInt($("#purchase").val())
								// harga ongkir
								var shippings = parseInt($("#shipping_charge").val())
								// harga snack
								var total_snack = parseInt($("#snack").val())
								// subtotal
								var subtotal = parseInt($("#total_product").val())
								if (totald === '-') {
									alert("Sorry, You dont have discount");	
								}else{

									if (totalt === 'price') {
										// jumlah diskon
										$("#totaldiscount").attr("value",totalp)
										if (total_snack) {
											var total = harga * jumlah + shippings + total_snack - totalp;
										}else{
											var total = harga * jumlah + shippings - totalp || '-';
										}

										$("#total").attr("value",total)
									} else {		
										// jumlah diskon
										$("#totaldiscount").attr("value",`${totalp}%`)
										if (total_snack) {
											// alert("My input has a value!");
											var total = harga * jumlah + shippings + total_snack - (harga * totalp / 100) || '-';
										}else{
											var total = harga * jumlah + shippings - (harga * totalp / 100) || '-';
										}
										$("#total").attr("value",total)
									}
									alert('Your Discount is '+totald);	
								}
								
							}
						});
					// To Stop the loading of page after a button is clicked
					return false;
				});
			});
		</script>
		
		    {{-- Notify --}}
			@include('layouts.partials.noty')
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>