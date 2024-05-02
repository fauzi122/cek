@extends('layouts.dosen.main')

@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
	<div class="main-container">
				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="table-container">
								<div class="t-header">
                                   
									Berita Acara Mengawas
                             
                                </div>
								<br>
								<div class="table-responsive">
									<table class="custom-table">

										<tbody>
											<tr>
												<td>Nama Dosen</td>
												<td>{{ Auth::user()->name }} <b>({{ $soal->kd_dosen }}) </b></td>
											</tr>
											{{-- @if(!empty($soal->kd_gabung))
											<tr>
												<td>Kelompok Ujian</td>
												<td><b> Kode Gabung :{{ $soal->kd_gabung }} </b>
													<br>
													<br>
													@foreach($kelUjianArray1 as $kelas)
													{{ trim($kelas) }}
												@endforeach
												</td>
											</tr>
											@else --}}
											<tr>
												<td>Kelompok Ujian</td>
												<td>{{ $soal->kel_ujian }}</td>
											</tr>
											{{-- @endif --}}
											<tr>
												<td>Matakuliah</td>
												<td><b>{{ $soal->kd_mtk }}</b> {{ $soal->nm_mtk }}</td>
											</tr>

											<tr>
												<td>Jam Ujian</td>
												<td><b>{{ $soal->mulai }}-{{ $soal->selesai }}</b></td>
											</tr>
											<tr>
												<td>Tanggal</td>
												<td>{{ $soal->hari_t }} - {{ $soal->tgl_ujian }}</td>
											</tr>
											<tr>
												<td>Kampus & Ruangan</td>
												<td>{{ $soal->nm_kampus }} - {{ $soal->no_ruang }}</td>
											</tr>

											<tr>
												<td>Berita Acara</td>
												<td>
													@php
														$tanggalSekarang = \Carbon\Carbon::now()->startOfDay();
														$tanggalUjian = \Carbon\Carbon::createFromFormat('Y-m-d', $soal->tgl_ujian)->startOfDay();
														// Periksa apakah tanggal saat ini sama dengan atau setelah tanggal ujian
														$isTanggalSesuai = $tanggalSekarang->gte($tanggalUjian);
														$isBeritaAcaraTersedia = $beritaAcara != null;
													@endphp
													{{-- {{ $isTanggalSesuai }} --}}
													@if($isTanggalSesuai && !$isBeritaAcaraTersedia)
														<!-- Jika sudah waktunya atau lewat waktu ujian dan belum ada berita acara, tampilkan tombol mengawas ujian -->
														{{-- @if(!empty($soal->kd_gabung))
															<!-- Gabung -->
															<form method="POST" action="{{ route('store-mengawas-ujian-gabung') }}">
																@csrf
																<input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
																@foreach($kelUjianArray1 as $kelas)
																	<input type="hidden" name="kel_ujian[]" value="{{ trim($kelas) }}">
																@endforeach
																<input type="hidden" name="hari" value="{{ $soal->hari_t }}">
																<input type="hidden" name="tgl_ujian" value="{{ $soal->tgl_ujian }}">
																<input type="hidden" name="paket" value="{{ $soal->paket }}">
																<input type="hidden" name="kd_gabung" value="{{ $soal->kd_gabung }}">
																<button type="submit" class="btn btn-info">Mengawas Ujian</button>
															</form>
														@else --}}
															<!-- Reguler -->
															<form method="POST" action="{{ route('store-mengawas-ujian') }}">
																@csrf
																<input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
																<input type="hidden" name="kel_ujian" value="{{ $soal->kel_ujian }}">
																<input type="hidden" name="hari" value="{{ $soal->hari_t }}">
																<input type="hidden" name="tgl_ujian" value="{{ $soal->tgl_ujian }}">
																<input type="hidden" name="paket" value="{{ $soal->paket }}">
																<button type="submit" class="btn btn-info">Mengawas Ujian</button>
															</form>
														{{-- @endif --}}
													@else
														<!-- Jika berita acara sudah ada atau belum waktunya, tampilkan informasi sesuai -->
														@if($isBeritaAcaraTersedia)
															<button class="btn btn-secondary" disabled>
																Anda sudah absen mengawas, {{ formatDate($soal->created_at) }}
															</button>
														@else
															<button class="btn btn-danger" disabled>
																Belum waktunya mengawas ujian
															</button>
														@endif
													@endif
													

								@if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
									<!-- Tombol isi berita acara ditampilkan jika $beritaAcara ada dan field tertentu null -->
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
										Berita Acara
									</button>
								@endif

												</td>
											<button onclick="window.location.reload();" class="btn btn-danger">Refresh Data</button>

											</tr>
											<tr>
												<td colspan="2"> <div class="container mt-3">
													<div style="padding: 10px; background: linear-gradient(to right, #6a11cb, #2575fc); color: white; text-align: center;">
														<h4>*Catatan: Klik 'Mengawas Ujian' untuk memulai sesi pengawasan.</h4>
													</div>
													
														
												</div></td>
											</tr>
										</tbody>
									</table>
								</div>

								@include('admin.mengawas.table_absen')

								</div>
							</div>
						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>

	@include('admin.mengawas.modal_acara')
			
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
		$('.custom-select.ket-dropdown').change(function() {
			var itemId = $(this).data('id');
			var selectedValue = $(this).val();

			$.ajax({
				url: '{{ route("update.ket-ujian-uts") }}',
				type: 'POST',
				data: {
					id: itemId,
					ket: selectedValue,
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					console.log('Update berhasil');
				},
				error: function(xhr, status, error) {
					console.error('Error pada update:', xhr.responseText);
				}
			});
		});
	});
	

	</script>
	<script>
		$(document).ready(function () {
			$('.status-checkbox').on('change', function () {
				const id = $(this).data('id');
				const status = $(this).is(':checked') ? 1 : 0;

				$.ajax({
					method: 'POST',
					url: '{{ route("update_attendance") }}',
					data: {
						id: id, 
						status: status, 
						_token: '{{ csrf_token() }}'
					},
					success: function (response) {
						console.log('Status updated successfully:', response.message);
					},
					error: function (xhr, status, error) {
						console.error('Error updating status:', error);
					}
				});
			});
		});

		
	</script>

					
@endsection
<style>
    /* Toggle Switch CSS */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    /* Custom Select CSS */
    .custom-select {
        font-family: Arial, sans-serif;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        outline: none;
        display: inline-block;
        width: auto; /* Sesuaikan lebar sesuai dengan kebutuhan */
        cursor: pointer;
        font-size: 1.1em; /* Ukuran font diperbesar */
    }

    .custom-select:focus {
        border-color: #5b9bd5;
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
    }

    .custom-select option {
        padding: 12px;
        border-bottom: 1px solid #ddd; /* Menambah garis pemisah antar pilihan */
    }

    /* Custom Table CSS */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 1em; /* Ukuran font diperbesar */
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .custom-table thead tr {
        background-color: #009879;
        color: white;
        text-align: left;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px 15px;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .custom-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .custom-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .custom-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }
</style>