<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta -->
	<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
	<meta name="author" content="ParkerThemes">
	<link rel="shortcut icon" href="img/fav.png" />

	<!-- Title -->
	<title>Ujian Online UBSI</title>
	<!-- Bootstrap and main CSS -->
	<link rel="stylesheet" href="{{ asset('assets/uji/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/uji/fonts/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/uji/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/summernote/summernote-bs4.min.css') }}">

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4-custom.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/buttons.bs.css') }}">

	<!-- Other Vendor CSS -->
	<link rel="stylesheet" href="{{ asset('assets/uji/vendor/daterange/daterange.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/uji/vendor/jqcloud/jqcloud.css') }}">

	<!-- jQuery library must be loaded first -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
			{{-- <ul class="header-actions">
				
				
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

			</ul> --}}
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
					<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nama User">
						{{Auth::user()->name}}
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
			<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
			<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
			@yield('content')

	</div>
	<!-- *************
				************ Main container end *************
			************* -->

	<!-- Footer start -->
	{{-- <footer class="main-footer">© UJIAN ONLINE UBSI</footer>  --}}
	<!-- Footer end -->

	</div>
	<!-- Container fluid end -->

	<!-- Required JavaScript Libraries -->
	<script src="{{ asset('assets/uji/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/uji/js/moment.js') }}"></script>

	<!-- Vendor JS -->
	<script src="{{ asset('assets/uji/vendor/slimscroll/slimscroll.min.js') }}"></script>
	<script src="{{ asset('assets/uji/vendor/slimscroll/custom-scrollbar.js') }}"></script>

	<!-- DataTables JS -->
	<script src="{{ asset('assets/vendor/datatables/dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/custom/custom-datatables.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/custom/fixedHeader.js') }}"></script>

	<!-- Download / CSV / Copy / Print -->
	<script src="{{ asset('assets/vendor/datatables/buttons.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/jszip.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/pdfmake.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/vfs_fonts.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/html5.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datatables/buttons.print.min.js') }}"></script>

	<!-- Bootstrap Select and other JS Plugins -->
	<script src="{{ asset('assets/vendor/bs-select/bs-select.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-toggle.min.js') }}"></script>
	<script src="{{ asset('assets/dist/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('assets/dist/script.js') }}"></script>

	<!-- Summernote JS -->
	<script src="{{ asset('assets/summernote/summernote-bs4.min.js') }}"></script>

	<!-- Main JS -->
	@stack('scripts')
	<script src="{{ asset('assets/uji/js/main.js') }}"></script>
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
						var t = $(this).summernote('code').replace(/(<([^>]+)>)/ig, "").length; // Mengambil teks tanpa HTML tags
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
			background-color: #d6c5c5;
			/* Warna latar untuk toolbar */
			border-bottom: 2px solid #f0e4e4;
			/* Garis pemisah */
		}

		/* Stilisasi area penulisan konten */
		.note-editable {
			background-color: #ffffff;
			/* Warna latar untuk area penulisan */
			padding: 15px;
			/* Padding untuk area teks */
			border: 1px solid #ddd;
			/* Batas area teks */
		}
	</style>
	@push('scripts')
	<script type="text/javascript">
		$('.tombol-hapus').on('click', function(e) {
			e.preventDefault();
			const href = $(this).attr('href');
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
					document.location.href = href;

				}
			})
		});
		$(document).ready(function() {
			$('#myTable2').DataTable({
				dom: 'Blfrtip',
				lengthMenu: [
					[10, 25, 50, -1],
					['10', '25', '50', 'Show All']
				],
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				],
				responsive: true
			});

		});
	</script>


	<script>
		$(document).ready(function() {
			$('#myTable2').DataTable({
				dom: 'Blfrtip',
				lengthMenu: [
					[10, 25, 50, 10000],
					['10', '25', '50', 'Show All']
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
					data: {
						'status': status,
						'id_soal': id_soal,
						'nm_kelas': nm_kelas
					},
					success: function(data) {
						console.log(data.success)
					}
				});
			})
		});
	</script>
	@endpush
</body>

</html>