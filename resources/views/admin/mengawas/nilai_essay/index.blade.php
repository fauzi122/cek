@extends('layouts.dosen.main')


@section('content')
<div class="main-container">
	<!-- Row start -->
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="table-container">

				<div class="card-header badge-danger">

					<h4 class="m-b-0 text-white">REKAP NILAI ESSAY ONLINE {{ Auth::user()->kode }}</h4>
				</div>
				<div class="table-responsive">
					<table id="copy-print-csv" class="table custom-table">
						<thead>
							<tr>


								<th>NM MTK</th>

								<th>Kel-Ujian</th>

								<th>Hari</th>
								<th>tgl</th>
								<th>Waktu</th>
								<th>Ruang</th>
								<th>paket</th>

								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($essay as $jadwal)
							<tr>
								<td>{{ $jadwal->nm_mtk }} ({{ $jadwal->kd_mtk }})</td>
								<td>{{ $jadwal->kel_ujian }}</td>

								<td>{{ $jadwal->hari_t }}</td>
								<td>{{ $jadwal->tgl_ujian }}</td>
								<td>{{ $jadwal->mulai }}-{{ $jadwal->selesai }}</td>
								<td>{{ $jadwal->no_ruang }}</td>
								<td>{{ $jadwal->paket }}</td>
								<td>

									@php
									$id = Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket.','.$jadwal->tgl_ujian);
									@endphp
									<a href="/show/nilai-essay/{{ $id }}" class="btn btn-sm btn-danger">Nilai Essay Online </a>
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