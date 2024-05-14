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
                <i class="icon-edit1"></i> Rekap Nilai Ujian Essay Online
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
                        <table id="myTable5" class="table custom-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Nilai</th>
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
                                    <td>
                                        @if(isset($item->isInJawabEssay) && isset($item->isInJawabEssay->score))
                                            {{$item->isInJawabEssay->score}}
                                        @else
                                            <b>0</b>
                                        @endif
                                       
                                    </td>
                                    <td>
                                        @php
                                        $id=Crypt::encryptString($item->nim.','.$item->no_kel_ujn.','.$item->kd_mtk.','.$item->paket);
                                        @endphp
                                        @if($item->isInHasilUjian<>false)
                                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#nilaiEssayModal" data-id="{{ $id }}">
                                                Nilai Essay
                                            </a>
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

                    </div>

                </div>
            </div>
        </div>


    </div>
</div>
<!-- Nilai Essay Modal -->
<!-- Nilai Essay Modal -->
<div class="modal fade" id="nilaiEssayModal" tabindex="-1" role="dialog" aria-labelledby="nilaiEssayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Perubahan ukuran modal ke modal-xl -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nilaiEssayModalLabel">Detail Jawaban Mahasiswa</h5>
                <br>
                <p></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="essayDetails"></div> <!-- Container untuk menampilkan detail essay -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Simpan Perubahan</button>
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