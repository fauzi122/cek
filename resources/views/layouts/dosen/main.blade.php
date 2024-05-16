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
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css">

		<link rel="stylesheet" href="{{ asset('assets/plugin/bootstrap.min.css') }}">

		<!-- Bootstrap css -->
		
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-toggle.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2.css') }}">

		<link rel="stylesheet" href="{{ asset('assets/summernote/summernote-bs4.min.css') }}">

		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" href="{{ asset('assets/fonts/style.css') }}">
		
		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
		<!-- Bootstrap Select CSS -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/bs-select/bs-select.css') }}">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

		<!-- *************
			************ Vendor Css Files *************
		************ -->
		<!-- DateRange css -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/daterange/daterange.css') }}" />
		<!-- Datepicker css -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/classic.css')}}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/classic.date.css')}}" />
		<!-- Data Tables -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4-custom.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/buttons.bs.css') }}"/>

	</head>

	<body>

		<!-- Loading starts -->
		{{--  <div id="loading-wrapper">
			<div class="spinner-growing" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>  --}}
		<!-- Loading ends -->


		<!-- Page wrapper start -->
		<div class="page-wrapper pinned">
			
			<!-- Sidebar wrapper start -->
			<nav id="sidebar" class="sidebar-wrapper">
				
				<!-- Sidebar brand end  -->

				<!-- Sidebar content start -->
                @include('layouts.dosen.navigasi')
				<!-- Sidebar content end -->
			</nav>
			<!-- Sidebar wrapper end -->

			<!-- Page content start  -->
			<div class="page-content">

				<!-- Header start -->
				@include('layouts.dosen.header')
				<!-- Header end -->

				<!-- Page header start -->
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">Universitas Bina Sarana Informatika</li>
						{{-- <li class="breadcrumb-item active">Account Settings</li> --}}
					</ol>

					{{-- <ul class="app-actions">
						<li>
							<a href="#" id="reportrange">
								<span class="range-text"></span>
								<i class="icon-chevron-down"></i>	
							</a>
						</li>
						<li>
							<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print">
								<i class="icon-print"></i>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download CSV">
								<i class="icon-cloud_download"></i>
							</a>
						</li>
					</ul> --}}
				</div>
				<!-- Page header end -->

				<!-- Main container start -->
				<div class="main-container">
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
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
		<script src="{{asset('assets/js/jquery.min.js')}}"></script>
		<script src="{{asset('assets/js/typeahead.min.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/js/moment.js')}}"></script>
		<script type="text/javascript" src="{{asset('assets/js/jquery.expander.js')}}"></script>
		{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-expander/1.7.0/jquery.expander.js"></script> --}}

		<!-- *************
			************ Vendor Js Files *************
		************* -->
		<!-- Slimscroll JS -->
		<script src="{{asset('assets/vendor/slimscroll/slimscroll.min.js')}}"></script>
		<script src="{{asset('assets/vendor/slimscroll/custom-scrollbar.js')}}"></script>

		<!-- Daterange -->
		<script src="{{asset('assets/vendor/daterange/daterange.js')}}"></script>
		<script src="{{asset('assets/vendor/daterange/custom-daterange.js')}}"></script>
		<!-- Datepickers -->
		<script src="{{asset('assets/vendor/datepicker/js/picker.js')}}"></script>
		<script src="{{asset('assets/vendor/datepicker/js/picker.date.js')}}"></script>
		<script src="{{asset('assets/vendor/datepicker/js/custom-picker.js')}}"></script>
		<!-- Input Masks JS -->
		<script src="{{asset('assets/vendor/input-masks/cleave.min.js')}}"></script>
		<script src="{{asset('assets/vendor/input-masks/cleave-phone.js')}}"></script>
		<script src="{{asset('assets/vendor/input-masks/cleave-custom.js')}}"></script>

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
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<!-- Main JS -->
		<script src="{{asset('assets/js/main.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap-toggle.min.js')}}"></script>
		<script src="{{asset('assets/dist/sweetalert2.min.js')}}"></script>
		<script src="{{asset('assets/dist/script.js')}}"></script>

		<script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
		<script>
			// Menunggu dokumen selesai dimuat
			document.addEventListener('DOMContentLoaded', function() {
				// Fungsi untuk 'Pilih Semua' ceklis soal
				var selectAllSoal = document.getElementById('selectAll');
				if (selectAllSoal) {
					selectAllSoal.addEventListener('click', function() {
						var checkboxes = document.querySelectorAll('input[type="checkbox"][name="deleteIds[]"]');
						checkboxes.forEach(function(checkbox) {
							checkbox.checked = this.checked;
						}, this);
					});
				}
		  
				// Fungsi untuk 'Pilih Semua' ceklis esai
				var selectAllEssay = document.getElementById('selectAll1');
				if (selectAllEssay) {
					selectAllEssay.addEventListener('click', function() {
						var checkboxes = document.querySelectorAll('input[type="checkbox"][name="essayIds[]"]');
						checkboxes.forEach(function(checkbox) {
							checkbox.checked = this.checked;
						}, this);
					});
				}
		  
				// Fungsi untuk konfirmasi penghapusan pada submit form
				document.querySelector('form').addEventListener('submit', function(event) {
					var checkboxesSoal = document.querySelectorAll('input[type="checkbox"][name="deleteIds[]"]:checked');
					var checkboxesEssay = document.querySelectorAll('input[type="checkbox"][name="essayIds[]"]:checked');
					if (checkboxesSoal.length === 0 && checkboxesEssay.length === 0) {
						alert('Silakan pilih minimal satu soal atau esai untuk dihapus.');
						event.preventDefault();
						return;
					}
		  
					if (!confirm('Apakah Anda yakin ingin menghapus item terpilih?')) {
						event.preventDefault();
					}
				});
			});
		  </script>
		  
		  <script>
		  $(document).ready(function () {
			   $('#myTable5').DataTable({
				dom: 'Blfrtip',
							lengthMenu: [
								[ 50, 10000 ],
								[ '50', 'Show All' ]
							],
							buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
							],
			  responsive: true
				});
		  
			 });
			 $(function() { 
					$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				  });
					 $('.toggle-class').change(function() { 
					 var status = $(this).prop('checked') == true ? 1 : 0;
					 var id_soal = $(this).data('id');  
					 var nm_kelas = $(this).data('nama');  
					 $.ajax({ 
			  
						 type: "POST", 
						 dataType: "json", 
						 url: '/terbit-soal', 
						 data: {'status': status, 'id_soal': id_soal, 'nm_kelas': nm_kelas}, 
						 success: function(data){ 
						 console.log(data.success) 
					  } 
				   }); 
				}) 
			 }); 
		  </script>
		<script>
			$(function() {
			  $('#summernote').summernote({
				  toolbar: [
					  ['style', ['bold', 'italic', 'underline', 'clear']],
					  ['font', ['strikethrough', 'superscript', 'subscript']],
					  ['fontsize', ['fontsize']],
					  ['color', ['color']],
					  ['para', ['ul', 'ol', 'paragraph']],
					  ['height', ['height']],
					  // Hapus baris di bawah ini jika Anda ingin menonaktifkan fungsi insertLink
				  ],
				  callbacks: {
					  onKeyup: function(e) {
						  var t = $(this).summernote('code').replace(/(<([^>]+)>)/ig, "").length;  // Mengambil teks tanpa HTML tags
						  $('#charCount').text(t + "/4000 karakter");
		  
						  if (t > 4000) {
							  $('#charCount').css('color', 'red');
							  // Memotong isi summernote jika lebih dari 2500 karakter
							  var trimmedContent = $(this).summernote('code').substring(0, 2500);
							  $(this).summernote('code', trimmedContent);
						  } else {
							  $('#charCount').css('color', 'black');
						  }
					  }
				  }
			  });
		  
			  CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
				  mode: "htmlmixed",
				  theme: "monokai"
			  });
		  });
		  
		  
		  </script>

		  <script>
		  
		  $(function() {
			$('#summernote2').summernote({
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					// Tambahkan lebih banyak item toolbar jika diperlukan
				],
				placeholder: 'Masukkan Konten',
				height: 60, // Tinggi editor dalam pixel
				callbacks: {
					onKeyup: function(e) {
						var t = $(this).summernote('code').replace(/(<([^>]+)>)/ig, "").length;
						$('#charCount').text(t + "/40000 karakter");
		
						if (t > 40000) {
							$('#charCount').css('color', 'red');
							var trimmedContent = $(this).summernote('code').substring(0, 2500);
							$(this).summernote('code', trimmedContent);
						} else {
							$('#charCount').css('color', 'black');
						}
					}
				}
			});
		});
		
		  
		  </script>
			  <script>
		  
				$(function() {
				  $('#summernote3').summernote({
					  toolbar: [
						  ['style', ['bold', 'italic', 'underline', 'clear']],
						  ['font', ['strikethrough', 'superscript', 'subscript']],
						  ['fontsize', ['fontsize']],
						  ['color', ['color']],
						  ['para', ['ul', 'ol', 'paragraph']],
						  ['height', ['height']],
						  // Tambahkan lebih banyak item toolbar jika diperlukan
					  ],
					  placeholder: 'Masukkan Konten',
					  height: 60, // Tinggi editor dalam pixel
					  callbacks: {
						  onKeyup: function(e) {
							  var t = $(this).summernote('code').replace(/(<([^>]+)>)/ig, "").length;
							  $('#charCount').text(t + "/40000 karakter");
			  
							  if (t > 40000) {
								  $('#charCount').css('color', 'red');
								  var trimmedContent = $(this).summernote('code').substring(0, 2500);
								  $(this).summernote('code', trimmedContent);
							  } else {
								  $('#charCount').css('color', 'black');
							  }
						  }
					  }
				  });
			  });
			  
				
				</script>
		  
		  <style>
			/* Stilisasi area toolbar Summernote */
			.note-toolbar {
				background-color: #d6c5c5; /* Warna latar untuk toolbar */
				border-bottom: 2px solid #f0e4e4; /* Garis pemisah */
			}
		
			/* Stilisasi area penulisan konten */
			.note-editable {
				background-color: #ffffff; /* Warna latar untuk area penulisan */
				padding: 15px; /* Padding untuk area teks */
				border: 1px solid #ddd; /* Batas area teks */
			}
		</style>

		@stack('scripts')
		

	</body>
</html>