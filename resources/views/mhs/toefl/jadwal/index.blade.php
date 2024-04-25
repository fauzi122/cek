
@extends('layouts.mhs.main')

@section('content')
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" id="clear" data-id="1" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
    @endif
<div class="row gutters">
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
        <div class="card-header badge-primary">
							
            <h4 class="m-b-0 text-white">List Pemblajaran dan Kuis</h4>
        </div>
     
        <div class="card">
            <div class="card-body p-0">
                <div class="invoice-container">
                    <div class="invoice-body">
                        <a href="{{ Storage::url('public/Panduan Kuis MyBest Mahasiswa.pdf') }}" target="_blank" class="btn btn-info btn-lg">
                            <i class="icon-file-text"></i>
                            Panduan Kuis Online 
                        </a>
                        <!-- Row start -->
                        <div class="row gutters">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table id="copy-print-csv" class="table custom-table">
                                        <thead>
                                          <tr>
                                            <th><center>No</center></th>
                                            <th>Kode Mtk</th>
                                            <th>Materi</th>
                                            <th>Judul Materi</th>
                                            <th>Dosen</th>
                                            <th>Waktu</th>       
                                            <th>Ujian Mulai</th>
                                            <th>Ujian Selesai</th>
                                            <th>Aksi</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        @if ($pakets!=null)
                                        @foreach ($pakets as $id_soal => $soal)
                                        @php
                                        $id=Crypt::encryptString($soal->ids.','.$soal->kd_mtk);                                    
                                        @endphp
                                         <tr>
                                             <td><center>{{ $loop->iteration }}</center></td>
                                             <td><b>{{ $soal->kd_mtk }}</b> - {{ $soal->nm_mtk }} </td>
                                             
                                             <td>
                                             <form id="downloadForm" action="/download-file-toef" method="post" onsubmit="startDownload()">
                                            <div class="task-desc readmore">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$soal->ids}}">
                                                <input type="hidden" name="file" value="{{$soal->file_path}}">
                                                <button type="submit" class="badge badge-info"><i class="icon-download"></i> Unduh File</button>
                                            </div>
                                        </form>

                                        <script>
                                        function startDownload() {
                                            setTimeout(function() {
                                                location.reload(); // Memperbarui halaman setelah 1 detik (Anda dapat mengatur waktu yang sesuai)
                                            }, 1000);
                                        }
                                        </script>

                                              </td>
                                             <td>{{ $soal->judul }}</td>
                                             <td>{{ $soal->kd_dosen }}</td>
                                             <td><b>{{ $soal->waktu }}</b> menit</td>
                                             <td>{{ $soal->tgl_ujian }}</td>
                                             <td>{{ $soal->tgl_selsai_ujian }}</td>
                                             <td>
    @if (isset($readMateri[$id_soal]))
         @if(STRTOTIME($soal->tgl_selsai_ujian)<STRTOTIME(DATE("Y-m-d H:i:s")))   
                    <a href="#" class="btn btn-danger btn-rounded">Ujian Lewat</a>    
        @elseif(STRTOTIME($soal->tgl_ujian) > STRTOTIME(DATE("Y-m-d H:i:s")))
                    <a href="#" class="btn btn-light btn-rounded">Belum Mulai</a>    
        @else
            @if (isset($hasil_ujian[$id_soal]->sts))
                @if ($hasil_ujian[$id_soal]->sts=='0' || $hasil_ujian[$id_soal]->sts=='1')
                    <a href="/cetak-ujian-pdf/{{ $id }}" class="btn btn-primary btn-rounded" target="_blank">Cetak Bukti</a>
                @else
                    <a href="/toefl-show/{{ $id }}" class="btn btn-info btn-rounded">Mulai Ujian</a>
                @endif
            @else
                <a href="/toefl-show/{{ $id }}" class="btn btn-info btn-rounded">Mulai Ujian</a>
            @endif
        @endif
    @endif

                                             </td>
                                             
                                         </tr>
                            
                                          @endforeach
                                      @endif
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
                    <p class="status-type">Silahkan lakukan unduh materi pemblajaran maka link kusi akan terbuka</p>
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
                                        <p class="info">coming soon.</p>
                                    </div>
                                </li>
                             </ul>
                    
                </div>
            </div>
            
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script src="{{ url('js/toefl-jquery-ujian.js?v=6') }}"></script>
@endpush
