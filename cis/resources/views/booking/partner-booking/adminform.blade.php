@extends('layouts.admin')

@section('title', 'Akikahkita | Pemesanan')
@section('content-title', 'Form Pemesanan')

@push('css')
    <link href="{{ asset('extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    	<!-- STYLE CSS OPTION -->
    <link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
        <!-- Style Datepicker -->
    <link rel="stylesheet" href="{{asset('dist/css/jquery-ui.css')}}">
@endpush

@section('content')
    <div class="row">  
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Transaksi Offline - Lead AkikahKita</h4>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-paket">Cari Paket</button>
                    <br><br><br>
                    <form action="{{ route('partnerBookingForm.store')}}" method="post" enctype="multipart/form-data">
                    <label>Nama Paket : </label>
                    <input type="text" id="paket" name="paket" class="form-control-packets @error('paket') is-invalid @enderror" required readonly>
                    @error('paket')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="row">  
                        <div class="col-12"> 
                            <div class="card">
                                <div class="card-body">
                                
                                    <hr>
                                    @csrf
                                        <input type="hidden" id="packet_id" name="packet_id" readonly>
                                        <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}" readonly>
                                        <input type="hidden" id="promo_id" name="promo_id" readonly>

                                        <input
                                            id="user_city"
                                            name="user_city"
                                            type="hidden"
                                            value="{{ $city_id }}"
                                            readonly
                                        />
                                        <input
                                            name="status_transaction"
                                            type="hidden"
                                            value="offline lead"
                                            readonly
                                        />
                                        <input
                                            id="shipping_in"
                                            name="shipping_in"
                                            type="hidden"  
                                            value="{{ ($shippings) ? $shippings->in_city_cost : 0 }}"
                                            readonly
                                        /> 
                                        <input
                                            id="shipping_out"
                                            name="shipping_out" 
                                            type="hidden"
                                            value="{{ ($shippings) ? $shippings->out_city_cost : 0 }}"
                                            readonly
                                        />
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
                                                    <label>Nama Anak *</label>
                                                    <input name="name_aqiqah" type="text" class="form-control @error('name_aqiqah') is-invalid @enderror" required placeholder="Nama Anak..." value=""/>
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
                                                    <input name="name_father" type="text" class="form-control @error('name_father') is-invalid @enderror" required placeholder="Nama Ayah..." value=""/>
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
                                                    <label>Email *</label>
                                                    <input name="user_email" type="email" class="form-control @error('user_email') is-invalid @enderror" required placeholder="Email Pemesan..."/>
                                                    @error('user_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
                                                    <label>Kode Pos *</label>
                                                    <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" required placeholder="Kode Pos..."/>
                                                    @error('postal_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alamat Lengkap *</label>
                                                    <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" required placeholder="Alamat Pemesan..." />
                                                    <span>^ Alamat Pengiriman</span>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cities">Kota *</label>
                                                        <select required id="cities" name="city_id" class="cities form-control @error('city_id') is-invalid @enderror" >
                                                            <option value="">Pilih kota...</option>
                                                            @foreach ($city as $citi)
                                                                <option value="{{$citi->id}}">{{$citi->name}}</option>
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
                                                    <label>Jenis Kambing *</label>
                                                    <div class="form-control-type-purchace @error('type_goat') is-invalid @enderror">
                                                        <input class="show_male" type='radio' id="male" value="male" price="" name="type_goat" required checked> 
                                                        <label class="show_male" for="jantan">Jantan</label>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <input class="show_female" type='radio' id="female" value="female" price="" name="type_goat" required>
                                                        <label class="show_female" for="betina">Betina</label>
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
                                        </div>
                                        <div class="row text-capitalize">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jumlah Pemesanan *</label>
                                                    <input name="total_booking" id="total_booking" type="number" class="perhitungan form-control @error('total_booking') is-invalid @enderror" min="0" required placeholder="Jumlah Pemesanan..."/>
                                                    @error('total_booking')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Harga Pesanan Menu Tambahan</label>
                                                    <input id="snack" name="snack" type="text" class="form-control" placeholder="Harga Pesanan Snack" readonly>
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
                                                    <input id="typediscount" type="hidden" name="typediscount">
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
                                                    <label for="payment">Tipe Cara Pembayaran</label>
                                                        <select required id="payment" name="type_payment" class="form-control @error('type_payment') is-invalid @enderror" >
                                                            <option value="">Pilih Cara Pembayaran</option>
                                                            <option value="offline transfer">Bayar Transfer</option>
                                                            <option value="offline">Bayar Langsung Ke Mitra</option>
                                                        </select>
                                                    @error('type_payment')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
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
                                                <div class="form-group">
                                                    <label for="">Total Pembayaran</label>
                                                    <input id="total" name="total_purchase" type="text" class="form-control" placeholder="Total Biaya" readonly>
                                                </div>
                                            </div>
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
            </div>
        </div>
    </div> 
</div>
<!-- Modal Paket -->
<div class="modal fade bd-example-modal-xl" id="modal-paket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">List Paket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive mt-5">
                        <table id="paketTable"class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Regional</th>
                                    <th scope="col">Paket</th>
                                    <th scope="col">Menu</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Porsi</th>
                                    <th scope="col">Harga Jantan</th>
                                    <th scope="col">Harga Betina</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Foto</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach ($pakets as $pakets)
                                    @if ($pakets->city_id == Auth::user()->city_id)
                                        <tr>
                                        <td><input type='radio' id="{{$pakets->harga    }}" payment="{{$pakets->price}}" price="{{$pakets->harga}}" target="{{ $pakets->id }}" value='{{ $pakets->nama }}' name='selectPaket' required></td>
                                            <td><label for="{{$pakets->harga}}"><small>{{ $pakets->city->name}}</small></label></td>
                                            <td><small>{{ $pakets->nama }}</small></td>
                                            <td><small>{{ $pakets->menu }}</small></td>
                                            <td><small>{{ $pakets->kategori }}</small></td>
                                            <td><small>{{ $pakets->porsi }}</small></td>
                                            <td><small>@currency ($pakets->harga )</small></td>
                                            <td><small>@currency( $pakets->price )</small></td>
                                            <td><small>{{ $pakets->keterangan }}</small></td>
                                            <td>
                                                <img class="img-responsive" style="width:100px;" src="{{ url('/storage/images/packets/'.$pakets->gambar) }}"/>
                                            </td>	
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <h4 class="bold">Pesan Paket Ini?</h4>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="paket btn btn-primary" data-dismiss="modal">Pesan</button>
        </div>
    </div>
    </div>
</div>
<!-- Modal Menu Tambahan -->
<div class="modal fade bd-example-modal-lg" id="modal-booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Pilih Menu Tambahan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="snack btn btn-primary" data-dismiss="modal">Pesan</button>
        </div>
    </div>
    </div>
</div>
    @section('scripts')
    <script src="{{ asset('extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $('#paketTable').DataTable();
    </script>
    <script src="{{asset('dist/js/jquery-ui.js')}}"></script>
    <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
            {{-- @section('scripts') --}}
        {{-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> --}}
    <script src="{{asset('dist/js/jquery-ui.js')}}"></script>
    <script>
        $(document).ready(function (){

            $(".paket").click(function(){
                let paket = $("input[name='selectPaket']:checked").val()
                let packet_id = $("input[name='selectPaket']:checked").attr("target")
                let price = parseInt($("input[name='selectPaket']:checked").attr("price"))
                let payment = parseInt($("input[name='selectPaket']:checked").attr("payment"))
                
                if($("input[name='selectPaket']:checked").attr("price") == '' ){
                    $(".show_male").hide();
                    $("#male").removeProp('checked');
                    $("#female").prop('checked', 'checked');
                }else{
                    $(".show_male").show();
                }
                if($("input[name='selectPaket']:checked").attr("payment") == '' ){
                    $(".show_female").hide();
                    $("#female").removeProp('checked');
                    $("#male").prop('checked', 'checked');
                }else{
                    $(".show_female").show();
                }
                
                $("#male").attr('price',price)
                $("#female").attr('price', payment)
                $("#paket").val(paket)
                $("#packet_id").val(packet_id)
                // $("#purchase").val(price)
                var user_city = parseInt($("#user_city").val()) 
                var total_booking = parseInt($("#total_booking").val())
                var discount = parseInt($("#totaldiscount").val())
                var shippings = parseInt($("#shipping_charge").val())
                var total_snack = parseInt($("#snack").val())
                var amount = parseInt($("input[name='type_goat']:checked").attr("price"))
                var jk = $("input[name=type_goat]:checked").val()
                var typediscount = parseInt($("#typediscount").val())
                

                const total_product = total_booking * amount ;
                const random = Math.floor(100 + Math.random() * 899);

                if (total_snack) {
                    if (discount) {
                        var buy = total_product + shippings + total_snack;
                        if(typediscount == 0){
                            var total = buy - discount + random || '-';
                        }else{
                            var total = buy - (buy * typediscount / 100) + random || '-';
                        }
                    } else {
                        var total = total_product + shippings + total_snack + random || '-';
                    }
                }
                else{
                    if (discount) {
                        var buy = total_product + shippings;
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
                
            });

            $('input[type=radio][name=type_goat]').change(function() {
					var user_city = parseInt($("#user_city").val()) 
					var total_booking = parseInt($("#total_booking").val())
					var amount = parseInt($("input[name=type_goat]:checked").attr("price"))
					var jk = $("input[name=type_goat]:checked").val()
					var shippings = parseInt($("#shipping_charge").val())
					var total_snack = parseInt($("#snack").val())
					var discount = parseInt($("#totaldiscount").val())
					var typediscount = parseInt($("#typediscount").val())
					
					const total_product = amount * total_booking;
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
					var total_booking = parseInt($("#total_booking").val())
					var amount = parseInt($("input[name='type_goat']:checked").attr("price"))
					var shippings = parseInt($("#shipping_charge").val())
					var total_snack = parseInt($("#snack").val())
                    var discount = parseInt($("#totaldiscount").val())
                    var typediscount = parseInt($("#typediscount").val())

					
					const total_product = amount * total_booking;
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

					$("#total_product").val(total_product)
					$("#total").val(total)
					
					$('.cities').click( function() {
						var city = parseInt($("#cities").val())
						var total_snack = parseInt($("#snack").val())
                        var discount = parseInt($("#totaldiscount").val())
                        var typediscount = parseInt($("#typediscount").val())

						if (city == user_city) {
							var shipping = parseInt($("#shipping_in").val())
						}else{
							var shipping = parseInt($("#shipping_out").val())
						}
							
						$("#shipping_charge").val(shipping)
						
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
						    // id_snack.push(parseInt(document.getElementById($(this).val()).getAttribute("target")));
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
						// var jumlah = parseInt($("#total_booking").val())
						// var harga = parseInt($("#purchase").val())
						var shippings = parseInt($("#shipping_charge").val())
                        var discount = parseInt($("#totaldiscount").val())
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
						var city = parseInt($("#cities").val())
                        var user_city = parseInt($("#user_city").val()) 
						var total_snack = parseInt($("#snack").val())
                        var discount = parseInt($("#totaldiscount").val())
                        var typediscount = parseInt($("#typediscount").val())
                        var total_booking = parseInt($("#total_booking").val())
					    var amount = parseInt($("input[name='type_goat']:checked").attr("price"))

						if (city == user_city) {
							var shipping = parseInt($("#shipping_in").val())
						}else{
							var shipping = parseInt($("#shipping_out").val())
						}
							
						$("#shipping_charge").val(shipping)

                        const total_product = amount * total_booking;
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
						    // id_snack.push(parseInt(document.getElementById($(this).val()).getAttribute("target")));
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
						// var jumlah = parseInt($("#total_booking").val())
						// var harga = parseInt($("#purchase").val())
						var shippings = parseInt($("#shipping_charge").val())
                        var total_product = parseInt($("#total_product").val());
                        var discount = parseInt($("#totaldiscount").val())
                        var typediscount = parseInt($("#typediscount").val())
                        const random = Math.floor(100 + Math.random() * 899);
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
							url:"/partnercari/"+kode,
							success: function(data) {
								var totald = data.code || '-';
                                let promo_id = data.id;
								var totalt = data.type;
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
								if (data === '-') {
                                    Swal.fire({
										type: 'error',
										title: 'Promo diskon tidak ada.'
									})	
								}else{
                                    const random = Math.floor(100 + Math.random() * 899);

									if (totalt === 'price') {
										// jumlah diskon
                                        $("#totaldiscount").val(totalp)
										$("#typediscount").val(0)
										if (total_snack) {
											var total = subtotal + shippings + total_snack - totalp + random || '-';
										}else{
											var total = subtotal + shippings - totalp + random || '-';
										}
										$("#total").val(total)
									} else {		
										// jumlah diskon
										$("#totaldiscount").val(`${totalp}%`)
                                        $("#typediscount").val(totalp)
										if (total_snack) {
                                            const buy = subtotal + shippings + total_snack;
											var total = buy - (buy * totalp / 100) + random || '-';
										}else{
                                            const buy = subtotal + shippings;
											var total = buy - (buy * totalp / 100) + random || '-';
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
    @endsection

@endsection
