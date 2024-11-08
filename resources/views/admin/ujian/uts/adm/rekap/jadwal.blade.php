@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
		<div class="row gutte">
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="table-container">
								<div class="t-header">Jadwal Ujian</div>
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>NIP</th>
											  <th>kd</th>
											  <th>NM MTK</th>
											  <th>Kode MTK</th>
											  <th>Kelas</th>
											  <th>Kel-Ujian</th>
											  <th>Hari</th>
											  <th>tgl ujian</th>
											  <th>tgl ujian akhir</th>
											  <th>Mulai</th>
											  <th>Selsai</th>
											 
											  <th>Ruang</th>
											  <th>paket</th>
											  <th>jml PG</th>
											  <th>jml ESSAY</th>
											  <th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($jadwal as $no => $jadwal)
											<tr>
											
											 <td>
												{{ $jadwal->nip }}
												
											 </td>
											 <td>{{ $jadwal->kd_dosen }}</td>
											 <td>{{ $jadwal->nm_mtk }}</td>
											 <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->hari_t }}</td>
											 <td>{{ $jadwal->hari_t }}</td>
											 <td>{{ $jadwal->tgl_ujian }}</td>
											 <td>{{ $jadwal->tgl_ujian_akhir }}</td>
											 <td>{{ $jadwal->mulai }}</td>
											 <td>{{ $jadwal->selesai }}</td>
											
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->jml_soal }}</td>
											 <td>{{ $jadwal->jml_soal_essay }}</td>
											 <td>
						@php
						$id=Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket);                                    
						@endphp

												{{-- <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">show</a> --}}
												@php
													$key = $jadwal->kd_dosen . '_' . $jadwal->kel_ujian . '_' . $jadwal->kd_mtk;
												@endphp

												@if(array_key_exists($key, $resultArray))
													<!-- Jika ada data yang cocok di resultArray, aktifkan tombol Show -->
													<a href="" class=""><span class="icon icon-check" title="berita acara sudah terisi"></span></a>
												@else
													<!-- Jika tidak, nonaktifkan tombol Show -->
													{{-- <button class="btn btn-xs btn-secondery" disabled><span class="icon icon-close" title="berita acara sudah terisi"></span></button> --}}
												@endif	 
											
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
@endsection
