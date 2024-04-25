
            {{--  informasi  --}}
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">

                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
                    <div class="card-header badge-primary">
            <h4 class="m-b-0 text-white">Informasi
              <a onclick="goBack()" class="btn btn-sm btn-success">
                <i class="icon-refresh"></i> Kembali
              </a>
              
              <script>
              function goBack() {
                window.history.back();
              }
              </script>
              
            </h4>
        </div>
        <div class="table-responsive">
          <table class="table table-condensed table-bordered table-hover">                
            <tbody>
                <tr>
                    <td width="100px">Paket Ujian</td>
                    <td>{{ $soal->paket ?? 'Data tidak tersedia' }}</td>
                </tr>
                <tr>
                    <td width="100px">Nama MTK</td>
                    <td>{{ $soal->nm_mtk ?? 'Data tidak tersedia' }}</td>
                </tr>
                <tr style="font-weight: 600; color: #e61111;">
                    <td>Kode MTK</td>
                    <td>{{ $soal->kd_mtk ?? 'Data tidak tersedia' }}</td>
                </tr>

                <tr style="font-weight: 600; color: #e61111;">
                  <td>Status Kirim</td>
                  <td>

                    @if(isset($acc->perakit_kirim) && $acc->perakit_kirim == 1)
                    <span class="check-green">✔️</span>
                    <span>{{ $acc->kd_dosen_perakit }} | {{ formatDatebln($acc->tgl_perakit) }}</span>
                @elseif (isset($acc->perakit_kirim_essay) && $acc->perakit_kirim_essay == 1)
                    <span class="check-green">✔️</span>
                    <span>{{ $acc->kd_dosen_perakit }} | {{ formatDatebln($acc->tgl_perakit) }}</span>
                @else
                    <span class="check-transparent">Anda Belum Mengirim soal</span>
                @endif
                  </td>
              </tr>
                <tr>
                  <td>Download Soal</td>
                  <td> @if($soal->jenis_mtk=='PG ONLINE')
                    <form action="{{ route('download.datapg.dosen') }}" method="POST">
                      @csrf
                          <input type="hidden" id="kd_mtk" name="kd_mtk" value="{{ $soal->kd_mtk }}" required>

                          <input type="hidden" id="jenis" name="jenis" value="{{ $soal->paket }}" required>
                      <button type="submit" class="btn btn-info">
                          <i class="icon-download"></i> Download Data
                      </button>
                  </form>
                    @endif</td>
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
<div class="alert-notify-text">Soal ujian akan terbit di halaman prodi dan akan di lakukan penyeleksian 
  <p></p>
  {{--  pada saat mahasiswa   --}}
</div>
</div>
</div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
<div class="alert-notify info">
<div class="alert-notify-body">
<span class="type">Info</span>
<div class="alert-notify-title">info kirim semua soal<img src="img/notification-info.svg" alt=""></div>
<div class="alert-notify-text">pastikan soal yang dirakit sudah sesuai dan tidak ada kesalahan,sebelum di kirim permanen ke kaprodi
  <p></p>
  {{--  pada saat mahasiswa   --}}
</div>
</div>
</div>
</div>