
@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
				<div class="content-wrapper">
          <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
          <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">
										<div class="invoice-header">
                    <div class="table-responsive">
     
        </div>
									
                            </div>
                            <div class="invoice-body">
                              <!-- Row start -->
                              <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="table-responsive">                       
                                  <p>
                                  <h4>Rekap Nilai Kuis</h4>	
                                  <hr>
                                  </p>
                                     <div class="table-responsive">
                  <table id="myTable2" class="table custom-table">
										<thead>
											<tr>
											  <th>NO</th>
											  <th>NIM</th>
											  <th>NAMA</th>
											  <th>jml benar PG</th>
										
											  <th>NILAI PG</th>
											  <th>NILAI essay</th>
											
											
                                                
											  <th> 
                        <center>
                        Jumlah
                        </center>
                        </th>
											  <th> 
                        <center>
                        check
                        </center>
                        </th>
											 
                        <th> 
                        <center>
                        Reset
                        </center>

                        </th>
											</tr>
										</thead>
										<tbody>
                    
                    
                      @php 

                       @endphp 

                       
                      @foreach ($mahasiswa as $nim=>$mhs)
											<tr>
											  <td><center>{{$loop->iteration}}</center></td>
											  <td>{{ $nim }}</td>
											  <td>{{$mhs}}  </td>
											  <td>
                        @if (isset($nilai_mhs[$nim]->soal_benar))
                           {{$nilai_mhs[$nim]->soal_benar}} 
                        @endif
                       
                         </td>
                        
                        
                                             <td> 
                                         
											                  @if (isset($nilai_mhs_pg[$nim]))
                                            @php
                                          
                                              $pg = $nilai_mhs_pg[$nim];
                                            @endphp
                                                {{ $pg }} 
                                             @else
                                                0 
                                            @endif
                                                
                                            </td>
                                            
                                            
                                            <td>
                                             @if (isset($nilai_mhs_essay[$nim]))
                                            @php 
                                              $ne = $nilai_mhs_essay[$nim];
                                            @endphp
                                                {{ $ne }} 
                                             @else
                                              0    
                                            @endif
                                            </td>

                                            <td>
                                              @if (isset($nilai_mhs_essay[$nim]))
                                                  @if (isset($nilai_mhs_pg[$nim]))
                                           
                                                {{ $nilai_mhs_essay[$nim] + $nilai_mhs_pg[$nim]}} 
                                                 @else
                                                  {{ $nilai_mhs_essay[$nim] }}
                                                 @endif 

                                              @else
                                                @if (isset($nilai_mhs_pg[$nim]))
                                                  {{$nilai_mhs_pg[$nim]}}
                                                  @else
                                                 0
                                                 @endif    
                                              @endif
                                            </td>
                                            <td>
                                             @if (isset($nilai_mhs[$nim]->soal_benar))
                                                
                                                @php    
                                                   
                                              $id=Crypt::encryptString($nilai_mhs[$nim]->id_soal.','.
                                                $nilai_mhs[$nim]->id_user.','.
                                                $nilai_mhs[$nim]->kd_lokal);                             
                                                @endphp
                                                
                                                {{--  {{ $id }}  --}}
                                                <center>
                                              <a href="/lihat/uji-mhs-detail/{{$id}}" class="btn btn-sm btn-info">
                                                <span class="icon-check" title="lihat jawaban mhs"></span>                                               
                                            </a>
                                                </center>
                                               
                                            @else
                                                {{--  {{0}}  --}}
                                              
                                            @endif  
                                            </td>

                                      <td>
                                             @if (isset($nilai_mhs[$nim]->soal_benar))
                                                
                                                @php    
                                                   
                                              $id_reset=($nilai_mhs[$nim]->id);

                                               $id_reset_jawab=Crypt::encryptString($nilai_mhs[$nim]->id_soal.','.
                                                $nilai_mhs[$nim]->id_user.','.
                                                $nilai_mhs[$nim]->kd_lokal);

                                                @endphp
                                                  

                                      <div class="btn-group">
										<button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											 <i  class="icon-close"  title="Reset Data Ujian mhs"></i>
										</button>
										<div class="dropdown-menu">
                    <form class="dropdown-item" action="/destroy-latihanuji-all/{{ $id_reset_jawab}}" method="POST" onsubmit="return confirm('Anda Yakin Hapus Jawaban Ujian Mahasiswa?');">
                                          @csrf
                                          <input type="hidden" name="_method" value="DELETE">
                                          <button type="submit" value="Delete" class="btn btn-sm btn-secondary">
                                           <i  class="icon-close"  title="lihat jawaban mhs"></i>Hapus Jawaban mhs </button>
                                          </form>
											
                      <div class="dropdown-divider"></div>

                       <form class="dropdown-item" action="/destroy-latihanuji/{{ $id_reset}}" method="POST" onsubmit="return confirm('Anda Yakin Aktifitas Ujian Mahasiswa?');">
                                          @csrf
                                          <input type="hidden" name="_method" value="DELETE">
                                          <button type="submit" value="Delete" class="btn btn-sm btn-secondary">
                                           <i  class="icon-close"  title="lihat jawaban mhs"></i>
                                           Hapus Aktifitas Ujian</button>
                                      </form>
											
										</div>
									</div>
                                                </center>
                                               
                                            @else
                                                {{--  {{0}}  --}}
                                              
                                            @endif
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
                @push('scripts')
  <script type="text/javascript">

$(document).ready(function () {
     $('#myTable2').DataTable({
      dom: 'Blfrtip',
                  lengthMenu: [
                      [ 10, 25, 50, 10000 ],
                      [ '10', '25', '50', 'Show All' ]
                  ],
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ],
    responsive: true
      });

   });
    </script>
@endpush

@endsection
