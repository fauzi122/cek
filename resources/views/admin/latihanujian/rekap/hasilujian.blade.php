@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
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
                                  <h4>List Latihan Ujian</h4>	
                                  <hr>
                                  </p>
                                    <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                                                       
                                          <th>No</th>                               
                                          <th>soal</th>                               
                                          <th>jawab</th>                               
                                          <th>benar/salah</th>                               
                                          <th>Waktu Jawab</th>                               
                                          
                                          
                                        </tr>
                                       </thead>
                                    <tbody>
                                    @foreach ($hasil as $no => $hasil)
                                    <tr>
                                    <td>{{ ++$no}}</td>
                                    <td>{{$hasil->soal}}</td>
                                    <td>{{$hasil->pilihan}}</td>
                                   
                                    <td>
                                     @if ($hasil->score == 1)
                                  <center><span class="badge badge-info">benar</label></center>
                                      @elseif($hasil->score == 0)
                                      <center><span class="badge badge-secondary">salah</label></center>
                                          
                                    @endif 
                                    <td>{{$hasil->updated_at}}</td>
                                
                                    </tr>
                                @endforeach
                                   
                                  
                                    </tbody>
                                    </table>
                                </div>
							</div>
							</div>
										</div>

										

									</div>
								</div>
							</div>
						</div>
            {{--  informasi  --}}
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">

							<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
							<div class="card-header badge-primary">
                        <h4 class="m-b-0 text-white">Informasi
                        <a href="/latihan" class="btn btn-sm btn-success">
                       <i class="icon-refresh"></i> Kembal</a>
                        </h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td width="100px">NIM</td>
                          
                          <td>{{$profil->username}}</td>
                        </tr>
                         <tr>
                          <td width="100px">Nama </td>
                          
                          <td>{{$profil->name}}</td>
                        </tr>
                         <tr>
                          <td width="100px">Kelas</td>
                          
                          <td>{{$profil->kode}}</td>
                        </tr>
                          <tr>
                          <td width="100px">Email</td>
                          
                          <td>{{$profil->email}}</td>
                        </tr>
                        
                     
                      </tbody>
                    </table>
{{--  
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td width="100px">Waktu Mulai</td>
                          
                          <td>{{$hasil_ujian->awal_ujian}}</td>
                        </tr>
                         <tr>
                          <td width="100px">Waktu Berakhir </td>
                          
                          <td>{{$hasil_ujian->akhir_ujian}}</td>
                        </tr>
                         <tr>
                          <td width="100px">Waktu Selsai</td>
                          
                          <td>{{$hasil_ujian->selesai_ujian}}</td>
                        </tr>
                          <tr>
                          <td width="100px">Jumlah Soal</td>
                          
                          <td>{{$hasil_ujian->jml_soal}}</td>
                        </tr>
                         <tr>
                          <td width="100px">Status</td>
                          
                          <td>{{$hasil_ujian->sts}}</td>
                        </tr>
                        
                     
                      </tbody>
                    </table>  --}}
									
								</div>
              </div>
            </div>
				{{--  and informasi  --}}

                

       

     {{--  info  --}}
     <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
        <div class="alert-notify info">
          <div class="alert-notify-body">
            <span class="type">Info</span>
            <div class="alert-notify-title">info aktifitas <img src="img/notification-info.svg" alt=""></div>
            <div class="alert-notify-text"> data yang di tampilkan merupakan aktifitas yang di lakukan oleh mahasiswa terkait
              <p></p>
              matakuliah yang di ampuh dan di ajarkan oleh bapak/ibu
            </div>
          </div>
        </div>
      </div>
					<!-- Row end -->


				</div>
				<!-- Content wrapper end -->
@endsection
