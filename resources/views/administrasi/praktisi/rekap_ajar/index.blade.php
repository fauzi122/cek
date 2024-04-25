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
									<div class="alert-notify-title">  <h4>Rekap Ajar Dosen Praktisi</h4>	</div>
									{{--  <div class="alert-notify-text">Catatan  1 : (Hadir), 0 : (Tidak Hadir)</div>  --}}
                  <br>
                           <h5> *Catatan : kode dosen dapat di kosongkan, jika pencarian hanya ingin berdasarkan tanggal saja
                            </h5><p>
                  <form action="/cari-data-rekap" method="GET">
                  <table  class="table custom-table">
                            <tr>
                            <td>Kode Dosen</td>
                                <td><input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen"class="nilai form-control" ></td>
                            </tr>
                            <tr>
                            <td>Tanggal Awal</td>
                                <td>
                               <input type="date" name="tgl_awal" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Masukkan Tanggal Awal" class="nilai form-control">

                            </td>
                            </tr>
                             <tr>
                             <td>Tanggal Akhir</td>
                                <td>
                                 <input type="date" name="tgl_akhir" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Masukkan Tanggal Akhir" class="nilai form-control">

                            </td>
                            </tr>

                            <tr>
                             <td colspan="2"style="text-align: right;">
                             
                            <button type="submit" class="btn btn-info">Cari Data Rekap</button><br>
                        </td>
                            </tr>
                        </table>
                  </form>
								</div>
							</div>
									
								</div>
							</div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="nav-tabs-container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            <i class="icon-folder" ></i>Rekap Ajar Dosen Praktisi ALL</a>
                        </li>
                        {{--  <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="icon-download" ></i> Download Nilai</a>
                        </li>  --}}
                      
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <p>
                                <div class="table-responsive">
                               <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>NO</th>                               
                                          <th>nip</th>                               
                                          <th>kd_dosen</th>                               
                                          <th>kd_lokal</th>                               
                                          <th>kel_praktek</th>
                                          <th>Matakuliah</th>
                                          <th>sks</th>
                                          <th>tgl_ajar_masuk</th>
                                          
                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($rekap  as $no => $rekap)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$rekap->nip}}</td>
                                    <td>{{$rekap->kd_dosen}}</td>
                                    <td>{{$rekap->kd_lokal}}</td>
                                    <td>{{$rekap->kel_praktek}}</td>
                                    <td>{{$rekap->nm_mtk}} <b>{{$rekap->kd_mtk}}</b></td>
                                    <td>{{$rekap->sks}}</td>
                                    <td><b>{{$rekap->tgl_ajar_masuk}}</b></td>
                                  

                                     </tr>
                                  
                                     @endforeach     
                                          
                                      </tbody>
                                    </table>
                                   
                                </div>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <p>
                               <b> Catatan : jika nilai yang tampil tidak sesuai dengan yang anda input </b> <a href="" class="btn btn-sm btn-info">Klik Refresh</a>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                  <div class="table-responsive"> 
                                   <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>no</th>
                                         <th>Kd_pts</th>                               
                                          <th>nm_pts</th>
                                          <th>nim</th>
                                          <th>nama</th>
                                          <th>nilai</th>
                                          <th>updated_at</th>
                                          
                                        
                                        </tr>
                                       </thead>
                                        {{--  @foreach ($nilai  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                        <td>{{$mbkm->kd_kampus}}</td>
                                    <td>{{$mbkm->nm_pt}}</td>
                                    <td>{{$mbkm->nim}}</td>
                                    <td>{{$mbkm->nm_mhs}}</td>
                                     
                                     <td>{{$mbkm->nilai}}</td>
                                     <td>{{$mbkm->updated_at}}</td>
                                     

                                     </tr>
                                  
                                     @endforeach       --}}
                                          
                                      </tbody>
                                    </table>
                               </div>
                            </p>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>

						
				<!-- Content wrapper end -->
@endsection
