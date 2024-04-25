@extends('layouts.dosen.ujian.main')



@section('content')
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
												<td>Waktu Ujian</td>
												<td><b>{{ $soal->mulai }}-{{ $soal->selesai }}</b></td>
											</tr>
											<tr>
												<td>Kampus</td>
												<td>{{ $soal->nm_kampus }}</td>
											</tr>
											<tr>
												<td>Berita Acara</td>
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
										
										@else
											@endif                                                
								

											<!-- Modal Structure -->
											<div class="modal fade" id="beritaAcaraModal" tabindex="-1" role="dialog" aria-labelledby="beritaAcaraModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document" style="max-width: 70%;"> <!-- Inline CSS for wider modal -->
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="beritaAcaraModalLabel">Verifikasi Berita Acara Mengawas</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															@if($beritaAcara)
																{{-- Escaping the content to display as plain text --}}
																<pre>{{ htmlspecialchars($beritaAcara->isi) }}</pre>
																{{-- Display other fields from berita acara as needed --}}
															@else
																<p>No berita acara found.</p>
															@endif
														</div>
														<form action="{{ route('verifikasi.status') }}" method="POST">
															@csrf
															<input type="hidden" name="id" value="{{ $beritaAcara->id }}">
															<div class="modal-footer">
																<select name="verifikasi" class="custom-select ket-dropdown">
																	<option value="">-- Pilih Status --</option>
																	<option value="1">Ujian Lancar</option>
																	<option value="2">Ujian Bermasalah</option>
																	<!-- Add more options as needed -->
																</select>
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
																				
																				<th>Status Hadir</th>
																				<th>Waktu</th>
																			
																			</tr>
																		</thead>
																		<tbody>
																			@forelse ($mhsujian as $item)
																				<tr>
																					<td>{{ $loop->iteration }}</td>
																					<td>{{ $item->nim }}</td>
																					<td>{{ $item->nm_mhs }}</td>
																					<td>

																						
																						<select name="ket" class="custom-select ket-dropdown" data-id="{{ $item->id }}">
																							<option value="">-- Pilih Status --</option>
																							<option value="ujian_bermasalah" {{ $item->ket == 'ujian_bermasalah' ? 'selected' : '' }}>Ujian Bermasalah</option>
																							<option value="nyontek" {{ $item->ket == 'nyontek' ? 'selected' : '' }}>Nyontek</option>
																							<!-- Add more options as needed -->
																						</select>
																					
																					</td> <!-- Assuming each item has an 'id' -->
																					<td>

																					
																					<label class="switch">
																						<input type="checkbox" class="status-checkbox" id="switch{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
																						<span class="slider round"></span>
																					</label>
																																											
																						
																					</td>
																					<td>
																						@if($item->updated_at)
																						
																						<span>
																							{{ $item->updated_at->format('d F Y, H:i') }} <!-- Format: 13 Januari 2024, 15:30 -->
																						</span>
																						
																						<!-- {{ $item->updated_at->format('l, d M Y H:i:s') }} <!-- Format: Sabtu, 13 Jan 2024 15:30:00 -->
																						<!-- {{ $item->updated_at->diffForHumans() }} <!-- Format: 2 jam yang lalu -->
																					@else
																						<span>Belum Pernah Diperbarui</span>
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
																		<center>
																		<a href="" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
																			Log Aktivitas
																		</a>
																	</center>
																		 
																	
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
							{{-- <form action="/store/mengawas-uts/" method="post" enctype="multipart/form-data">
								@csrf
								
								<input type="text" hidden readonly name="kd_mtk" value="{{ $soal->kd_mtk }}">
								<input type="text" hidden readonly name="kel_ujian" value="{{ $soal->kel_ujian }}">
								<input type="text" hidden readonly name="hari" value="{{ $soal->hari_t }}">
								<input type="text" hidden readonly name="paket" value="{{ $soal->paket }}">

								<!-- Text area added here -->
								<div class="form-group">
									<label for="additionalNotes">Berita Acara:</label>
									<textarea class="form-control" id="isi" name="isi" rows="7"></textarea>
								</div>
								<button type="submit" class="btn btn-primary">
									Kirim Data
								</button> 
							</form> --}}
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

			{{-- <script>
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
			</script> --}}
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	{{-- <script>
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
	</script> --}}

					
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

