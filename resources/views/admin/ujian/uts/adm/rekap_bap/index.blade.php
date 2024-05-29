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
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">
									
									REKAPITULASI BAP </h4>
							</div>
							
                            
							<div class="table-container">
								<form action="/cari/rekap-bap" method="GET">
									<table class="table custom-table">
										<tr>
											<td>KD Dosen</td>
											<td><input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen" class="nilai form-control"></td>
										</tr>
										<tr>
											<td>KEL-UJIAN</td>
											<td><input type="text" name="kel_ujian" placeholder="Masukkan Kelompok Ujian Mahasiswa" class="nilai form-control"></td>
										</tr>
										<tr>
											<td>Kampus</td>
											<td>
												<select class="nilai form-control select2" name="no_ruang">
													<option value="">--Pilih Kampus Semua Kampus--</option>
													@foreach ($kampus as $k)
														<option value="{{ $k->kd_kampus }}">{{ $k->nm_kampus }} - {{ $k->kd_kampus }}</option>
													@endforeach
												</select>
											</td>
										</tr>
										<tr>
											<td>Paket</td>
											<td>
												<select class="nilai form-control" name="paket" required>
													<option value="">--Pilih Paket--</option>
													<option value="UTS">UTS</option>
													<option value="UAS">UAS</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Tanggal Ujian</td>
											<td><input type="date" name="tgl_ujian" class="nilai form-control"></td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: right;">
												<em style="text-align: left;">Catatan: Anda dapat mengisi salah satu atau semua kriteria pencarian yang tersedia.</em>
												<button type="submit" class="btn btn-info">Cari Data BAP</button>
											</td>
										</tr>
									</table>
								</form>
								</div>
							</div>

						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>
@endsection
