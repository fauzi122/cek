@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">

									Di bawah ini adalah data log ujian yang dikategorikan berdasarkan mata kuliah</h4>
									
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
											  <th>Paket</th>
											  
											  
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
											 <td>{{ $mtk->paket }}</td>
											
											
											 <td>
												@php
													$detail=Crypt::encryptString($mtk->kd_mtk.','.$mtk->paket);                                    
													@endphp
												{{-- @can('log_ujian.edit') --}}
                                                <center>
												<a href="{{ url('/show-mtk-uji-log')}}/{{ $detail }}" class="btn btn-xs btn-info">Lihat Data</a>
												{{--  <a href="" class="btn btn-xs btn-secondary">Hapus</a>  --}}
                                                </center>
												{{-- @endcan --}}
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
