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
        <div class="cardone">
            <div class="card">
                <div class="card-body">
                    <center>
					<img src="{{asset('images/big/akikah_logo.jpg')}}" width="100px" height="100px">
					
					<h2 class="mytext">Pemesanan Paket</h2>
					</center>
					
					<form class="mt-5" action="/fullformbooking/update/{{ $bookings->no_nota  }}" method="post" enctype="multipart/form-data">
						<h4><strong> Informasi Paket </strong></h4>
						<hr>
						&nbsp;
						@csrf
						@method('post')
						<div class="form-body">
							<div class="row text-capitalize">
									<div class="full">
										<div class="form-group">
											<img width="150px" height="150px" src="{{ url('/storage/images/packets/'.$bookings->packet->gambar) }}" alt="Image Menu">
										</div> 
									</div>
									<div class="colpacket">
											<label class="font-weight-bold">Nama Mitra</label>
											<p class="text-capitalize">{{ $partner->name }}</p>
											<label class="font-weight-bold">Nama Paket</label>
											<p class="text-capitalize">{{ $bookings->packet->nama }}</p>
									</div>
									<div class="colpacket">
											<label class="font-weight-bold">Harga Jantan</label>
											<p class="text-capitalize">{{ format_rupiah($bookings->packet->harga) }}</p>
											<label class="font-weight-bold">Menu</label>
											<p class="text-capitalize">{{ $bookings->packet->menu }}</p>
									</div>
									<div class="colpacket">
											<label class="font-weight-bold">Porsi</label>
											<p class="text-capitalize">{{ $bookings->packet->porsi }}</p>
											<label class="font-weight-bold">Harga Betina</label> 
											<p class="text-capitalize">{{ format_rupiah($bookings->packet->price) }}</p>
									</div> 
									<div class="colpacket">
											<label class="font-weight-bold">Kategori</label>
											<p class="text-capitalize">{{ $bookings->packet->kategori }}</p>
											<label class="font-weight-bold">Kelebihan</label>
											<p class="text-capitalize">{{ $bookings->packet->kelebihan }}</p>
									</div> 
									<div class="colpacket">
											<label class="font-weight-bold">Keterangan</label>
											<p class="text-capitalize">{{ $bookings->packet->keterangan }}</p>
									</div>
								</div>
							{{-- inputan form --}}
						<input
							name="packet_id"
							type="hidden"
							value="{{ $bookings->packet->id }}"
						/>
							<input
								id="purchase"
								name="purchase"
								type="hidden"
								value="{{ $bookings->packet->harga }}"
							/>
						<input
							id="promo_id"
							name="promo_id"
							type="hidden"
						/>
						<input
							id="shipping_in"
							name="shipping_in"
							type="hidden"
							value="{{ ($shippings) ? $shippings->in_city_cost : 0 }}"
						/>
						<input
							id="shipping_out"
							name="shipping_out" 
							type="hidden"
							value="{{ ($shippings) ? $shippings->out_city_cost : 0 }}"
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
	<div class="cardone">
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
								<label>No Whatsapp *</label>
								<br>
								<input name="no_whatsapp" type="number" class="form-control @error('no_whatsapp') is-invalid @enderror" required placeholder="No Whatsapp..." value="{{ $bookings->no_whatsapp }}"/>
								@error('no_whatsapp')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Alamat Lengkap *</label>
								<input name="address" type="text" class="form-control @error('address_packet') is-invalid @enderror" required placeholder="Alamat Lengkap..." value="{{ $bookings->address }}"/>
								<span>^ Isi Alamat dengan lengkap</span>
								@error('address')
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
								<label>Email *</label>
								<input name="user_email" type="email" class="form-control @error('user_email') is-invalid @enderror" required placeholder="Email Pemesan..." value="{{ $bookings->user_email }}"/>
								@error('user_email')
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
						<div class="col-md-6">
							<div class="form-group">
								<label>Tanggal Pemotongan</label>
								<input name="time_slaughter" type="date" class="form-control @error('postal_code') is-invalid @enderror" required placeholder="Kode Pos..."/>
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
	<div class="cardone">
		<div class="card">
			<div class="card-body">
					<h3><strong>Pemesananan </strong></h3>
					<hr>
					&nbsp;
				<div class="form-body">
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Pilih Menu Tambahan : </label>
								&nbsp;
								<button type="button" class="form-control btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-booking">Pilih Menu Tambahan</button>
							</div>
							<input
								id="snack_id"
								name="snack_id"
								type="hidden"
							/>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Jenis Kambing *</label>
								<div class="form-control-type-purchace @error('type_goat') is-invalid @enderror">
									@if($bookings->packet->harga != null)
									<input type='radio' id="jantan" value="male" price="{{$bookings->packet->harga}}" name="type_goat" required checked> 
									<label for="jantan">Jantan</label>
									&nbsp;&nbsp;&nbsp;
									@endif
									@if($bookings->packet->price != null)
									<input type='radio' id="betina" value="female" price="{{$bookings->packet->price}}" name="type_goat" required>
									<label for="betina">Betina</label>
									@endif
									<input type="hidden" id="jk" name="jk">
									@error('type_goat')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								@error('type_goat')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
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
								<label for="">Harga Pesanan Menu Tambahan</label>
								<input id="snack" name="snack" type="text" class="inputId form-control" placeholder="Harga Pesanan Snack" readonly>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label>Promo</label>
								<br>
								<input name="kodepromo" id="kodepromo" type="text" class="form-control-promos" placeholder="Kode promo..."/>
								&nbsp;
								<button type="button" class="promoss btn btn-danger">cek</button>
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Subtotal untuk Produk</label>
								<input id="total_product" name="total_product" type="text" class="inputId form-control" placeholder="Total Untuk Produk" readonly>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Total Diskon Pembayaran</label>
								<input id="totaldiscount" name="totaldiscount" type="text" class="inputId form-control" placeholder="Total Potongan Harga" readonly>
								<input id="typediscount" type="hidden" name="typediscount">
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Biaya Kirim</label>
								<input id="shipping_charge" name="shipping_charge" type="text" class="inputId form-control" placeholder="Biaya Pengiriman" readonly>
							</div>
						</div>
					</div>
					<div class="row text-capitalize">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Total Pembayaran</label>
								<input id="total" name="total_purchase" type="text" class=" form-control" placeholder="Total Biaya" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Tipe Pembayaran *</label>
								<div class="form-control-type-purchace @error('total_booking') is-invalid @enderror">
									<input type='radio' id="full" value="full" name="type_purchase" required checked> 
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
	<!-- Modal Menu Tambahan-->
	<div class="modal fade bd-example-modal-lg" id="modal-booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="myModalLabel">Pilih Menu Tambahan Ini</h5>
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
				<h4 class="bold">Pesan Menu Tambahan Ini?</h4>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			<button type="button" class="snack btn btn-primary" data-dismiss="modal">Pesan</button>
			</div>
		</div> 
		</div>
	</div>
