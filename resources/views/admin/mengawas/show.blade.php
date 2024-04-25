@extends('layouts.dosen.main')


@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
	<div class="main-container">


				<!-- Page header start -->
				
				<!-- Page header end -->


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
											<tr>
												<td>Kelompok Ujian</td>
												<td>{{ $soal->kel_ujian }}</td>
											</tr>
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
													$isTanggalSesuai = $tanggalSekarang->eq($tanggalUjian);
													$isBeritaAcaraTersedia = $beritaAcara != null;
												@endphp

												@if($isTanggalSesuai && !$isBeritaAcaraTersedia)
													<!-- Jika sudah waktunya ujian dan belum ada berita acara, tampilkan tombol mengawas ujian -->
													<form method="POST" action="{{ route('store-mengawas-ujian') }}">
														@csrf
														<input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
														<input type="hidden" name="kel_ujian" value="{{ $soal->kel_ujian }}">
														<input type="hidden" name="hari" value="{{ $soal->hari_t }}">
														<input type="hidden" name="tgl_ujian" value="{{ $soal->tgl_ujian }}">
														<input type="hidden" name="paket" value="{{ $soal->paket }}">

														<button type="submit" class="btn btn-info">
															Mengawas Ujian
														</button>
													</form>
												@elseif($isBeritaAcaraTersedia)
													<!-- Jika berita acara sudah ada, beri informasi bahwa pengawasan sudah terdaftar -->
													<button class="btn btn-secondary" disabled>
														Anda sudah absen mengawas, {{ formatDate($soal->created_at) }}

													</button>
												@else
													<!-- Jika belum waktunya, tidak menampilkan tombol mengawas -->
													<button class="btn btn-danger" disabled>
														Belum waktunya mengawas ujian
													</button>
												@endif


													@if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
														<!-- Tombol isi berita acara ditampilkan jika $beritaAcara ada dan field tertentu null -->
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
															berita acara
														</button>
													@endif
												

												
											

												</td>
											<button onclick="window.location.reload();" class="btn btn-danger">Refresh Data</button>

											</tr>
										</tbody>
									</table>
								</div>
								<div class="nav-tabs-container">
									<!-- Navigation Tabs -->
									<ul class="nav nav-tabs" id="myTab3" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home3" aria-selected="true">
												<i class="icon-edit1"></i> Rekap Hadir Mahasiswa Ujian
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile3" aria-selected="false">
												<i class="icon-download-cloud"></i> Download Rekap Hadir Mahasiswa
											</a>
										</li>
									</ul>
				
									<!-- Tab Content -->
									<div class="tab-content" id="myTabContent3">
										<!-- Tab Pane 1 -->
										<div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
											<div class="row gutters">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													
														<div class="table-responsive">
															<table class="custom-table">
																		<thead>
																			<tr>
																				<th>No</th>
																				<th>NIM</th>
																				<th>Nama</th>
																				<th>Komentar</th>
																				@if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
																				<th>Status Hadir</th>
																				@endif	
																				<th>Status Mulai Ujian</th>
																			</tr>
																		</thead>
																		<tbody>
																			@forelse ($mhsujian as $item)
																				<tr>
																					<td>{{ $loop->iteration }}</td>
																					<td>{{ $item->nim }}</td>
																					<td>{{ $item->nm_mhs }}</td>
																					<td>

																						{{-- {{ $item->id }} --}}
																						<select name="ket" class="custom-select ket-dropdown" data-id="{{ $item->id }}">
																							<option value="">-- Pilih Status --</option>
																							<option value="ujian_bermasalah" {{ $item->ket == 'ujian_bermasalah' ? 'selected' : '' }}>Ujian Bermasalah</option>
																							<option value="nyontek" {{ $item->ket == 'nyontek' ? 'selected' : '' }}>Nyontek</option>
																							<!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
																						</select>
																						
																						
																						
																					
																					</td> <!-- Assuming each item has an 'id' -->
																					@if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
																					<td>

																						
																					<label class="switch">
																						<input type="checkbox" class="status-checkbox" id="switch{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
																						<span class="slider round"></span>
																					</label>
																																										
																						
																					</td>
																					@endif	
																					<td> 
																						@if($item->isInHasilUjian)
																						<span class="badge badge-info">Sudah Mulai Ujian</span>
																					@else
																						<span class="badge badge-danger">Belum Mulai Ujian</span>
																					@endif
																				</td>
																				</tr>
																			@empty
																				<tr>
																					<td colspan="5">No data available</td>
																				</tr>
																			@endforelse
																		</tbody>
																	</table>
																	
																</tbody>
															</table>
															
														</div>
												
												</div>
											</div>
										</div>
				
										<!-- Tab Pane 2 -->
										<div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
											<div class="table-responsive">
												<table id="copy-print-csv" class="table custom-table">
														<thead>
															<tr>
																<th>No</th>
																<th>NIM</th>
																<th>Nama</th>
																<th>Status</th>
																<th>Aksi</th>
															
															</tr>
														</thead>
														<tbody>
															@forelse ($mhsujian as $item)
																<tr>
																	<td>{{ $loop->iteration }}</td>
																	<td>{{ $item->nim }}</td>
																	<td>{{ $item->nm_mhs }}</td>
																	<td>
																		@if($item->status==1)

																		<b>Hadir</b>
																	@else
																		<b>Tidak Hdir</b>
																	@endif
																	</td>
																	<td>
																		@php
																			$id=Crypt::encryptString($item->nim.','.$item->no_kel_ujn.','.$item->kd_mtk.','.$item->paket);                                    
																			@endphp

																		@if($item->isInHasilUjian)
																		<a href="/show/log-mhs/mengawas-uts/{{ $id }}}" class="btn btn-info" >
																			Log Aktivitas
																		</a>
																		{{-- <span class="badge badge-info">Sudah Mulai Ujian</span> --}}
																	@else
																		<span class="badge badge-danger">Belum Mulai Ujian</span>
																	@endif
																		 
																	
																	</td> <!-- Assuming each item has an 'id' -->
															
																</tr>
															@empty
																<tr>
																	<td colspan="5">No data available</td>
																</tr>
															@endforelse
														</tbody>
													</table>
													
												</tbody>
											</table>
											</div>
										</div>
									</div>
								</div>
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
							<form method="POST" action="{{ route('store-berita-mengaws-ujian') }}">
							{{-- <form action="/store/berita-mengawas-uts/" method="post" enctype="multipart/form-data"> --}}
								@csrf
								<input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
								<input type="hidden" name="kel_ujian" value="{{ $soal->kel_ujian }}">
								<input type="hidden" name="paket" value="{{ $soal->paket }}">
							
								<div class="form-group">
									<label for="isi">Berita Acara:</label>
									<textarea class="form-control" id="isi" name="isi" rows="7">{{ $beritaAcara->isi ?? '' }}</textarea>
								</div>
								<button type="submit" class="btn btn-primary">
									Kirim Data
								</button> 
							</form>
							<hr>
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
	{{-- @include('admin.mengawas.modal_acara') --}}
			
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