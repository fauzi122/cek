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
							
                                <h4 class="m-b-0 text-white">Setting Waktu Perakit Soal Ujian </h4>
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
											 <td>{{ $p->petugas }}</td>
											 <td>
												<a href="{{ route('perakit_soal.edit', $p->id) }}" class="btn btn-primary">Edit</a>
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
