@extends('layouts.dosen.ujian.main')



@section('content')
	<div class="main-container">

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
												<td>Dosen</td>
												<td>{{ $soal->nip }} <b>({{ $soal->kd_dosen }}) </b></td>
											</tr>
											<tr>
												<td>Kelompok Ujian</td>
												<td>{{ $soal->kel_ujian }}</td>
											</tr>
											<tr>
												<td>Matakuliah</td>
												<td><b>{{ $soal->kd_mtk }}</b> {{ $soal->nm_mtk }}</td>
											</tr>

											<tr>
												<td>Waktu Ujian</td>
												<td><b>{{ $soal->mulai }}-{{ $soal->selesai }}</b></td>
											</tr>
											<tr>
												<td>Kampus</td>
												<td>{{ $soal->nm_kampus }}</td>
											</tr>
											<tr>
												<td>Berita Acara 

													
												</td>
												<td>

												
												<!-- Modal Trigger Button -->
											<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#beritaAcaraModal">
												<i class="icon-edit1"></i> Verifikasi Berita Acara Mengawas
											</button>
											@if($beritaAcara->verifikasi<>0)
											<button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
												<i class="icon-check2"></i> OK || <b>{{ ($beritaAcara->petugas) }}</b> ||
												<b>{{ \Carbon\Carbon::parse($beritaAcara->waktu_verifikasi)->format('d F Y, H:i') }}
												</b>
											</button>
											@if ($beritaAcara->verifikasi == 1)
											<span class='badge badge-pill badge-light'><h5>Ujian Lancar</h5></span>
										@elseif ($beritaAcara->verifikasi == 2)
											<span class='badge badge-pill badge-secondary'><h5>Ujian Bermasalah</h5></span>
										@else
											{{-- Tambahan kondisi lain atau pesan default jika diperlukan --}}
										@endif

										@if ($beritaAcara->ot == 1)
											<span class='badge badge-pill badge-light'><h5>Staff Overtime</h5></span>
									
										@else
											{{-- Tambahan kondisi lain atau pesan default jika diperlukan --}}
										@endif
										
										@else
											@endif                                                
								
											@if(is_null($beritaAcara->isi) || $beritaAcara->isi === '')
											<pre><h4>Dosen belum isi berita acara</h4></pre>
											@if (session('success'))
					<div class="alert alert-info">
						{{ session('success') }}
					</div>
					@endif
	
					@if (session('error'))
					<div class="alert alert-info">
						{{ session('error') }}
					</div>
					@endif
										@endif
											<!-- Modal Structure -->
											<div class="modal fade" id="beritaAcaraModal" tabindex="-1" role="dialog" aria-labelledby="beritaAcaraModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="beritaAcaraModalLabel">Verifikasi Berita Acara Mengawas</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<form action="{{ route('verifikasi.status') }}" method="POST">
															@csrf
															<input type="hidden" name="id" value="{{ $beritaAcara->id }}">
															<div class="modal-body">
																@if($beritaAcara)
																	<pre>{{ htmlspecialchars($beritaAcara->isi) }}</pre>
																@endif
																<br>
																<p></p>
																<hr>
																
																<div class="form-group">
																	<label for="verifikasi">Status Ujian</label>
																	<select name="verifikasi" id="verifikasi" class="form-control">
																		<option value="">-- Pilih Status --</option>
																		<option value="1" {{ $beritaAcara->verifikasi == 1 ? 'selected' : '' }}>Ujian Lancar</option>
																		<option value="2" {{ $beritaAcara->verifikasi == 2 ? 'selected' : '' }}>Ujian Bermasalah</option>
																	</select>
																</div>
																
																<div class="form-group">
																	<div class="form-group">
																		<label for="ot">Overtime (Jika Pengawasnya Staff Dan Overtime) </label>
																		<select name="ot" id="ot" class="form-control">
																			<option value="0">-- Pilih Status --</option>
																			<option value="1" {{ $beritaAcara->ot == 1 ? 'selected' : '' }}>YA</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="submit" class="btn btn-info">Simpan</button>
															</div>
														</form>
													</div>
												</div>
											</div>

												</td>
											</tr>

										</tbody>
									</table>
								</div>
								@include('admin.ujian.uts.baak.jadwal.table_absen')
								</div>
							</div>

						


						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->

			</div>

			<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document"> <!-- Large modal -->
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="basicModalLabel">Form Berita Acara Ujian</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							
							{{-- <label>
								<h5>*Catatan :</h5> 
								<br>
								<h6> 
									1. Upload soal harus sesuai format excel yang tersedia.  
									<br>
									<br>
								</h6> 
							</label> --}}
						</div>
					</div>
				</div>
			</div>

			<script>
				$(document).ready(function() {
					$('.ket-dropdown').change(function() {
						var selectedValue = $(this).val();
						var itemId = $(this).data('id');
			
						$.ajax({
							url: '{{ route("update.ket-ujian-uts") }}',
							type: 'POST',
							data: {
								ket: selectedValue,
								id: itemId,
								_token: '{{ csrf_token() }}'
							},
							success: function(response) {
								console.log('Update berhasil');
							},
							error: function() {
							
								console.error('Error pada update');
							}
						});
					});
				});
			</script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

