@extends('layouts.dosen.ujian.main')

@section('content')
    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row starts -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    
                    <div class="card-body">
                        <!-- Row starts for charts -->
                        <div class="row">
                            <div class="col-md-6">
                                <div style="width: 100%; margin: auto;">
                                    <canvas id="utsChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="width: 100%; margin: auto;">
                                    <canvas id="uasChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Row ends for charts -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

        <!-- Row starts -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card h-350">
                    <div class="card-header">
                        <div class="card-title">Jadwal Ujian Semua Kampus</div>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <div class="t-header">Jadwal Ujian</div>
                            <div class="table-responsive">
                                <table id="copy-print-csv" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>NIP</th>
                                            <th>kd</th>
                                            <th>NM_Matakuliah</th>
                                            <th>kd MTK</th>
                                            <th>Kelas</th>
                                            <th>Hari</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Ruang</th>
                                            <th>Paket</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwal as $no => $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->nip }}</td>
                                            <td>{{ $jadwal->kd_dosen }}</td>
                                            <td>{{ $jadwal->nm_mtk }}</td>
                                            <td>{{ $jadwal->kd_mtk }}</td>
                                            <td>{{ $jadwal->kd_lokal }}</td>
                                            <td>{{ $jadwal->hari_t }}</td>
                                            <td>{{ $jadwal->mulai }}</td>
                                            <td>{{ $jadwal->selesai }}</td>
                                            <td>{{ $jadwal->no_ruang }}</td>
                                            <td>{{ $jadwal->paket }}</td>
                                            <td>{{ $jadwal->tgl_ujian }}</td>
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
        <!-- Row ends -->

    </div>
    <!-- Content wrapper end -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const utsData = @json($utsData);
        const uasData = @json($uasData);

        const utsLabels = utsData.map(data => data.tgl_ujian);
        const utsCounts = utsData.map(data => data.jumlah);

        const uasLabels = uasData.map(data => data.tgl_ujian);
        const uasCounts = uasData.map(data => data.jumlah);

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        const utsColors = utsLabels.map(() => getRandomColor());
        const uasColors = uasLabels.map(() => getRandomColor());

        var ctxUts = document.getElementById('utsChart').getContext('2d');
        var utsChart = new Chart(ctxUts, {
            type: 'bar',
            data: {
                labels: utsLabels,
                datasets: [{
                    label: 'Jumlah Soal UTS',
                    data: utsCounts,
                    backgroundColor: utsColors,
                    borderColor: utsColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Soal UTS per Tanggal'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxUas = document.getElementById('uasChart').getContext('2d');
        var uasChart = new Chart(ctxUas, {
            type: 'bar',
            data: {
                labels: uasLabels,
                datasets: [{
                    label: 'Jumlah Soal UAS',
                    data: uasCounts,
                    backgroundColor: uasColors,
                    borderColor: uasColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Soal UAS per Tanggal'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
