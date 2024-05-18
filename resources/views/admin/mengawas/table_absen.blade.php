<style>
    .essay-text.text-collapsed {
        overflow: hidden;
        height: 40px;
        /* Sesuaikan dengan ketinggian dua baris */
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
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
                    @php
                        $sekarang = now();
                    @endphp
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Kel-Ujian</th>

                                    {{-- cek bap dan tutup bap --}}
                                    @if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
                                    @if ($setting && $sekarang->between($setting->mulai, $setting->selsai))
                                    <th>Komentar</th>
                                    <th>Status Hadir</th>
                                    @endif
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

                                {{-- cek bap dan tgl tutup bap --}}
                                @if($beritaAcara && is_null($beritaAcara->field_yang_diperiksa))
                                @if ($setting && $sekarang->between($setting->mulai, $setting->selsai))
                                    <td>

                                        {{-- {{ $item->id }} --}}
                                        <select name="ket" class="custom-select ket-dropdown" data-id="{{ $item->id }}">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="koneksi server gagal" {{ $item->ket == 'koneksi server gagal' ? 'selected' : '' }}>Koneksi Server Gagal</option>
                                            <option value="jaringan loading terus" {{ $item->ket == 'jaringan loading terus' ? 'selected' : '' }}>Jaringan Loading Terus</option>
                                            <option value="jaringan putus saat mengerjakan soal" {{ $item->ket == 'jaringan putus saat mengerjakan soal' ? 'selected' : '' }}>Jaringan Putus saat Mengerjakan Soal</option>
                                            <option value="soal ujian selalu berulang" {{ $item->ket == 'soal ujian selalu berulang' ? 'selected' : '' }}>Soal Ujian Selalu Berulang</option>
                                            <option value="mati lampu" {{ $item->ket == 'mati lampu' ? 'selected' : '' }}>Mati Lampu</option>
                                            <option value="laptop bermasalah" {{ $item->ket == 'laptop bermasalah' ? 'selected' : '' }}>Laptop Bermasalah</option>
                                            <option value="mahasiswa tidak bisa koneksi wifi" {{ $item->ket == 'mahasiswa tidak bisa koneksi wifi' ? 'selected' : '' }}>Mahasiswa Tidak Bisa Koneksi WiFi</option>
                                            <option value="nilai tidak diproses diluar kelas" {{ $item->ket == 'nilai tidak diproses diluar kelas' ? 'selected' : '' }}>Nilai Tidak Diproses (Mahasiswa Mengerjakan di Luar Kelas)</option>
                                            <option value="nilai tidak diproses menyontek" {{ $item->ket == 'nilai tidak diproses menyontek' ? 'selected' : '' }}>Nilai Tidak Diproses (Mahasiswa Menyontek)</option>
                                            <option value="nilai tidak diproses bekerja sama" {{ $item->ket == 'nilai tidak diproses bekerja sama' ? 'selected' : '' }}>Nilai Tidak Diproses (Bekerja Sama Saat Mengerjakan Ujian)</option>
                                        </select>
                                    </td> <!-- Assuming each item has an 'id' -->
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status-checkbox" id="switch{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>

                                {{-- cek bap dan tgl tutup bap --}}
                                @endif
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
                <table id="myTable5" class="table custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>KOMENTAR</th>
                            <th>Aksi</th>
                            <th>Updated_at</th>

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
                            <td>{{ $item->ket }}</td>
                            <td>
                                @php
                                $id=Crypt::encryptString($item->nim.','.$item->no_kel_ujn.','.$item->kd_mtk.','.$item->paket);
                                @endphp

                                @if($item->isInHasilUjian)
                                <a href="/show/log-mhs/mengawas-uts/{{ $id }}}" class="btn btn-info">
                                    Log Aktivitas
                                </a>
                                {{-- <span class="badge badge-info">Sudah Mulai Ujian</span> --}}
                                @else
                                <span class="badge badge-danger">Belum Mulai Ujian</span>
                                @endif


                            </td> <!-- Assuming each item has an 'id' -->
                            <td>{{ $item->updated_at }}</td>
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Handler ketika tombol 'Nilai Essay' diklik
        $('a[data-target="#nilaiEssayModal"]').on('click', function() {
            var itemId = $(this).data('id'); // Ambil 'data-id' dari tombol yang diklik

            // AJAX call untuk mendapatkan data berdasarkan 'itemId'
            $.ajax({
                url: '/get-nilai-essay/' + itemId, // Asumsi URL endpoint untuk mengambil data
                type: 'GET',
                success: function(response) {
                    if (response && response.length > 0) {
                        populateModal(response);
                        $('#nilaiEssayModal').modal('show');
                    } else {
                        alert("Tidak ada data");
                    }
                },
                error: function(error) {
                    console.error("Error fetching data:", error);
                    alert("Gagal mengambil data: " + error.statusText);
                }
            });
        });

        // Fungsi untuk mengisi modal dengan data
        function populateModal(data) {
            var modalBody = $('#nilaiEssayModal').find('#essayDetails');
            modalBody.empty(); // Bersihkan isi sebelumnya

            data.forEach(function(item, index) {
                var content = `
                <div class="essay-item">
                    <h5>Soal:</h5>
                    <div class="essay-text">${item.soal}</div>
                    <div class="essay-text">Jawaban Mahasiswa: ${item.jawaban_mahasiswa}</div>
                    <div>
                        <label for="nilai-${index}">Nilai:</label>
                        <input type="number" id="nilai-${index}" class="form-control nilai-input" value="${item.nilai}" data-id="${item.id_jawaban}">
                    </div>
                </div>
                <hr>`;
                modalBody.append(content);
            });

            handleLongText();
        }

        // Fungsi untuk menangani teks panjang
        function handleLongText() {
            $('.essay-text').each(function() {
                var text = $(this);
                if (text.height() > 40) { // Anggap 40px sebagai ketinggian dua baris teks
                    text.addClass('text-collapsed');
                    text.after('<button class="read-more btn btn-info btn-sm">Baca Lengkap</button>');
                }
            });

            $('.read-more').click(function() {
                var text = $(this).prev('.essay-text');
                if (text.hasClass('text-collapsed')) {
                    text.removeClass('text-collapsed');
                    $(this).text('Sembunyikan');
                } else {
                    text.addClass('text-collapsed');
                    $(this).text('Baca Lengkap');
                }
            });
        }

        // Handler untuk tombol simpan
        $('#saveChanges').click(function() {
            var nilaiUpdates = [];
            $('.nilai-input').each(function() {
                nilaiUpdates.push({
                    id: $(this).data('id'),
                    nilai: $(this).val()
                });
            });

            // Kirim update ke server
            $.ajax({
                url: '/update-nilai-essay',
                type: 'POST',
                data: {
                    updates: nilaiUpdates
                },
                success: function(response) {
                    alert('Nilai berhasil diupdate');
                    $('#nilaiEssayModal').modal('hide');
                },
                error: function(error) {
                    console.error("Error updating nilai:", error);
                    alert("Gagal mengupdate nilai: " + error.statusText);
                }
            });
        });
    });
</script>
@endpush