@endsection

			
		{{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
		<script src="{{ asset('dist/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
		<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
		<script src="{{ asset('libs/popper.js/dist/umd/popper.min.js') }}"></script>
		<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

		{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}

		<script type ="text/javascript">
			$(document).ready(function(){
				$('input[type=radio][name=type_goat]').change(function() {
					var user_city = parseInt($("#user_city").val()) 
					var jumlah = parseInt($("#total_booking").val())
					var harga = parseInt($("input[name=type_goat]:checked").attr("price"))
					var jk = $("input[name=type_goat]:checked").val()
					var shippings = parseInt($("#shipping_charge").val())
					var total_snack = parseInt($("#snack").val())
					var discount = parseInt($("#totaldiscount").val())
					var typediscount = parseInt($("#typediscount").val())
					
					const total_product = harga * jumlah;
					const random = Math.floor(100 + Math.random() * 899);

					if (total_snack) {
						if (discount) {
							const buy = total_product + shippings + total_snack;
							if(typediscount == 0){
							var total = buy - discount + random || '-';
							}else{
							var total = buy - (buy * typediscount / 100) + random || '-';
							}
						} else {
							var total = total_product + shippings + total_snack + random || '-';
						}
					}else{
						if (discount) {
							const buy = total_product + shippings;
							if(typediscount == 0){
							var total = buy - discount + random || '-';
							}else{
							var total = buy - (buy * typediscount / 100) + random || '-';
							}
						} else {
							var total = total_product + shippings + random || '-';
						}
					}

					$("#jk").val(jk)
					$("#total_product").val(total_product)
					$("#total").val(total)
				})

				$(".perhitungan").keyup(function(){
					var user_city = parseInt($("#user_city").val()) 
					var jumlah = parseInt($("#total_booking").val())
					var harga = parseInt($("input[name=type_goat]:checked").attr('price'))
					var jk = $("input[name=type_goat]:checked").val()
					var shippings = parseInt($("#shipping_charge").val())
					var total_snack = parseInt($("#snack").val())
					var discount = parseInt($("#totaldiscount").val())
					var typediscount = parseInt($("#typediscount").val())
					
					const total_product = harga * jumlah;
					const random = Math.floor(100 + Math.random() * 899);

					if (total_snack) {
						if (discount) {
							const buy = total_product + shippings + total_snack;
							if(typediscount == 0){
							var total = buy - discount + random || '-';
							}else{
							var total = buy - (buy * typediscount / 100) + random || '-';
							}
						} else {
							var total = total_product + shippings + total_snack + random || '-';
						}
						
					}else{
						if (discount) {
							const buy = total_product + shippings;
							if(typediscount == 0){
							var total = buy - discount + random || '-';
							}else{
							var total = buy - (buy * typediscount / 100) + random || '-';
							}
						} else {
							var total = total_product + shippings + random || '-';
						}
						
					}

					$("#jk").val(jk)
					$("#total_product").val(total_product)
					$("#total").val(total)
					
					$('.cities').click( function() {
						var city = parseInt($("#cities").val())
						var total_snack = parseInt($("#snack").val())
						var discount = parseInt($("#totaldiscount").val())
						var total_product = parseInt($("#total_product").val())
						var typediscount = parseInt($("#typediscount").val())

						if (city == user_city) {
							var shipping = parseInt($("#shipping_in").val())
						}else{
							var shipping = parseInt($("#shipping_out").val())
						}
							
						$("#shipping_charge").val(shipping)
						const random = Math.floor(100 + Math.random() * 899);
						
						if (total_snack) {
							if (discount) {
								const buy = total_product + shipping + total_snack;
								if(typediscount == 0){
								var total = buy - discount + random || '-';
								}else{
								var total = buy - (buy * typediscount / 100) + random || '-';
								}
							} else {
								var total = total_product + shipping + total_snack + random || '-';
							}
							
						}else{
							if (discount) {
								const buy = total_product + shipping;
								if(typediscount == 0){
								var total = buy - discount + random || '-';
								}else{
								var total = buy - (buy * typediscount / 100) + random || '-';
								}
							} else {
							var total = total_product + shipping + random || '-';
							}
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
						    id_snack.push(parseInt($(this).attr('target')));
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
						var discount = parseInt($("#totaldiscount").val())
						var total_product = parseInt($("#total_product").val())
						const random = Math.floor(100 + Math.random() * 899);
						var typediscount = parseInt($("#typediscount").val())
						
						if (discount) {
							const buy = total_product + shippings + total_snack;
								if(typediscount == 0){
								var total = buy - discount + random || '-';
								}else{
								var total = buy - (buy * typediscount / 100) + random || '-';
								}
						} else {
							var total = total_product + shippings + total_snack + random || '-';
						}
						
						$("#total").val(total)
					});
				});
			
					$('.cities').click( function() {
						var harga = parseInt($("#purchase").val())
						var user_city = parseInt($("#user_city").val())
						var city = parseInt($("#cities").val())
						var total_snack = parseInt($("#snack").val())
						var total_product = parseInt($("#total_product").val())
						var discount = parseInt($("#totaldiscount").val())
						var typediscount = parseInt($("#typediscount").val())	
						const random = Math.floor(100 + Math.random() * 899);

						if (city == user_city) {
							var shipping = parseInt($("#shipping_in").val())
							if(total_snack){
								if (discount) {
									const buy = total_snack + total_product + shipping;
									if(typediscount == 0){
									var total = buy - discount + random || '-';
									}else{
									var total = buy - (buy * typediscount / 100) + random || '-';
									}
								} else {
									var total = total_snack + total_product + shipping + random || '-';
								}
							}else{
								if (discount) {
									const buy = total_product + shipping + random;
									if(typediscount == 0){
									var total = buy - discount + random || '-';
									}else{
									var total = buy - (buy * typediscount / 100) + random || '-';
									}
								} else {
									var total = total_product + shipping + random || '-';
								}
							}
						}else{
							var shipping = parseInt($("#shipping_out").val())
							if(total_snack){
								if (discount) {
									const buy = total_snack + total_product + shipping;
									if(typediscount == 0){
									var total = buy - discount + random || '-';
									}else{
									var total = buy - (buy * typediscount / 100) + random || '-';
									}
								} else {
									var total = total_snack + total_product + shipping + random || '-';
								}
							}else{
								if (discount) {
									const buy = total_product + shipping + random;
									if(typediscount == 0){
									var total = buy - discount + random || '-';
									}else{
									var total = buy - (buy * typediscount / 100) + random || '-';
									}
								} else {
									var total = total_product + shipping + random || '-';
								}
							}
						}
							
						$("#shipping_charge").val(shipping)
						$("#total").val(total)
					});
					$(".snack").click(function(){
						var favorite = [];
						$.each($("input[name='snack']:checked"), function(){            
							favorite.push(parseInt($(this).val()));
						});
						var id_snack = [];
						$.each($("input[name='snack']:checked"), function(){            
						    // id_snack.push(parseInt(document.getElementById($(this).val()).getAttribute("target")));
							id_snack.push(parseInt($(this).attr('target')));
						});
						
						$("#snack_id").attr("value",id_snack)
						var total_snack = 0;
						for(i = 0; i <favorite.length; i++){
							total_snack += favorite[i];
						}
						$("#snack").val(total_snack)
						$('#modal-booking').modal('hide');
						
						var jumlah = parseInt($("#total_booking").val())
						var harga = parseInt($("#purchase").val())
						var shippings = parseInt($("#shipping_charge").val())
						var discount = parseInt($("#totaldiscount").val())
						var total_product = parseInt($("#total_product").val())
						const random = Math.floor(100 + Math.random() * 899);
						var typediscount = parseInt($("#typediscount").val())
						
						if (discount) {
							const buy = total_product + shippings + total_snack;
								if(typediscount == 0){
								var total = buy - discount + random || '-';
								}else{
								var total = buy - (buy * typediscount / 100) + random || '-';
								}
						} else {
							var total = total_product + shippings + total_snack + random || '-';
						}
						$("#total").val(total)
					});
					$('.promoss').click(function() {

					var kode = $("#kodepromo").val() || '-'
					var user_id = $("#user_id").val()

						$.ajax({

							type:"GET",
							url:"/cari/"+kode,
							success: function(data) {
								var totald = data.code || '-';
								var totalt = data.type;
								let promo_id = data.id;
								var totalp = data.discount_amount;
								
								$("#promo_id").val(promo_id)
								// jumlah pemesanan
								var jumlah = parseInt($("#total_booking").val())
								// harga paket
								var harga = parseInt($("#purchase").val())
								// harga ongkir
								var shippings = parseInt($("#shipping_charge").val())
								// harga snack
								var total_snack = parseInt($("#snack").val())
								// subtotal
								var subtotal = parseInt($("#total_product").val())
								// var totalold = parseInt($("#total").val())
								if (data === '-') {
									Swal.fire({
										type: 'error',
										title: 'Promo diskon tidak ada.'
									})	
								}else{
                                    const random = Math.round(100 + Math.random() * 899);
                                    
									if (totalt === 'price') {
										
										$("#totaldiscount").val(totalp)
										$("#typediscount").val(0)
										if (total_snack) {
											var total = subtotal + shippings + total_snack - totalp + random || '-';
										}else{
											var total = subtotal + shippings - totalp + random || '-';
										}

										$("#total").val(total)
									} else {		
										
										$("#totaldiscount").val(`${totalp}%`)
										$("#typediscount").val(totalp)
										if (total_snack) {
											const buy = subtotal + shippings + total_snack;
											var total = buy - (buy * totalp / 100)  + random || '-';
										}else{
											const buy = subtotal + shippings;
											var total = buy - (buy * totalp / 100)  + random || '-';
										}
										$("#total").val(total)
									}
									
									Swal.fire({
										type: 'success',
										title: 'Selamat anda mendapatkan diskon.'
									})	
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