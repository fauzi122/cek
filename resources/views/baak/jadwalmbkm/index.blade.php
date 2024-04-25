@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">
										<div class="invoice-header">
                
                     
									{{--  <a href="" class="btn btn-success">Input Jadwal MBKM</a>  --}}
								
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
										Import Excel Jadwal MBKM
									</button>
                   
                	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#vCenterModal">
									<i class="icon-delete"></i>	Kosongkan Jadwal MBKM
									</button>

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

									<!-- Modal -->
									<div class="modal fade" id="vCenterModal" tabindex="-1" role="dialog" aria-labelledby="vCenterModalTitle" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="vCenterModalTitle">Hapus Semua Data Jadwal Mbkm</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													    @can('mbkm_baak.delete') 
                                                <center>
                    <form class="dropdown-item" action="/jadwal-mbkm/tran" method="POST" onsubmit="return confirm('Anda Yakin Hapus Semua Jadwal MBKM?');">

                                                {{--  <form action="/jadwal-mbkm/tran" method="POST">  --}}
                                                    @csrf
                                                    <button class="btn btn-secondary btn-lg" type="submit">
                                                        <i class="icon-delete"></i> Kosongkan Data Jadwal MBKM </button>  
                                                </form>
                                                <center>

                                                @endcan
                                                <hr>
                           <label><h5>*Catatan :</h5> 
                           <br>
                          <h6> Data yang telah di hapus tidak dapat dikembalikan.  
												</div>
												
											</div>
										</div>
									</div>
									<!-- Modal -->
									<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="basicModalLabel">Import Excel Jadwal MBKM</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                         <form action="/upload/data-jadwal-mbkm" method="post" enctype="multipart/form-data">
                            @csrf
												  <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/jadwal_mbkm_baru.xlsx') }}"
                                        class="btn btn-info btn-sm">
                                        Unduh Format File<a></label>

                                         <div class="form-group">
                                
                                   
                           
                                <p class="text-danger"></p>
                                <input type="file" class="btn btn-primary" name="file">                           
                              <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                                   
                            </div>
                        </form>

                            	<hr>
                           <label><h5>*Catatan :</h5> 
                           <br>
                          <h6> 1.Upload soal harus sesuai format excel yang tersedia.  

                           
												</div>
									
                    
											</div>
										</div>
									</div>
                            </div>

                          
                            <div class="invoice-body">
                              <!-- Row start -->
                              <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="table-responsive">                       
                                  <p>
                                  <h4>Jadwal MBKM</h4>	
                                  <hr>
                                  </p>
                                  <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>NO</th>                               
                                          <th>nim</th>                               
                                          <th>nama</th>
                                          <th>no_krs</th>
                                          <th>kd_mtk</th>
                                          <th>kd_lokal</th>
                                          <th>kd_lokal_mbkm</th>
                                          <th>kd_dosen</th>
                                          <th>kd_kampus</th>
                                       
                                        

                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($jadwal  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$mbkm->nim}}</td>
                                    <td>{{$mbkm->nm_mhs}}</td>
                                    <td>{{$mbkm->no_krs}}</td>
                                    <td>{{$mbkm->kd_mtk}}</td>
                                    <td>{{$mbkm->kd_lokal}}</td>
                                    <td>{{$mbkm->kd_lokal_mbkm}}</td>
                                    <td>{{$mbkm->kd_dosen}}</td>
                                    <td>{{$mbkm->kd_kampus}}</td>

                                 

                                    
                                
                                     </tr>
                                  
                                     @endforeach     
                                          
                                      </tbody>
                                    </table>
                                </div>
												</div>
											</div>
											<!-- Row end -->






				</div>
				<!-- Content wrapper end -->
@endsection

