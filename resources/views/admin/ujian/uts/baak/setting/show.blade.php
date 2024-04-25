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
							<br>
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
							<div class="table-container">
									
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>No</th>
											  <th>kelompok</th>
											  <th>Tanggal </th>
											  <th>Hari</th>
											  <th>paket</th>
											  <th>status</th>
											  <th>petugas</th>
											  <th>Aksi</th>
											
											</tr>
										</thead>
										<tbody>
											@foreach ($tgluji as $no => $p)
											<tr>
											
											
											 <td>{{ ++$no }}</td>
											 <td>{{ $p->kel_ujian }}</td>
											 <td>{{ $p->tgl_ujian }}</td>
											 <td>{{ $p->hari_ujian }}</td>
											 <td>{{ $p->paket }}</td>
											 <td>{{ $p->status }}</td>
											 <td>{{ $p->petugas }}</td>
											 <td>
									@php
									$id = Crypt::encryptString($p->kel_ujian.','.$p->tgl_ujian.','.$p->hari_ujian.','.$p->paket);
									@endphp
												<a href="/edit-time-setting/{{$id}}" class="btn btn-sm btn-info">edit</a>
												{{-- <a href="" class="btn btn-secondary">hapus</a> --}}
												{{-- <form action="{{ url('/delete-time-setting/'.$id) }}" method="POST">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-sm btn-secondary">Delete</button>
												</form>  --}}
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
