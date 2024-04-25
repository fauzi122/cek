@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="alert-notify success">
								<div class="alert-notify-body">
									<span class="type">Info</span>
									<div class="alert-notify-title">  <h4>Jadwal Mahasiswa PKBN</h4>	</div>
									<div class="alert-notify-text"></div>
								<br>
                  <table  class="table custom-table">
                            <tr>
                                <td>Kode PT</td>
                               
                                <td><b>{{ $pts->kd_pt }}</b></td>

                            </tr>
                            <tr>
                                <td>Nama Perguruan Tinggi
                            </td>
                               
                                <td><b>{{ $pts->nm_pt }}</b></td>

                            </tr>
                       
                        </table>
								</div>
							</div>
            
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">
										<div class="invoice-header">
                
                           
                              <!-- Row start -->
                              <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="table-responsive">                       
                            
                                  <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>NO</th>                               
                                          <th>nim</th>                               
                                          <th>nama</th>
                                          <th>no_krs</th>
                                          <th>kd_mtk</th>
                                          <th>nm_mtk</th>
                                          <th>sks</th>
                                          <th>kd_dosen</th>
                                       
                                         

                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($jadwalmbkm_all  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$mbkm->nim}}</td>
                                    <td>{{$mbkm->nm_mhs}}</td>
                                    <td>{{$mbkm->no_krs}}</td>
                                    <td>{{$mbkm->kd_mtk}}</td>
                                    <td>{{$mbkm->nm_mtk}}</td>
                                    <td>{{$mbkm->sks}}</td>
                                    <td>{{$mbkm->kd_dosen}}</td>

                                 
                                   
                                    
                                
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

