@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
    <!-- Flash Messages for Adding and Errors -->
    <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
    <div class="flash-error" data-flasherror="{{ session('error') }}"></div>

    <!-- Main Content Row -->
    <div class="row gutte">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <!-- Card Header -->
            <div class="card-header badge-success">
                <h4 class="m-b-0 text-white">List Matakuliah Ujian</h4>
            </div>
            
            <!-- Table Container -->
            <div class="table-container">
                <div class="">
                    <h4></h4>
                    <hr>
                </div>

                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table id="copy-print-csv" class="table custom-table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Matakuliah</th>
                            <th>Paket</th>
                            <th>Jenis</th>
                            <th>Kode Dosen</th>
                            <th>Soal PG</th>
                            <th>Soal ESSAY</th>
                            <th>Jml PG</th>
                            <th>Jml ESSAY</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                          @forelse ($soals as $soal)
                              @php
                                  $id = Crypt::encryptString($soal->kd_mtk.','.$soal->paket.','.$soal->nm_mtk);
                              @endphp
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>
                                      <strong>{{ $soal->kd_mtk }}</strong> - 
                                      {{ $soal->nm_mtk }}
                                  </td>
                                  <td>{{ $soal->paket }}</td>
                                  <td>{{ $soal->jenis_mtk }}</td>
                                  <td>{{ $soal->kd_dosen }}</td>
                                  <td>{{ $detailsoal[$soal->kd_mtk] ?? '0' }} SOAL PG</td>
                                  <td>{{ $detailsoal_essay[$soal->kd_mtk] ?? '0' }} SOAL ESSAY</td>
                                  <td>{{ $soal->jml_soal }} soal</td>
                                  <td>{{ $soal->jml_essay }} soal</td>
                                  <td>
                                      <a href="/uts-soal-show/{{ $id }}" class="btn btn-success btn-sm">Lihat Soal</a>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="10" class="text-center">Tidak ada data</td>
                              </tr>
                          @endforelse
                      </tbody>
                    </table>
                    <div class="notes-section mb-4">
                      <h5>Catatan Penting:</h5>
                      <ul>
                          <li>Master Soal: Menu ini untuk merakit soal.</li>
                          <li>Soal PG: Jumlah soal pilihan ganda yang sudah tersedia pada bank soal sesuai dengan matakuliah.</li>
                          <li>Soal ESSAY: Jumlah soal essay yang sudah tersedia pada bank soal sesuai dengan matakuliah.</li>
                          <li>Jml PG: Jumlah soal pilihan ganda yang akan ditampilkan pada halaman ujian mahasiswa.</li>
                          <li>Jml ESSAY: Jumlah soal essay yang akan ditampilkan pada halaman ujian mahasiswa.</li>
                      </ul>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content Row -->

  
@endsection
