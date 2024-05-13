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
									
									Hasil Pencarian BAP </h4>
							</div>

							<div class="table-container">
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
                                                <th>no</th>
                                                <th>dosen</th>
                                                <th>mtk</th>
                                                <th>kel-ujian</th>
                                                <th>ruang</th>
                                                <th>paket</th>
                                                <th>hari</th>
                                                <th>tgl_ujian</th>
                                                <th>isi bap</th>
                                                <th>sts</th>
                                                <th>ot</th>
                                                <th>kampus</th>

                                               
											</tr>
										</thead>
										<tbody>
											 @foreach ($peserta as $no => $jadwal)
											<tr>
											
										
											 <td>{{$loop->iteration}}</td>
											 <td>{{ $jadwal->kd_dosen }}</td>
                                             <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->hari }}</td>
											 <td>{{ $jadwal->tgl_ujian }}</td>
											 <td>{{ $jadwal->isi }}</td>
											 <td>
                                            </button>
											@if ($jadwal->verifikasi == 1)
											<span class='badge badge-pill badge-light'><h6>Ujian Lancar</h6></span>
										@elseif ($jadwal->verifikasi == 2)
											<span class='badge badge-pill badge-secondary'><h6>Ujian Bermasalah</h6></span>
										@else
                                        @endif
                                            </td>
											 <td>{{ $jadwal->ot }}</td>
											 <td>{{ $jadwal->nm_kampus }}</td>
											
											

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
