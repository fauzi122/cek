@extends('layouts.dosen.ujian.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Hasil Pencarian Data</h4>
                        </div>
                       
                        
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
                                                        <th>kd</th>
                                                        <th>NIP</th>
                                                        <th>kd</th>
                                                        <th>nm_MTK</th>
                                                        <th>Kelas</th>
                                                        <th>Kel-Ujian</th>
                                                        <th>Hari</th>
                                                        <th>tgl</th>
                                                        <th>Mulai</th>
                                                        <th>Selsai</th>
                                                        <th>Ruang</th>
                                                        <th>paket</th>
                                                        <th>sks</th>
                                                        <th>kampus</th>
                                                        
                                                        <th>ket</th>
                                                        <th>Aksi</th>
                                                        <th><span class="icon-edit1"></span></th>

                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jadwal as $no => $jadwal)
											<tr>
											
											 <td>
												{{ $jadwal->kd_dosen }}
												
											 </td>
											 <td>{{ $jadwal->nip }}</td>
											 <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->nm_mtk }}</td>
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->hari_t }}</td>
											 <td>{{ $jadwal->tgl_ujian }}</td>
											 <td>{{ $jadwal->mulai }}</td>
											 <td>{{ $jadwal->selesai }}</td>
											
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->sks }}</td>
											 <td>{{ $jadwal->nm_kampus }}</td>
											 <td>
												@if(is_null($jadwal->petugas_edit)|| $jadwal->petugas_edit === '')
												
												@else
												di ubah {{ $jadwal->petugas_edit }}
												@endif
												</td>
											 <td>
						@php
						$id=Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket.','.$jadwal->nm_kampus);                                    
						@endphp

												{{-- <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">show</a> --}}
												@php
													$key = $jadwal->kd_dosen . '_' . $jadwal->kel_ujian . '_' . $jadwal->kd_mtk;
												@endphp
{{-- 
												@if(array_key_exists($key, $resultArray))
													<!-- Jika ada data yang cocok di resultArray, aktifkan tombol Show -->
													<a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-sm btn-info">Show</a>
												@else
													<!-- Jika tidak, nonaktifkan tombol Show -->
													<button class="btn btn-sm btn-custom btn-info" disabled>Show</button>
												@endif --}}
											</td>
											<td>

												<a href="/edit/jadwal-ujian/{{ $id }}" class="btn btn-sm btn-primary">Edit</a>
												

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
