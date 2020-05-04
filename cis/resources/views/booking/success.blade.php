@extends('layouts.no-header-sidebar.app')

@section('title', 'Terima Kasih')
@section('content-title', 'Terimas Kasih')

@push('css')
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{asset('dist/css/styleoption.css')}}">
@endpush


@section('content')
	<div class="row justify-content-center hoverable">
		<div class="col-8">
			<div class="card">
				{{-- <div class="card-header text-white bg-success">
					<h1 class="text-center">Berhasil</h1>
				</div> --}}
				{{-- <div class="card-body"> --}}
					{{-- <div class="row text-capitalize"> --}}
						{{-- <div class="col-md-12"> --}}
							{{-- <div class="form-group"> --}}
								{{-- <img class="mr-3" align="center" src="{{url('/storage/images/gif/sheep.gif')}}" alt="animated">
								<h3>Terimakasih telah memesan akikah di akikahkita.com. Semoga Berkah</h3> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button onclick="var delay = 500; var url = 'https://akikahkita.com'; setTimeout(function(){ window.location = url; }, delay); " id="tombol" class="success btn btn-primary btn-lg btn-block" >Ok</button> --}}
							{{-- </div>  --}}
						{{-- </div> --}}
					{{-- </div> --}}
				{{-- </div> --}}
			</div>
		</div>
	</div>
@endsection
			
		{{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
		<script src="{{ asset('dist/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
		<script src="{{ asset('libs/popper.js/dist/umd/popper.min.js') }}"></script>
		<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
		<script>
			$(document).ready(function(){
				Swal.fire({
					title: 'Terima Kasih',
					text: 'Terimakasih telah memesan akikah di Akikahkita.com, Semoga Berkah..',
					width: 600,
					padding: '3em',
					showClass: {
									popup: 'animated fadeInDown faster'
								},
								hideClass: {
									popup: 'animated fadeOutUp faster'
								},
					background: '#fff url(https://www.gambaranimasi.org/templates/gifstheme/assets/images/signature-header.png)',
					backdrop: `
						rgba(251, 255, 224, 1)
						url("https://www.gambaranimasi.org/data/media/234/animasi-bergerak-kambing-0029.gif")
						center top
						no-repeat
					`
				}).then(function() {
					window.location = "https://akikahkita.com";
				});
			})
		</script>


		    {{-- Notify --}}
			@include('layouts.partials.noty')
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>