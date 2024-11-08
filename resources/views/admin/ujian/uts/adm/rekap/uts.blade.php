@extends('layouts.dosen.ujian.main')

@section('content')
    <style>
        /* CSS untuk memperkecil tabel */
        .custom-table th, .custom-table td {
            font-size: 12px; /* Ukuran font lebih kecil */
            padding: 5px; /* Padding lebih kecil */
        }
        
        /* Agar tabel bisa discroll jika terlalu lebar */
        .table-responsive {
            overflow-x: auto;
        }

        /* Mengatur lebar kolom agar lebih pas */
        .custom-table th, .custom-table td {
            white-space: nowrap; /* Mencegah teks terpotong ke baris berikutnya */
        }
    </style>

    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <span class="type">Info</span>
                        <div class="alert-notify">
                            <div class="alert-notify-title">
                                <h4>Rekap Mengawas Ujian</h4>
                            </div>
                            <div class="alert-notify-info">
                                <p class="info-item">
                                    {{-- <strong>INFO:</strong> Batas Akhir Perubahan BAP dan Absen sampai tanggal <strong>19 Mei 2024</strong> jam <strong>12:00 WIB</strong> --}}
                                </p>
                                <p class="info-item">
                                    {{-- <strong>INFO:</strong> Batas Akhir Perubahan Status dari Panitia sampai tanggal <strong>19 Mei 2024</strong> jam <strong>17:00 WIB</strong> --}}
                                </p>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-info">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-info">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table id="copy-print-csv" class="table custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>NIP</th>
                                                        <th>kd</th>
                                                        <th>NM MTK</th>
                                                        <th>MTK</th>
                                                        <th>Kelas</th>
                                                        <th>Kel-Ujian</th>
                                                        <th>Hari</th>
                                                        <th>tgl ujian</th>
                                                       
                                                        <th>Mulai</th>
                                                        <th>Selesai</th>
                                                        <th>Ruang</th>
                                                        <th>paket</th>
                                                        <th>Kampus</th>
                                                        <th><span class="icon-edit1" title="petugas ganti pengawas"></span></th>
                                                        <th>status</th>
                                                        <th>ot</th>
                                                        <th>Aksi</th>
                                                        <th><span class="icon-edit1"></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jadwal as $no => $jadwal)
                                                        <tr>
                                                            <td>{{ $jadwal->nip }}</td>
                                                            <td>{{ $jadwal->kd_dosen }}</td>
                                                            <td>{{ $jadwal->nm_mtk }}</td>
                                                            <td>{{ "\u{200B}" . str_pad($jadwal->kd_mtk, 4, '0', STR_PAD_LEFT) }}</td>
                                                            <td>{{ $jadwal->kd_lokal }}</td>
                                                            <td>{{ $jadwal->kel_ujian }}</td>
                                                            <td>{{ $jadwal->hari_t }}</td>
                                                            <td><center>{{ $jadwal->tgl_ujian }} 
                                                               
                                                                </center>
                                                                </td>
                                                            
                                                            <td>{{ $jadwal->mulai }}</td>
                                                            <td>{{ $jadwal->selesai }}</td>
                                                            <td>{{ $jadwal->no_ruang }}</td>
                                                            <td>{{ $jadwal->paket }}</td>
                                                            <td>{{ $jadwal->nm_kampus }}</td>
                                                            <td><b>{{ $jadwal->petugas_edit_pengawas }}</b></td>
                                                            <td>
                                                                @php
                                                                    $key = $jadwal->kd_dosen . '_' . $jadwal->kel_ujian . '_' . $jadwal->kd_mtk . '_' . $jadwal->paket;
                                                                    $verifikasi = $resultArray[$key]->verifikasi ?? 0;
                                                                @endphp

                                                                @if($verifikasi == 1)
                                                                    <span title="Ujian Lancar" style="font-size: 12px;">✔️</span>
                                                                @elseif($verifikasi == 2)
                                                                    <span title="Ujian Bermasalah" style="font-size: 12px;">❌</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $ot = $resultArray[$key]->ot ?? 0;
                                                                @endphp
                                                                @if($ot == 1)
                                                                    <span title="Ujian Lancar" style="font-size: 12px;">YA</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $id = Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket.','.$jadwal->nm_kampus);
                                                                @endphp
                                                                @if(array_key_exists($key, $resultArray))
                                                                    <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">Show</a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(!array_key_exists($key, $resultArray))
                                                                    <a href="/ganti-pengawas/{{ $id }}" class="btn btn-xs btn-secondary" title="ganti pengawas">Pengawas</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
        </div>
    </div>
@endsection
