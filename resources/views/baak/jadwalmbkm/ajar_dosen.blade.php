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

								
							   </div>

                          
                            <div class="invoice-body">
                              <!-- Row start -->
                              <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="table-responsive">                       
                                  <p>
                                  <h4>Berita Acara Pengajaran Dosen PKBN ALL</h4>	
                                  <hr>
                                  </p>
                                  <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>temu</th>

                                          <th>Nip</th>                               
                                          <th>kd_dosen</th>
                                          <th>kd_mtk</th>
                                          <th>kd_lokal</th>
                                          <th>tgl</th>
                                          <th>masuk</th>
                                          <th>keluar</th>
                                          <th>Berita</th>
                                       
                                        

                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($ajar_mbkm  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{$mbkm->pertemuan}}</td>
                                    <td>{{$mbkm->nip}}</td>
                                    <td>{{$mbkm->kd_dosen}}</td>
                                    <td>{{$mbkm->kd_mtk}}</td>
                                    <td>{{$mbkm->kd_lokal}}</td>
                                    <td>{{$mbkm->tgl_ajar_masuk}}</td>
                                    <td>{{$mbkm->jam_masuk}}</td>
                                    <td>{{$mbkm->jam_keluar}}</td>
                                    
                                   
                                    <td>{{$mbkm->berita_acara}}</td>

                                 

                                    
                                
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

