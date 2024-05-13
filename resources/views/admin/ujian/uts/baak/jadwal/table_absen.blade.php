<div class="nav-tabs-container">
    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs" id="myTab3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home3" aria-selected="true">
                <i class="icon-edit1"></i> Rekap Hadir Mahasiswa Ujian
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile3" aria-selected="false">
                <i class="icon-download-cloud"></i> Download Rekap Hadir Mahasiswa
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent3">
        <!-- Tab Pane 1 -->
        <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    
                        <div class="table-responsive">
                            <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Kel-Ujian</th>
                                                @if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
                                                <th>Komentar</th>
                                                <th>Status Hadir</th>
                                                @endif	
                                                <th>Status Mulai Ujian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($mhsujian as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nim }}</td>
                                                    <td>{{ $item->nm_mhs }}</td>
                                                    <td>{{ $item->no_kel_ujn }}</td>

                                                    @if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
                                                    <td>

                                                        {{-- {{ $item->id }} --}}
                                                        <select disabled name="ket" class="custom-select ket-dropdown" data-id="{{ $item->id }}">
                                                            <option value="">-- Pilih Status --</option>
                                                            <option value="koneksi_server_gagal" {{ $item->ket == 'koneksi_server_gagal' ? 'selected' : '' }}>Koneksi Server Gagal</option>
                                                            <option value="jaringan_loading_terus" {{ $item->ket == 'jaringan_loading_terus' ? 'selected' : '' }}>Jaringan Loading Terus</option>
                                                            <option value="jaringan_putus_saat_mengerjakan_soal" {{ $item->ket == 'jaringan_putus_saat_mengerjakan_soal' ? 'selected' : '' }}>Jaringan Putus saat Mengerjakan Soal</option>
                                                            <option value="soal_ujian_selalu_berulang" {{ $item->ket == 'soal_ujian_selalu_berulang' ? 'selected' : '' }}>Soal Ujian Selalu Berulang</option>
                                                            <option value="mati_lampu" {{ $item->ket == 'mati_lampu' ? 'selected' : '' }}>Mati Lampu</option>
                                                            <option value="laptop_bermasalah" {{ $item->ket == 'laptop_bermasalah' ? 'selected' : '' }}>Laptop Bermasalah</option>
                                                            <option value="mahasiswa_tidak_bisa_koneksi_wifi" {{ $item->ket == 'mahasiswa_tidak_bisa_koneksi_wifi' ? 'selected' : '' }}>Mahasiswa Tidak Bisa Koneksi WiFi</option>
                                                            <option value="nilai_tidak_diproses_diluar_kelas" {{ $item->ket == 'nilai_tidak_diproses_diluar_kelas' ? 'selected' : '' }}>Nilai Tidak Diproses (Mahasiswa Mengerjakan di Luar Kelas)</option>
                                                            <option value="nilai_tidak_diproses_menyontek" {{ $item->ket == 'nilai_tidak_diproses_menyontek' ? 'selected' : '' }}>Nilai Tidak Diproses (Mahasiswa Menyontek)</option>
                                                            <option value="nilai_tidak_diproses_bekerja_sama" {{ $item->ket == 'nilai_tidak_diproses_bekerja_sama' ? 'selected' : '' }}>Nilai Tidak Diproses (Bekerja Sama Saat Mengerjakan Ujian)</option>
                                                        </select>
                                                    </td> <!-- Assuming each item has an 'id' -->                                                  
                                                    <td>  
                                                    <label class="switch">
                                                        <input disabled type="checkbox" class="status-checkbox" id="switch{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>  
                                                    </td>
                                                    @endif	
                                                    <td> 
                                                        @if($item->isInHasilUjian)
                                                        <span class="badge badge-info">Sudah Mulai Ujian</span>
                                                    @else
                                                        <span class="badge badge-danger">Belum Mulai Ujian</span>
                                                    @endif
                                                </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">No data available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                
                </div>
            </div>
        </div>

        <!-- Tab Pane 2 -->
        <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
            <div class="table-responsive">
                <table id="copy-print-csv" class="table custom-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mhsujian as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->nm_mhs }}</td>
                                    <td>
                                        @if($item->status==1)

                                        <b>Hadir</b>
                                    @else
                                        <b>Tidak Hdir</b>
                                    @endif
                                    </td>
                                    <td>
                                        @php
                                            $id=Crypt::encryptString($item->nim.','.$item->no_kel_ujn.','.$item->kd_mtk.','.$item->paket);                                    
                                            @endphp

                                        @if($item->isInHasilUjian)
                                        <a href="/show/log-mhs/mengawas-uts/{{ $id }}}" class="btn btn-info" >
                                            Log Aktivitas
                                        </a>
                                        {{-- <span class="badge badge-info">Sudah Mulai Ujian</span> --}}
                                    @else
                                        <span class="badge badge-danger">Belum Mulai Ujian</span>
                                    @endif
                                         
                                    
                                    </td> <!-- Assuming each item has an 'id' -->
                            
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>