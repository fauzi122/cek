@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
                  
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="alert-notify info">
								<div class="alert-notify-body">
									<span class="type">Info</span>
									<div class="alert-notify-title">  <h4>Rekap Absen Mahasiswa PKBN</h4>	</div>
									<div class="alert-notify-text">Catatan  1 : (Hadir), 0 : (Tidak Hadir)</div>
                  <br>
                  
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
                                          <th>kd_mtk</th>
                                          <th>kd_lokal</th>
                                          <th>1</th>
                                          <th>2</th>
                                          <th>3</th>
                                          <th>4</th>
                                          <th>5</th>
                                          <th>6</th>
                                          <th>7</th>
                                          <th>8</th>
                                          <th>9</th>
                                          <th>10</th>
                                          <th>11</th>
                                          <th>12</th>
                                          <th>13</th>
                                          <th>14</th>
                                          <th>15</th>
                                          <th>16</th>
                                          <th>jml</th>
                                        
                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($absen_mbkm  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$mbkm->nim}}</td>
                                    <td>{{$mbkm->nm_mhs}}</td>
                                    <td>{{$mbkm->kd_mtk}}</td>
                                    <td>{{$mbkm->kd_lokal}}</td>
                                    <td>{{$mbkm->a1}}</td>
                                    <td>{{$mbkm->a2}}</td>
                                    <td>{{$mbkm->a3}}</td>
                                    <td>{{$mbkm->a4}}</td>
                                    <td>{{$mbkm->a5}}</td>
                                    <td>{{$mbkm->a6}}</td>
                                    <td>{{$mbkm->a7}}</td>
                                    <td>{{$mbkm->a8}}</td>
                                    <td>{{$mbkm->a9}}</td>
                                    <td>{{$mbkm->a10}}</td>
                                    <td>{{$mbkm->a11}}</td>
                                    <td>{{$mbkm->a12}}</td>
                                    <td>{{$mbkm->a13}}</td>
                                    <td>{{$mbkm->a14}}</td>
                                    <td>{{$mbkm->a15}}</td>
                                    <td>{{$mbkm->a16}}</td>
                                    <td>{{$mbkm->Jml}}</td>
                                  

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

