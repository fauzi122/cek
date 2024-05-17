@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <!-- Page header start -->
    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="content-wrapper">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card-header badge-info">
                    <h4 class="m-b-0 text-white">Komplen Soal</h4>
                </div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table id="halaman-komplain" class="table custom-table">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <!-- <th>Nama</th> -->
                                    <th>Kode MTK</th>
                                    <th>Paket</th>
                                    <th>Kel-Ujian</th>
                                    <th>Alasan</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Pastikan variable $jadwals di-pass dari controller dengan data yang sesuai --}}
                                @foreach ($komplainSoal as $soal)
                                <tr>
                                    <td>{{ $soal->nim }}</td>
                                    <td>{{ $soal->kd_mtk }}</td>
                                    <td>{{ $soal->paket }}</td>
                                    <td>{{ $soal->kel_ujian }}</td>
                                    <td>{{ $soal->alasan }}</td>
                                    <td>
                                        <button class="downloadButton" data-url="{{$soal->bukti}}" data-id="{{$soal->nim.$soal->kd_mtk.$soal->paket}}">Download PDF</button>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- Content wrapper end -->
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#halaman-komplain').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'Show All']
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            responsive: true
        });
    });
</script>
<script>
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('downloadButton')) {
            const apiUrl = 'https://ujiankampusa.bsi.ac.id/api/bukti-soal/' + e.target.getAttribute('data-url');
            const user = e.target.getAttribute('data-id');

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 404) {
                            throw new Error('File not found (404)');
                        }
                        throw new Error('Network response was not ok. Status: ' + response.status);
                    }
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'bukti-soal' + user + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                })
                .catch(err => {
                    console.error('Error downloading the file:', err);
                    alert('Error: ' + err.message);
                });
        }
    });
</script>
@endpush