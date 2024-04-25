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
							
							 <div class="card-header badge-secondary">
							
                                <h4 class="m-b-0 text-white">Setting Waktu Ujian </h4>
                            </div>
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
							<div class="table-container">
									
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>No</th>
											  <th>Tanggal Mulai</th>
											  <th>Tanggal Selesai</th>
											  <th>Paket Ujian</th>
											  <th> <center>Kondisi </center></th>
											  <th>Petugas</th>
											  <th>Aksi</th>
											
											</tr>
										</thead>
										<tbody>
											@foreach ($setting as $no => $p)
											<tr>
											
											
											 <td>{{ ++$no }}</td>
											 <td>{{ $p->mulai }}</td>
											 <td>{{ $p->selsai }}</td>
											 <td>{{ $p->paket }}</td>
											 <td>
                                                @if ( $p->kondisi == 1)
                                        <center><span class='badge badge-pill badge-info'>Aktif</span></center>
                                                    
                                                @else
                                        <center><span class='badge badge-pill badge-secondary'>Tidak Aktif</span></center>
                                                    
                                                @endif
                                             </td>
											 <td>{{ $p->petugas }}</td>
											 <td>
                                       <a href="" class="btn btn-primary">edit</a>
									   
									   @php
										$id = Crypt::encryptString($p->paket);
									@endphp

									   @if ($p->paket == 'UTS' || $p->paket == 'UAS'|| $p->paket == 'LATIHAN')
									   <a href="/detail-time-setting/{{$id}}" class="btn btn-info">detail</a>
								   @else
									   <!-- Code for the else condition goes here, if needed -->
								   @endif
								   
                                       

                                             </td>
											
											</tr>
											@endforeach
										</tbody>
						    	</table>
                                    {{--  <div style="text-align: center">
                                    {{$peserta->links("vendor.pagination.bootstrap-4")}}
                                </div>  --}}
								</div>
							</div>

						


						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>
@endsection
