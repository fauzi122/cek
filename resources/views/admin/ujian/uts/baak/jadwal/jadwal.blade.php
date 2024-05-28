@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">

									Jadwal Ujian</h4>
							</div>

							<div class="table-container">
								<b>*Catatan : Kelas/Kelompok Ujian boleh di kosongkan jika pencarian haya berdasarkan tanggal ataupun sebaliknya </b>
								<br>
								<form action="/baak/cari-jadwal-ujian" method="GET">
									<table class="table custom-table">
										<tr>
											<td>Kelas</td>
											<td><input type="text" name="kd_lokal" placeholder="Masukkan Kelas Mahasiswa" class="nilai form-control"></td>
										</tr>
										<tr>
											<td>Kelompok Ujian</td>
											<td>
												<input type="text" name="kel_ujian" placeholder="Masukkan Kelompok Ujian Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td>Tanggal Ujian</td>
											<td>
												<input type="date" name="tgl_ujian" placeholder="Masukkan Tanggal Ujian Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: right;">
												<button type="submit" class="btn btn-info">Cari Data Jadwal </button><br>
											</td>
										</tr>
									</table>
								</form>
								<br> 
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
								<div class="table-responsive">
									<table id="myTable10" class="table custom-table">
										<thead>
											<tr>
											  
												<th>kd</th>
												<th>NIP</th>
												<th>kd</th>
												<th>nm_MTK</th>
												<th>Kelas</th>
												<th>Kel-Ujian</th>
												<th>Hari</th>
												<th>tgl</th>
												<th>Mulai</th>
												<th>Selsai</th>
												<th>Ruang</th>
												<th>paket</th>
												<th>sks</th>
												<th>kampus</th>
												<th>ket</th>
												<th>status</th>
												<th>Aksi</th>
												<th><span class="icon-edit1"></span></th>
												
											</tr>
										</thead>
										<tbody>
											@foreach ($jadwal as $no => $jadwal)
											<tr>
											
											 <td>
												{{ $jadwal->kd_dosen }}
												
											 </td>
											 <td>{{ $jadwal->nip }}</td>
											 <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->nm_mtk }}</td>
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->hari_t }}</td>
											 <td>{{ $jadwal->tgl_ujian }}</td>
											 <td>{{ $jadwal->mulai }}</td>
											 <td>{{ $jadwal->selesai }}</td>
											
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->sks }}</td>
											 <td>{{ $jadwal->nm_kampus }}</td>
											 <td>
												@if(is_null($jadwal->petugas_edit)|| $jadwal->petugas_edit === '')
												
												@else
												{{ $jadwal->petugas_edit }}
												@endif
												</td>
												<td>
													{{-- Key definition for lookup in resultArray --}}
													@php
													   $key = $jadwal->kd_dosen . '_' . $jadwal->kel_ujian . '_' . $jadwal->kd_mtk. '_' . $jadwal->paket;
												   @endphp
												 
											   @php
												   $verifikasi = $resultArray[$key]->verifikasi ?? 0; // Menetapkan default sebagai 0 jika tidak ditemukan
											   @endphp
   
											   @if($verifikasi == 1)
												   {{-- Jika verifikasi 1, tampilkan emoji ceklis dengan title "Ujian Lancar" --}}
												   <span title="Ujian Lancar" style="font-size: 24px;">✔️ {{ $key  }}</span>
											   @elseif($verifikasi == 2)
												   {{-- Jika verifikasi 2, tampilkan emoji silang dengan title "Ujian Bermasalah" --}}
												   <span title="Ujian Bermasalah" style="font-size: 24px;">❌</span>
											   @endif
											   </td>
												<td>
   
												   @php
													   $id = Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket.','.$jadwal->nm_kampus);
												   @endphp
												   
												  
   
												   {{-- Check if the data already exists in the resultArray --}}
												   @if(array_key_exists($key, $resultArray))
													   <!-- Jika ada data yang cocok di resultArray, aktifkan tombol Show -->
													   <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">Show</a>
												   @else
													   <!-- Jika tidak ada data yang cocok di resultArray, tampilkan tombol Show yang tidak aktif atau pesan -->
													   {{-- <button class="btn btn-xs btn-info" disabled>Show</button> --}}
												   @endif
												   
											   </td>
											<td>

												<a href="/edit/jadwal-ujian/{{ $id }}" class="btn btn-xs btn-primary">Edit</a>
												

											</td>
											
											</tr>
											@endforeach
										</tbody>
						    	</table>
								</div>
							</div>
						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>
			<style>
				.custom-table th, .custom-table td {
					padding: 3px;
					font-size: 12px;
					line-height: 1.2;
				}
				.custom-table thead th {
					background-color: #007bff;
					color: white;
				}
			</style>
<script>
	$(document).ready(function() {
		$('#myTable10').DataTable({
			"scrollX": true,
			"scrollY": "500px",
			"scrollCollapse": true,
			"fixedHeader": true,
			"responsive": false,
			"dom": 'Blfrtip',
			"buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
			"lengthMenu": [10, 25, 50, -1],
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});
	});
</script>
					
@endsection
