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
									<div class="alert-notify-title">  <h4>Rekap Nilai Mahasiswa PKBN All</h4>	</div>
									{{--  <div class="alert-notify-text">Catatan  1 : (Hadir), 0 : (Tidak Hadir)</div>  --}}
                  <br>
                   <table  class="table custom-table">
                            {{--  <tr>
                                <td>Kode Dosen</td>
                               
                                <td><b>{{ $dosen->kd_dosen }}</b></td>

                            </tr>
                            <tr>
                                <td>Kode Matakuliah
                            </td>
                               
                                <td><b>{{ $dosen->kd_mtk }}</b></td>

                            </tr>
                             <tr>
                                <td>Kelas
                            </td>
                               
                                <td><b>{{ $dosen->kd_lokal }}</b></td>

                            </tr>
                       
                        </table>  --}}
								</div>
							</div>
									
								</div>
							</div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="nav-tabs-container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        {{--  <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            <i class="icon-edit" ></i> Form Input Nilai</a>
                        </li>  --}}
                        {{--  <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="icon-download" ></i> Download Nilai</a>
                        </li>  --}}
                      
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <p>
                                {{--  <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>NO</th>                               
                                          <th>Kd_pts</th>                               
                                          <th>nm_pts</th>                               
                                          <th>nim</th>                               
                                          <th>nama</th>
                                          <th class="text-center">nilai</th> 
                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($nilai  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$mbkm->kd_kampus}}</td>
                                    <td>{{$mbkm->nm_pt}}</td>
                                    <td>{{$mbkm->nim}}</td>
                                    <td>{{$mbkm->nm_mhs}}</td>
                                     <td class="text-center">
                                     <input type="input" id="nilai{{$no+1}}" onkeydown="limit(this);" onkeyup="limit(this);" onkeypress="return angka(event)" class="nilai form-control text-center" data-no="{{$no+1}}" data-nim="{{ $mbkm->nim ?? 0 }}" data-kd_mtk="{{ $mbkm->kd_mtk ?? 0 }}" value="{{ $mbkm->nilai ?? '' }}">
                                     </td>

                                     </tr>
                                  
                                     @endforeach     
                                          
                                      </tbody>
                                    </table>
                                   
                                </div>  --}}
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
                                          <th>Kode MTK</th>
                                          <th>Kode Dosen</th>
                                          <th>updated_at</th>
                                          
                                        
                                        </tr>
                                       </thead>
                                        @foreach ($nilaiall  as $no => $mbkm)
                                            
                                       
                                     <tr>
                                    <td>{{++$no}}</td>
                                        <td>{{$mbkm->kd_kampus}}</td>
                                    <td>{{$mbkm->nm_pt}}</td>
                                    <td>{{$mbkm->nim}}</td>
                                    <td>{{$mbkm->nm_mhs}}</td>
                                     <td>{{$mbkm->nilai}}</td>
                                     <td>{{$mbkm->kd_mtk}}</td>
                                     <td>{{$mbkm->kd_dosen}}</td>
                                     <td>{{$mbkm->updated_at}}</td>
                                     

                                     </tr>
                                  
                                     @endforeach     
                                          
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
@push('scripts')
<script type="text/javascript">
$(document).on('keyup', '.nilai', function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
		  const no = $(this).data('no');
		  const nim = $(this).data('nim');
			const kd_mtk = $(this).data('kd_mtk');
			const nilai =$(this).val();
        	$.ajax({
				type: "POST",
				url: "{{ url('/input-nilai-pkbn') }}",
				data: {
					nim: nim,
					kd_mtk: kd_mtk,
					nilai: nilai
				},
				success: function(data) {
          if(data.success==null){
          document.getElementById('nilai'+no).style.backgroundColor = "red" ;
          }else if(data.success=='false'){
          alert("Data Mahasiswa Ini Tidak Ada");
          document.getElementById('nilai'+no).value = "";
          }else{
          document.getElementById('nilai'+no).style.backgroundColor = "transparent" ;
          }

				}
			})
	});
  function angka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
    function limit(element)
            {
                var max_chars = 3;

                if(element.value.length > max_chars) {
                    element.value = element.value.substr(0, max_chars);
                }
            }
    $(document).ready(function () {

       $('#myTable2').DataTable({
        dom: 'Blfrtip',
                    lengthMenu: [
                        [1000 ],
                        [ 'Show All' ]
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
        });
     });
    </script>
@endpush
