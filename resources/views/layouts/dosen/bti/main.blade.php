<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		<link rel="shortcut icon" href="img/fav.png" />

		<!-- Title -->
		<title>Ujian Online UBSI</title>


		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="{{asset('assets/uji/css/bootstrap.min.css')}}">

		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" href="{{asset('assets/uji/fonts/style.css')}}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{asset('assets/uji/css/main.css')}}">


		<!-- *************
			************ Vendor Css Files *************
		************ -->
		<!-- DateRange css -->
		<link rel="stylesheet" href="{{asset('assets/uji/vendor/daterange/daterange.css')}}" />

		<!-- jQcloud Keywords css -->
		<link rel="stylesheet" href="{{asset('assets/uji/vendor/jqcloud/jqcloud.css')}}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4-custom.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/buttons.bs.css') }}"/>

	</head>
	<body>

		<!-- Loading starts -->
	
		<!-- Loading ends -->


		<!-- *************
			************ Header section start *************
		************* -->

		<!-- Header start -->
		<header class="header">
			<div class="logo-wrapper">
			
			</div>
			<div class="header-items">
				<!-- Custom search start -->
				
				<!-- Custom search end -->

				<!-- Header actions start -->
				{{--  <ul class="header-actions">
				
				
					<li class="dropdown">
						<a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
							<span class="user-name">{{Auth::user()->name}}</span>
							<span class="avatar">UBSI<span class="status busy"></span></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
							<div class="header-profile-actions">
								<div class="header-user-profile">
									<div class="header-user">
										<img src="img/user.png" alt="Admin Template" />
									</div>
									<h5>Zyan Ferris</h5>
									<p>Admin</p>
								</div>
								<a href="user-profile.html"><i class="icon-user1"></i> My Profile</a>
								<a href="account-settings.html"><i class="icon-settings1"></i> Account Settings</a>
								<a href="login.html"><i class="icon-log-out1"></i> Sign Out</a>
							</div>
						</div>
					</li>
				
				</ul>						  --}}
				<!-- Header actions end -->
			</div>
		</header>
		<!-- Header end -->

		<!-- Screen overlay start -->
		<div class="screen-overlay"></div>
		<!-- Screen overlay end -->

		

		<!-- *************
			************ Header section end *************
		************* -->

		<!-- Container fluid start -->
		<div class="container-fluid">

			<!-- Navigation start -->
		 @include('layouts.dosen.ujian.navbar')
			<!-- Navigation end -->

			<!-- *************
				************ Main container start *************
			************* -->
				<!-- Page header start -->
				<div class="page-header">
					<ol class="breadcrumb">
						
					</ol>

					<ul class="app-actions">
						<li>
							<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Kampus">

								<span class="range-text"></span>
								UNIVERSITAS BINA SARANA INFORMATIKA	
							</a>
						</li>
						<li>
							<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hari">
								{{hari_ini()}}
							</a>
						</li>
						<li>
							<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tanggal">
								@php
								$tgl = date ('Y-m-d');	
									
								@endphp
								{{ dateIndonesia($tgl) }}
							</a>
						</li>
					</ul>
				</div>
				<!-- Page header end -->
            <iv class="main-container">
			
		@yield('content')
	
        </div>
			<!-- *************
				************ Main container end *************
			************* -->

			<!-- Footer start -->
			{{--  <footer class="main-footer">© UJIAN ONLINE UBSI</footer>  --}}
			<!-- Footer end -->

		</div>
		<!-- Container fluid end -->

		<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="{{asset('assets/uji/js/jquery.min.js')}}"></script>
		<script src="{{asset('assets/uji/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/uji/js/moment.js')}}"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->
		<!-- Slimscroll JS -->
		<script src="{{asset('assets/uji/vendor/slimscroll/slimscroll.min.js')}}"></script>
		<script src="{{asset('assets/uji/vendor/slimscroll/custom-scrollbar.js')}}"></script>

		<!-- Data Tables -->
		<script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
		
		<!-- Custom Data tables -->
		<script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/custom/fixedHeader.js')}}"></script>

		<!-- Download / CSV / Copy / Print -->
		<script src="{{asset('assets/vendor/datatables/buttons.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/jszip.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/pdfmake.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/vfs_fonts.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/html5.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/buttons.print.min.js')}}"></script>
		<!-- Bootstrap Select JS -->
		<script src="{{asset('assets/vendor/bs-select/bs-select.min.js')}}"></script>
		<!-- Main JS -->
		
		<script src="{{asset('assets/js/bootstrap-toggle.min.js')}}"></script>
		<script src="{{asset('assets/dist/sweetalert2.min.js')}}"></script>
		<script src="{{asset('assets/dist/script.js')}}"></script>

		<!-- Main Js Required -->
		<script src="{{asset('assets/uji/js/main.js')}}"></script>
		@push('scripts')
		<script type="text/javascript">
		$('.tombol-hapus').on('click',function(e){
	  e.preventDefault();
	  const href=$(this).attr('href');
	  Swal.fire({
		title: 'Apakah anda yakin',
		text: "Data akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Hapus Data!'
	  }).then((result) => {
		if (result.value) {
		  document.location.href=href;
		  
		}
	  })
	  });
	  $(document).ready(function () {
		   $('#myTable1').DataTable({
			dom: 'Blfrtip',
						lengthMenu: [
							[ 10, 25, 50, 10000 ],
							[ '10', '25', '50', 'Show All' ]
						],
						buttons: [
							'copy', 'csv', 'excel', 'pdf', 'print'
						],
		  responsive: true
			});
	  
		 });
		  </script>
	  @endpush
	</body>
</html>