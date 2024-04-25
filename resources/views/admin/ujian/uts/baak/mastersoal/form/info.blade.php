<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">

							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
								<div class="card-header badge-primary">
                        <h4 class="m-b-0 text-white">Informasi
                          <a href="/soal/master-baak" class="btn btn-sm btn-success">
                            <i class="icon-refresh"></i> Kembali.
                        </a>
                        
                        </h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td width="100px"> Paket Ujian</td>
                          
                          <td>{{$soal->paket}} | {{$soal->jenis_mtk}}</td>
                        </tr>
                        <tr>
                          <td width="100px">Nama MTK</td>
                          
                          <td>{{$soal->nm_mtk}}</td>
                        </tr>
                        <tr>
                          <td>Kode MTK</td>
                          
                          <td>{{$soal->kd_mtk}}</td>
                        </tr>

                        <tr>
                          <td>Perakit</td>
                          
                          <td>
                            @if(isset($acc->perakit_kirim) && $acc->perakit_kirim == 1)
                                <span class="check-green">✔️</span>
                                <span>{{ $acc->kd_dosen_perakit }} | {{ formatDatebln($acc->tgl_perakit) }}</span>
                            @elseif (isset($acc->perakit_kirim_essay) && $acc->perakit_kirim_essay == 1)
                                <span class="check-green">✔️</span>
                                <span>{{ $acc->kd_dosen_perakit }} | {{ formatDatebln($acc->tgl_perakit) }}</span>
                            @else
                                <span class="check-transparent"></span>
                            @endif
                        </td>
                        
                        </tr>
                        <tr>
                            <td>Kaprodi</td>
                            <td>
                                @if(isset($acc->acc_kaprodi) && $acc->acc_kaprodi == 1)
                                    <span class="check-green">✔️</span>
                                    <span>{{ $acc->kd_dosen_kaprodi }} | {{ formatDatebln($acc->tgl_kaprodi) }}</span>
                                @elseif (isset($acc->acc_kaprodi_essay) && $acc->acc_kaprodi_essay == 1)
                                    <span class="check-green">✔️</span>
                                    <span>{{ $acc->kd_dosen_kaprodi }} | {{ formatDatebln($acc->tgl_kaprodi) }}</span>
                                @else
                                    <span class="check-transparent"></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>BAAK</td>
                            <td>
                              @if (isset($acc) && $acc->acc_baak == 1)
                        <span class="check-green">✔️</span>
                        <span>{{ $acc->kd_dosen_baak }} | {{ formatDatebln($acc->tgl_baak) }}</span>
                    @elseif (isset($acc) && $acc->acc_baak_essay == 1)
                        <span class="check-green">✔️</span>
                        <span>{{ $acc->kd_dosen_baak }} | {{ formatDatebln($acc->tgl_baak) }}</span>
                    @else
                        <span class="check-transparent"></span>
                    @endif

                    @can('master_soal_ujian.acc_baak') 
                        @if (empty($acc->kd_dosen_baak) && !empty($acc->kd_dosen_kaprodi))
                            @if($soal->jenis_mtk=='PG ONLINE')
                            <form action="{{ url('/baak/aprov-soal') }}" method="POST">
                              @csrf
                              <input type="hidden" name="kd_mtk" value="{{ $acc->kd_mtk }}">
                              <input type="hidden" name="paket" value="{{ $acc->paket }}">
                              <input type="hidden" name="jenis_mtk" value="{{ $soal->jenis_mtk }}">
                              <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">
                                  <i class="icon-check"></i> Persetujuan BAAK {{ $soal->jenis_mtk }}
                              </button>
                          </form>
                          
                            @elseif($soal->jenis_mtk=='ESSAY ONLINE')
                            <form action="" method="POST">
                              @csrf
                              {{-- <input type="hidden" name="kd_mtk" value="{{ $acc->kd_mtk }}">
                              <input type="hidden" name="paket" value="{{ $acc->paket }}">
                              <input type="hidden" name="jenis_mtk" value="{{ $soal->jenis_mtk }}"> --}}
                              {{-- <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">
                                  <i class="icon-check"></i> Persetujuan BAAK PG ONLINE
                              </button> --}}
                          </form>
                                <form action="{{ url('/baak/aprov-soal-essay') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kd_mtk" value="{{ $acc->kd_mtk }}">
                                    <input type="hidden" name="paket" value="{{ $acc->paket }}">
                                    <button type="submit" class="btn btn-info" onclick="return confirmSubmit()">
                                        <i class="icon-check"></i> Persetujuan BAAK {{ $soal->jenis_mtk }}
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endcan

                   <script>
function confirmSubmit() {
    return confirm('Apakah Anda yakin ingin menyetujui soal ini?');
}
</script>


                            </td>
                        </tr>
                        
                        <tr>
                          <td>Download soal</td>
                          <td>
                            @can('master_soal_ujian.acc_prodi')
                            @if($soal->jenis_mtk=='PG ONLINE')
                            <form action="{{ route('download.datapg') }}" method="POST">
                              @csrf
                                  <input type="hidden" id="kd_mtk" name="kd_mtk" value="{{ $soal->kd_mtk }}" required>

                                  <input type="hidden" id="jenis" name="jenis" value="{{ $soal->paket }}" required>
                              <button type="submit" class="btn btn-info">
                                  <i class="icon-download"></i> Download Data
                              </button>
                          </form>
                            @endif
                            @endcan
                            @if($soal->jenis_mtk=='ESSAY ONLINE')

                           <b>Belum Tersedia</b> 
                            {{-- <form action="{{ route('download.datapg') }}" method="POST">
                              @csrf
                                  <input type="hidden" id="kd_mtk" name="kd_mtk" value="{{ $soal->kd_mtk }}" required>

                                  <input type="hidden" id="jenis" name="jenis" value="{{ $soal->paket }}" required>
                              <button type="submit" class="btn btn-info">
                                  <i class="icon-download"></i> Download Data
                              </button>
                          </form> --}}
                            @endif

                          </td>
                        </tr>
                       
                      </tbody>
                    </table>
									
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
            <div class="alert-notify-title">info penerbitan soal<img src="img/notification-info.svg" alt=""></div>

              <div class="alert-notify-text">Jadwal ujian akan terbit pada halaman mahasiswa, 
              <p></p>
              Sesuai dengan KRS Ujian yang telah di cetak
              <br>
              <hr>
              <div class="alert-notify-text"><i>soal akan tayang apabila <b> STATUS=Tampil</b></i>
              
                <div class="alert-notify-text"><i>Cara agar soal Tampil</i>
                  <li>1. Ceklis soal yang akan di tampilkan</li>
                  <li>2. Kelik Persetujian Kaprodi</li>
            </div>
          </div>
        </div>
      </div>

      <style>
        .check-green {
            color: #008000; /* Warna hijau */
        }
    
        .check-blue {
            color: #0000FF; /* Warna biru */
        }
    </style>
         
       