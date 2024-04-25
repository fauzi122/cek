@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">
									@can('mtk_ujian.edit')
									<a href="/create-mtk-uji">
										<b><i class="icon icon-plus"></i></b>
									</a>
									@endcan
									List Matakuliah Ujian</h4>
									
							</div>
							<div class="table-container">
								
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>Kode</th>
											  
											  <th>Matakuliah</th>
											  <th>SKS</th>
											  <th>Jenis</th>
											  <th><center>Jml Pg</center></th>
											  <th><center>Jml Essay</center></th>
											  <th>Paket</th>
											  <th>Petugas</th>
											  <th>Updated_at</th>
											  
											  <th> 
                                                <center>
                                                Aksi
                                              </center>
                                            </th>
											</tr>
										</thead>
										<tbody>
											@foreach ($mtk_ujian as $no => $mtk)
											<tr>
											
											
											
											 <td>{{ $mtk->kd_mtk }}</td>
											 <td>{{ $mtk->nm_mtk }}</td>
											 <td>{{ $mtk->sks }}</td>
											 <td>{{ $mtk->jenis_mtk }}</td>
											 <td>
                                                <h5><center>{{ $mtk->jml_soal }}</center></h5>
                                              <td>  <h5><center>{{ $mtk->jml_essay }}</center></h5></td>

                                                </td>
											 <td>{{ $mtk->paket }}</td>
											 <td>{{ $mtk->kode }}</td>
											 <td>{{ $mtk->updated_at }}</td>
											
											 <td>
												@can('mtk_ujian.edit')
                                                <center>
												<a href="" class="btn btn-xs btn-info">Edit</a>
												{{--  <a href="" class="btn btn-xs btn-secondary">Hapus</a>  --}}
                                                </center>
												@endcan
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
