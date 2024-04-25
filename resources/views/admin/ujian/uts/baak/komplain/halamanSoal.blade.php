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
                    <h4 class="m-b-0 text-white">List Pengawas Pengganti</h4>
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
                                        {{-- Asumsi $soal->bukti menyimpan nama file gambar --}}
                                        <img src="{{ asset('storage/bukti/' . $soal->bukti) }}" alt="bukti" width="100"> {{-- Sesuaikan path dan atribut sesuai kebutuhan --}}
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
@endpush