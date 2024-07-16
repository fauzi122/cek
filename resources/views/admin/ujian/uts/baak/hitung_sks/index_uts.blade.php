@extends('layouts.dosen.ujian.main')

@section('content')
    <div class="main-container">
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card-header badge-info">
                        <h4 class="m-b-0 text-white">Rekapitulasi SKS Mengawas Ujian UTS</h4>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>KD Dosen</th>
                                        <th>Dept</th>
                                        <th>OT</th>
                                        <th>Total SKS</th>
                                        <th>Jumlah Temu</th>
                                        @if (!empty($dynamicColumns))
                                            @foreach ($dynamicColumns as $column)
                                                @if (!in_array($column, ['kd_dosen', 'nip', 'nama', 'dept', 'ot', 'total_sks', 'jumlah_temu']))
                                                    <th>{{ $column }}</th>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $result)
                                        <tr>
                                            <td>{{ $result->nip }}</td>
                                            <td>{{ $result->nama }}</td>
                                            <td>
                                                <a href="#">
                                                    {{ $result->kd_dosen }}
                                                </a>
                                            </td>
                                            <td>{{ $result->dept }}</td>
                                            <td>{{ $result->ot }}</td>
                                            <td>{{ $result->total_sks }}</td>
                                            <td>{{ $result->jumlah_temu }}</td>
                                            @foreach ($dynamicColumns as $column)
                                                @if (!in_array($column, ['kd_dosen', 'nip', 'nama', 'dept', 'ot', 'total_sks', 'jumlah_temu']))
                                                    <td>{{ $result->$column }}</td>
                                                @endif
                                            @endforeach
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
