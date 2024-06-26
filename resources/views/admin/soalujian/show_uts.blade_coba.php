@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
<div class="row gutters">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card-header badge-info">
            <h4 class="m-b-0 text-white">Perakit Soal {{ Auth::user()->name }} - {{ Auth::user()->kode }}</h4>

  </h4>
</div>
        <div class="nav-tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <i class="icon-new_releases"></i> Master Soal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="home1-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home1" aria-selected="false">
                        <i class="icon-new_releases"></i> Informasi Matakuliah
                    </a>
                </li>
            </ul>
                @php
                $id=Crypt::encryptString($soal->kd_mtk.','.$soal->paket.','.Auth::user()->kode);
                $kirim =Crypt::encryptString ($soal->kd_mtk.','.$soal->paket.','.Auth::user()->kode);                                    
                @endphp

{{-- <table class="table table-condensed table-bordered table-hover">                
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
</table>	 --}}
                {{-- @include('admin.soalujian.info') --}}
            <div class="tab-content" id="myTabContent">
               
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="table-responsive">
                        {{-- pilihan ganda --}}
                        @if($soal->jenis_mtk=='PG ONLINE')
                          @include('admin.soalujian.form.table_pg') 
                        @endif

                        {{-- pilihan essay --}}
                        @if($soal->jenis_mtk=='ESSAY ONLINE')
                        @include('admin.soalujian.form.table_essay') 
                        @endif

                      </div>
                </div>
                <div class="tab-pane fade" id="home1" role="tabpanel" aria-labelledby="home1-tab">
                    <!-- Konten untuk tab kedua dapat ditambahkan di sini -->
                    @include('admin.soalujian.info')
                    
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
