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
									<div class="alert-notify-title">  <h4>Data kelas PKBN</h4>	</div>
									<div class="alert-notify-text"></div>
									<div class="alert-notify-text"></div>
									<div class="alert-notify-text"></div>
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
                                          <th>Kode Dosen</th>                               
                                          <th>Kelas</th>
                                          <th>Kode Mtk</th>
                                          <th class="text-center">aksi</th> 
                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($nilai  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$mbkm->kd_dosen}}</td>
                                    <td>{{$mbkm->kd_lokal}}</td>
                                    <td>{{$mbkm->kd_mtk}}</td>
                                     <td class="text-center">
                                        
                                 @php  
                                $id=Crypt::encryptString($mbkm->kd_dosen.','.$mbkm->kd_lokal.','.$mbkm->kd_mtk);
                                @endphp
                                        
                                             {{--  @can('userdosen_adm.edit')  --}}
                                            {{--  <a href="/show/absen/pt-mbkm/{{ $id }}" class="btn btn-sm btn-info">
                                                <i class="icon-check" title="lihat absen mhs"></i>
                                                Lihat Absen Mahasiswa
                                            </a>  --}}
                                              <a href="/create/nilai/mbkm/{{ $id }}" class="btn btn-sm btn-info">
                                                <i class="icon-edit" title="lihat jadwal mhs"></i>
                                                Nilai
                                            </a>
                                             {{--  @endcan   --}}
                                            
                                          
                                        </td>
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

