
@extends('layouts.mhs.main')

@section('content')
<div class="row gutters">
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
        <div class="card-header badge-primary">
							
            <h4 class="m-b-0 text-white">List Jadwal Latihan</h4>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="invoice-container">
                    
               
                    <div class="invoice-body">

                        <!-- Row start -->
                        <div class="row gutters">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table id="copy-print-csv" class="table custom-table">
                                        <thead>
                                          <tr>
                                            <th><center>No</center></th>
                                            <th>Kode Mtk</th>
                                            
                                            <th>Paket</th>
                                           
                                            <th>Dosen</th>
                                            <th>Waktu</th>       
                                            <th>TGL Ujian Mulai</th>
                                            <th>TGL Ujian Selsai</th>
                                            <th>Aksi</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          
                                        @foreach ($pakets as $no => $soal)
                                        @php
                                        $id=Crypt::encryptString($soal->ids.','.$soal->kd_mtk);                                    
                                        @endphp
                                         <tr>
                                             <td><center>{{ ++$no }}</center></td>
                                             <td><b>{{ $soal->kd_mtk }}</b> - {{ $soal->nm_mtk }} </td>
                                             
                                             <td>{{ $soal->paket }}</td>
                                             <td>{{ $soal->kd_dosen }}</td>
                                             <td><b>{{ $soal->waktu }}</b> menit</td>
                                             <td>{{ $soal->tgl_ujian }}</td>
                                             <td>{{ $soal->tgl_selsai_ujian }}</td>
                                             <td>
                                               <a href="/exercise-show/{{ $id }}" class="btn btn-sm btn-info">
                                                 show</a>
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

                   
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
                <div class="invoice-status">
                    <i class="icon-warning1"></i>
                    <h3 class="status text-success">informasi</h3>
                    <p class="status-type">Silahkan lakukan ujian sesuai dengan jadwal yang telah di tentukan oleh dosen pengampu matakuliah.</p>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
                <div class="invoice-status">
                    <i class="icon-watch_later"></i>
                    <h3 class="status text-info">Aktifitas Terkini</h3>
                    <div class="card-body">
                        <div class="customScroll5">
                            <ul class="project-activity">

                                <li class="activity-list">
                                    <div class="detail-info">
                                        <p class="date">Today</p>
                                        <p class="info">Messages accepted with attachments.</p>
                                    </div>
                                </li>
                             </ul>
                    
                </div>
            </div>
            
        </div>

    </div>
</div>
@endsection
