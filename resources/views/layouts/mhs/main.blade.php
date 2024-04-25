<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="shortcut icon" href="{{ asset('assets/img/icon1.jfif') }}" />
		<!-- Title -->
		<title>My Best</title>


		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2.css') }}">

		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" href="{{ asset('assets/fonts/style.css') }}">
		
		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
		<!-- Data Tables -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4-custom.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/buttons.bs.css') }}"/>
		


		<!-- *************
			************ Vendor Css Files *************
		************ -->
		<!-- DateRange css -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/daterange/daterange.css') }}" />
<style>
	.dijawab {
		background: #1980d4;
		color: #fff;
		padding: 5px 10px;
		border-radius: 3px;
	}

	.pagination>li>a,
	.pagination>li>span {
		width: 38px;
		text-align: center;
		margin: 3px;
	}

	.timer {
		border: solid thin #b9b2b2;
		padding: 5px 15px;
		font-size: 14pt;
		color: #fff;
		background: #291a71;
	}

	.soal {
		margin: 0 0 15px 0;
	}

	.box-footer {
		border-top: 1px solid #ebebeb !important;
	}

	.jawab {
		cursor: pointer;
		margin: 0 0 7px 0;
	}

	.pilihan p {
		margin: 0;
	}
</style>

	</head>

	<body>

		<!-- Loading starts -->
		{{-- <div id="loading-wrapper">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div> --}}
		<!-- Loading ends -->


		<!-- Page wrapper start -->
		<div class="page-wrapper pinned">
			
			<!-- Sidebar wrapper start -->
			<nav id="sidebar" class="sidebar-wrapper">
				
				<!-- Sidebar brand end  -->

				<!-- Sidebar content start -->
                @include('layouts.mhs.navigasi')
				<!-- Sidebar content end -->
			</nav>
			<!-- Sidebar wrapper end -->

			<!-- Page content start  -->
			<div class="page-content">

				<!-- Header start -->
				@include('layouts.mhs.header')
				<!-- Header end -->

				<!-- Page header start -->
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">Elearning Universitas Bina Sarana Informatika </li>
						 {{--  <h5 class="btn btn-lg btn-info"> <b>*SEGERA LAKUKAN PERUBAHAN PASSWORD DEMI KEAMANAN AKUN ANDA. <a href="/user/profile">KLIK DI SINI</a></b></h5>  --}}
						{{-- <li class="breadcrumb-item active">Account Settings</li> --}}
					</ol>

					<ul class="app-actions">
						<li>
							<a href="#" id="reportrange">
								<span class="range-text"></span>
								<i class="icon-chevron-down"></i>	
							</a>
						</li>
						
					</ul>
				</div>
				<!-- Page header end -->

				<!-- Main container start -->
				<div class="main-container">
				@yield('content')
				</div>
				{{--  <div class="main-container">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
							<div class="card h-100">
								<div class="card-body">
									<div class="account-settings">
										<div class="user-profile">
											<div class="user-avatar">
												<img src="img/user.png" alt="Wafi Admin" />
											</div>
											<h5 class="user-name">Zyan Ferris</h5>
											<h6 class="user-email">zyanferris@wafi.com</h6>
										</div>
										<div class="setting-links">
											<a href="chat.html">
												<i class="icon-chat"></i>
												Messages
											</a>
											<a href="tasks.html">
												<i class="icon-date_range"></i>
												Tasks
											</a>
											<a href="documents.html">
												<i class="icon-file-text"></i>
												Documents
											</a>
											<a href="faq.html">
												<i class="icon-info"></i>
												FAQ's
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
							<div class="card h-100">
								<div class="card-header">
									<div class="card-title">Update Profile</div>
								</div>
								<div class="card-body">
									<div class="row gutters">
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="fullName">Full Name</label>
												<input type="text" class="form-control" id="fullName" placeholder="Enter full name">
											</div>
											<div class="form-group">
												<label for="eMail">Email</label>
												<input type="email" class="form-control" id="eMail" placeholder="Enter email ID">
											</div>
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" placeholder="Enter phone number">
											</div>
											<div class="form-group">
												<label for="website">Website URL</label>
												<input type="url" class="form-control" id="website" placeholder="Website url">
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="addRess">Address</label>
												<input type="text" class="form-control" id="addRess" placeholder="Enter Address">
											</div>
											<div class="form-group">
												<label for="ciTy">City</label>
												<input type="name" class="form-control" id="ciTy" placeholder="Enter City">
											</div>
											<div class="form-group">
												<label for="sTate">State</label>
												<input type="text" class="form-control" id="sTate" placeholder="Enter State">
											</div>
											<div class="form-group">
												<label for="zIp">ZIP</label>
												<input type="number" class="form-control" id="zIp" placeholder="Website ZIP">
											</div>
										</div>
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="text-right">
												<button type="button" id="submit" name="submit" class="btn btn-dark">Cancel</button>
												<button type="button" id="submit" name="submit" class="btn btn-success">Submit Form</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Row end -->

				</div>  --}}
				<!-- Main container end -->

			</div>
			<!-- Page content end -->

		</div>
		<!-- Page wrapper end -->

		<!--**************************
			**************************
				**************************
							Required JavaScript Files
				**************************
			**************************
		**************************-->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="{{asset('/js/jquery-ui.min.js') }}"></script>
		<script src="{{asset('assets/js/jquery.min.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/js/moment.js')}}"></script>
		<script type="text/javascript" src="{{asset('assets/js/jquery.expander.js')}}"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->
		<!-- Slimscroll JS -->
		<script src="{{asset('assets/vendor/slimscroll/slimscroll.min.js')}}"></script>
		<script src="{{asset('assets/vendor/slimscroll/custom-scrollbar.js')}}"></script>
		<!-- Daterange -->
		<script src="{{asset('assets/vendor/daterange/daterange.js')}}"></script>
		<script src="{{asset('assets/vendor/daterange/custom-daterange.js')}}"></script>
		<!-- Custom Data tables -->
		<script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/custom/fixedHeader.js')}}"></script>
		<!-- Data Tables -->
		<script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
		<!-- Download / CSV / Copy / Print -->
		<script src="{{asset('assets/vendor/datatables/buttons.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/jszip.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/pdfmake.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/vfs_fonts.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/html5.min.js')}}"></script>
		<script src="{{asset('assets/vendor/datatables/buttons.print.min.js')}}"></script>
		<!-- Main JS -->
		<script src="{{asset('assets/js/main.js')}}"></script>
		<script src="{{asset('assets/dist/sweetalert2.min.js')}}"></script>
		<script src="{{asset('assets/dist/script.js')}}"></script>
		<!-- Lobipanel -->
		@stack('scripts')
	</body>
</html>