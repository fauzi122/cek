
@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="table-container " >
       <div class="" > 
        <h4>     
      </h4>     
    </div>  
        <div class="table-responsive">
          <table class="table custom-table">
            <thead>
              <tr>
                <th colspan="2">Tugas Kuliah Pertemuan Ke- {{ $tugas->pertemuan }}</th>
              </tr>

            </thead>
            <tbody>
              <tr>
                <td>Judul</td>
                <td>
                  {{ $tugas->judul }}
                </td>

              </tr>

              <tr>
                <td>Deskripsi</td>
                <td>
                  {{ $tugas->deskripsi }}
                  
                </td>
                
              </tr>

              <tr>
              
              </tr>

              <tr>
                <td>Waktu Mengerjakan</td>
                <td>Mulai : {{ $tugas->mulai }}  <p><p>
                    Selsai : {{ $tugas->selsai }}
                </td> 
              </tr>

     
          
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      
      <div class="nav-tabs-container">
        <ul class="nav nav-tabs" id="myTab3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home3" aria-selected="true"><i class="icon-edit1"></i>Form Penilaian Tugas Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile3" aria-selected="false"><i class="icon-download-cloud"></i>Download Nilai Tugas</a>
          </li>
        
        </ul>
        <div class="tab-content" id="myTabContent3">
          <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
            <p>
            
              <div class="row gutte">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              
            
                  <div class="table-container " >
                   <div class="" > 
    
            </div>
            
            @if($mahasiswa<>null)
            <form action="{{url('/send-tugas')}}" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ $id }}"/>
              <input type="hidden" name="id_tugas" value="{{ $tugas->id }}"/>
              <right><button type="submit" class="btn btn-info btn-rounded btn-lg"><h5>
                <i class="icon-save"></i> Simpan Nilai</h5></button></right>
                    <div class="table-responsive">
                      <table  class="table projects-table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Nilai</th>
                            <th>Link Tugas</th>       
                            <th>Komentar</th>       
                            <th>Status</th>       
                            
                            
                          </tr>
                        </thead>
                        <tbody>
            
                          @php
                          $count=1;
                          @endphp
                           @foreach ($mahasiswa as $nim=>$mhs)
                               
                           <tr>
                             <td>{{$loop->iteration}} </td>                 
                             <td>{{$nim}}
                               
                             </td>
                             <td width="20%">{{$mhs}} <input type="hidden" name="no_urut[{{$count}}]" value="{{$nim}}"/></td>
                             <td width="10%"> <input type="text" maxlength="3"
                              class="form-contro col-sm-12" name="nilai[{{$count}}]" value=
                              @if (isset($nilai[$nim]->nilai))
                                   {{$nilai[$nim]->nilai}}
                               @else
                                   {{0}}
                               @endif
                              ></td>
                             <td width="20%">
                               @if (isset($nilai[$nim]->isi))
                               @if ($nilai[$nim]->isi<>null||$nilai[$nim]->isi<>'')
                               <a href="{{$nilai[$nim]->isi}}" target="blank" class="btn btn-info btn-sm">
                                   Link Tugas Mahasiswa  </a>  
                             @else
                                 
                             @endif 
                               @endif
                               
                               {{-- {{ $nilai[$nim]->isi }} --}}
                              </td> 
                              <td> 
                                {{-- {{$nilai[$nim]->unix_mhs}}
                                {{$nilai[$nim]->unix}} --}}
                                <textarea name="komentar[{{$count}}]" >@if (isset($nilai[$nim]->komentar)){{ $nilai[$nim]->komentar }}@else @endif</textarea>
                              </td>
                             <td>
                              @if (isset($nilai[$nim]->created_at))
                              @if (strtotime($nilai[$nim]->unix_mhs) > strtotime($nilai[$nim]->unix))
                              <span class="badge badge-danger">{{ $nilai[$nim]->created_at }}</span>
                              @else
                              <span class="badge badge-primary">{{ $nilai[$nim]->created_at }}</span>
                              
                              @endif
                              @else
                              <span class="badge badge-danger">Tidak Mengumpulkan</span>
                              
                          @endif
                              </td>
                          </tr>
                          @php
                                $count++;
                            @endphp
                        @endforeach 
                      </form>
                      @endif
            
                        
                      
                        </tbody>
                      </table>
                      
                    </div>
                  </div>
            
                </div>
              </div>
            
          
            </p>
          </div>
          <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
            <p>
                <div class="table-responsive">
                  <table id="myTable2" class="table custom-table">
										<thead>
											<tr>
											  <th>NO</th>
											  <th>NIM</th>
											  <th>NAMA</th>
											  <th>Nilai Tugas Pertemuan Ke- {{ $tugas->pertemuan }}</th>
											
											</tr>
										</thead>
										<tbody>
                      @foreach ($mahasiswa as $nim=>$mhs)
											<tr>
											  <td>{{$loop->iteration}}</td>
											  <td>{{ $nim }}</td>
											  <td>{{$mhs}} <input type="hidden" name="no_urut[{{$count}}]" value="{{$nim}}"/></td>
											  <td> 
                          @if (isset($nilai[$nim]->nilai))
                          {{$nilai[$nim]->nilai}}
                      @else
                          {{0}}
                      @endif  
                        </td>
											 
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

  <!-- Row end -->
  @push('scripts')
  <script type="text/javascript">
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
