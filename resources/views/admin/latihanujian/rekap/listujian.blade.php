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
                    {{--  @php
                    $id=Crypt::encryptString($soal->id);                                    
                    @endphp  --}}
									
                            </div>
                            <div class="invoice-body">
                              <!-- Row start -->
                              <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="table-responsive">                       
                                  <p>
                                  <h4>List Jadwal Kuis  	<a href ="/list-class" class="btn btn-sm btn-info"> <i class="icon-replay"></i> kembali</a>
                                 </h4>
                                  <hr>
                                  </p>
                                    <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                                                       
                                          <th>No</th>                               
                                          <th>MTK</th>                               
                                          <th>Kelas</th>                               
                                                                     
                                          <th>Paket soal/Deskripsi</th>                               
                                          <th>Jml PG</th>                               
                                          <th>Jml ESSAY</th>                               
                                          <th>mulai</th>                               
                                          <th>selsai</th>                               
                                          
                                         
                                          
                                          <th>Aksi</th>
                                        </tr>
                                       </thead>
                                    <tbody>
                                    @foreach ($rekap as $no => $ujian)
                                    <tr>
                                    <td>{{ ++$no}}</td>
                                    <td> {{$ujian->nm_mtk}} <b>{{$ujian->kd_mtk}}</b> </td>
                                   
                                    <td>{{$ujian->id_kelas}}</td>
                                    <td>{{$ujian->deskripsi}}</td>
                                    <td>{{$ujian->jml_soal}}</td>
                                    <td>{{$jml_essay}}</td>
                                    <td>{{$ujian->tgl_ujian}}</td>
                                    <td>{{$ujian->tgl_selsai_ujian}}</td>
                                   
                                    
                                   
                                        @php    
                                      
                                        $id=Crypt::encryptString($ujian->id.','.$ujian->id_kelas);                                    
                                        @endphp
                               
                                    <td>
                                      <center>
                                  
                                     
                                    <a href="/lihat/hasil-latihan-all/{{$id}}" class="btn btn-sm btn-info">
                                                <i class="icon-check" title="lihat rekap nilai mhs"></i>
                                              
                                            </a>
                                          </center>
                                    </td>

                                 
                                    </tr>
                                @endforeach
                                   
                                  
                                    </tbody>
                                    </table>
                                </div>
												</div>
											</div>
											<!-- Row end -->

                      	<!-- Row start -->
                      
						
											<!-- Row end -->
										</div>

										

									</div>
								</div>
							</div>
						</div>
          			<!-- Row end -->


				</div>
				<!-- Content wrapper end -->
@endsection
