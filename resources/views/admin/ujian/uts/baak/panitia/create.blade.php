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
							
							

							<div class="table-container">
								<div class="t-header">
                                  
                                
                                   List Panitia Ujian
                               
                                </div>

								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>Nama</th>
											  <th>Username</th>
											  <th>Kode</th>
											  <th>Jenis</th>
											  <th>Kampus</th>
											  <th>Petugas</th>
											
											
											  <th>Updated_at</th>
											  
											  {{--  <th> 
                                                <center>
                                                Aksi
                                              </center>
                                            </th>  --}}
											</tr>
										</thead>
										<tbody>
											@foreach ($panitia as $no => $panitia)
											<tr>
											
											
											 <td>{{ $panitia->name }}</td>
											 <td>{{ $panitia->username }}</td>
											 <td>{{ $panitia->kode }}</td>
											 <td>{{ $panitia->jenis }}</td>
											 <td>{{ $panitia->kampus }}</td>
											 <td>{{ $panitia->petugas }}</td>
											
											 <td>{{ $panitia->updated_at }}</td>
										
											
											 {{--  <td>
                                                <center>
												<a href="" class="btn btn-xs btn-info">Edit</a>
											
                                                </center>
											 </td>  --}}
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
