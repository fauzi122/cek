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
                                  <h4>Detail Jawaban Kuis  Pilihan Ganda</h4>	
                                  <hr>
                                  </p>
                                    <table id="myTable1" class="table custom-table">
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
                                    @foreach ($jawab as $no => $hasil)
                                    <tr>
                                    <td>{{ ++$no}}</td>
                                    <td>{!!$hasil->soal!!}</td>
                                    <td>{{$hasil->pilihan}}</td>
                                   
                                    <td>
                                     @if ($hasil->score == 0)
                                      <center><span class="badge badge-secondary">salah</label></center>

                                      @else
                                  <center><span class="badge badge-info">benar</label></center>
                                          
                                    @endif 
                                    <td>{{$hasil->updated_at}}</td>
                                
                                    </tr>
                                @endforeach
                                   
                                  
                                    </tbody>
                                    </table>


                                  <p>
                                  <h4>Detail Jawaban Kuis  Essay</h4>	
                                  <hr>
                                  </p>
                                     <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                       	<tr>
						<th></th>
						<th>Soal</th>
						<th>Jawaban</th>
						<th>Nilai</th>
					</tr>
                                       </thead>
                                    <tbody>
                                   @if($jawab_essay->count())
					<?php $no = 1; ?>
					@foreach($jawab_essay as $essay)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{!! $essay->soal ?? '' !!}</td>
					
						<td>{!! $essay->jawab ?? '' !!}</td>
				
            <td>
							<input type="number"onkeydown="limit(this);" onkeyup="limit(this);" id="nilai-essay" class="form-control text-center" data-id="{{ $essay->id ?? 0 }}" data-user="{{ $essay->id_user ?? 0 }}" value="{{ $essay->score ?? '' }}" placeholder="{{ rand(40,99) }}">
						</td>
					</tr> 
					@endforeach
					@endif
                                   
                                  
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

									
								</div>
              </div>
            </div>
            <div>
		
	</div>

  
				{{--  and informasi  --}}


     {{--  info  --}}
     <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
        <div class="alert-notify info">
          <div class="alert-notify-body">
            <span class="type">Info</span>
            <div class="alert-notify-title">info aktifitas <img src="img/notification-info.svg" alt=""></div>
            <div class="alert-notify-text"> data yang di tampilkan merupakan aktifitas yang di lakukan oleh  mahasiswa yang bernama <b>{{$profil->name}} </b>
              <p></p>
              soal yang di terbitkan oleh bapak/ibu sesuai matakuliah yang di ampuh dan di ajarkan 
              <br>
            
            </div>
          </div>
        </div>
      </div>
					<!-- Row end -->


				</div>
                 @push('scripts')
                <script type="text/javascript">
        $(document).on('keyup', '#nilai-essay', function() {
		  const  essay_id = $(this).data('id');
			const id_user = $(this).data('user');
			const score =$(this).val();
        console.log(score);
        	$.ajax({
				type: "GET",
				url: "{{ url('/essay/simpan-score') }}",
				data: {
					essay_id: essay_id,
					id_user: id_user,
					score: score
				},
				success: function(data) {
					console.log(data);

				}
			})
		} ) ;


                $('.tombol-hapus').on('click',function(e){
              e.preventDefault();
              const href=$(this).attr('href');
              Swal.fire({
                title: 'Apakah anda yakin',
                text: "Data akan dihapus",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
              }).then((result) => {
                if (result.value) {
                  document.location.href=href;
                  
                }
              })
              });
              $(document).ready(function () {
                   $('#myTable1').DataTable({
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

            function limit(element)
            {
                var max_chars = 3;

                if(element.value.length > max_chars) {
                    element.value = element.value.substr(0, max_chars);
                }
            }
                  </script>

                
              @endpush
				<!-- Content wrapper end -->
@endsection
