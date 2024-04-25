
@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
      <div class="card-header badge-primary">
							
        <h4 class="m-b-0 text-white">List Jadwal Kuis</h4>
    </div>
      <div class="table-container " >
       <div class="" > 
        <h4> 
		 
          <a href="/latihan-create"><button class="btn btn-primary btn-lg"><i class="icon-add"> </i> Jadwal Kuis. </button></a>
          <a href="{{ Storage::url('public/Panduan Kuis MyBest Dosen.pdf') }}" target="_blank" class="btn btn-info btn-lg">
            <i class="icon-file-text"></i>
            Panduan Kuis Online 
        </a>
      </h4>
      <hr>
      </div>
      
        <div class="table-responsive">
          <table id="copy-print-csv" class="table custom-table">
            <thead>
              <tr>
                <th><center>No</center></th>
                <th>Kode Mtk</th>
                
                <th>Paket</th>
               
                <th>KKM</th>
                <th>Waktu</th>       
                <th><center>Jml</center></th>       
                    
                <th>Tanggal Ujian Mulai</th>
                <th>Tanggal Ujian Selsai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              
            @foreach ($soals as $no => $soal)
            @php
            $id=Crypt::encryptString($soal->id.','.$soal->kd_mtk);                                    
            @endphp
             <tr>
                 <td><center>{{ ++$no }}</center></td>
                 <td><b>{{ $soal->kd_mtk }}</b> - {{ $soal->nm_mtk }}</td>
                 
                 <td>{{ $soal->paket }}</td>
                 <td>{{ $soal->kkm }}</td>
                 <td>{{ $soal->waktu }} menit</td>
                 <td><span class='badge badge-pill badge-light'>{{ $soal->jml_soal }} soal </span></td>
                
                 <td>{{ $soal->tgl_ujian }}</td>
                 <td>{{ $soal->tgl_selsai_ujian }}</td>
                 <td>

                 <div class="btn-group">
										<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Menu
										</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="/edit-jadwal/latihan/{{ $id }}">Edit Jadwal</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="/soal-show/{{ $id }}">Master Soal</a>
										</div>
									</div>
                 
                 </td>
                 
             </tr>

              @endforeach
          
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
  <!-- Row end -->


</div>

@endsection
