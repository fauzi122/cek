@extends('layouts.dosen.main')
@section('content')

<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                @if (isset($_POST['kirim']))
                <form action="{{ url('/update-pengganti-teori') }}" method="POST">
                    @else
                    <form action="{{ url('/tambah-dosen-pengganti') }}" method="POST">
                        @endif
                        @csrf
                        <div class="row gutters">
                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="matkul">Matakuliah.</label>
                                    <input type="text" class="form-control" id="matkul" placeholder="Matakuliah" name="matkul" value="{{$jadwal->nm_mtk}}" readonly>
                                    <input type="hidden" name="id" id="id" value="{{$id}}">
                                    <input type="hidden" name="kd_dosen" value="{{$jadwal->kd_dosen}}">
                                </div>
                            </div>
                            <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="kd_mtk">Kode MTK</label>
                                    <input type="email" class="form-control" id="kd_mtk" placeholder="Kode MTK" name="kd_mtk" value="{{$jadwal->kd_mtk}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="sks">SKS</label>
                                    <input type="text" class="form-control" id="sks" placeholder="SKS" name="sks" value="{{$jadwal->sksajar}}" readonly>
                                </div>

                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="kd_dosen">Kode Dosen</label>
                                    <input class="form-control" id="kd_dosen" type="text" placeholder="kd_dosen" value="{{$jadwal->kd_dosen}}" name="kd_dosen" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input class="form-control" id="kelas" type="text" placeholder="Kelas" value="{{$jadwal->kd_gabung? $jadwal->kd_gabung:($jadwal->kel_praktek?$jadwal->kel_praktek:$jadwal->kd_lokal)}}" name="kelas" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="tgl_pengganti">Tanggal Pengganti</label>
                                    <input class="form-control" id="tgl_pengganti" type="date" name="tgl_pengganti" required>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="jam_t">Jam</label>
                                    <input class="form-control" id="jam_t" type="input" name="jam_t" value="{{$jadwal->jam_t}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="hari_t">Hari</label>
                                    <input class="form-control" id="hari_t" type="input" name="hari_t" value="{{$jadwal->hari_t}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="ruang">Ruangan</label>
                                    <input class="form-control" id="ruang" type="text" name="ruang" value="{{$jadwal->no_ruang}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="kampus">Kampus</label>
                                    <input class="form-control" id="kampus" type="text" placeholder="Kampus" value="{{$jadwal->nm_kampus}}" name="kampus" readonly>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    {{-- <select class="form-control" data-live-search="true" id="dosen_pengganti" name="dosen_pengganti">
                             @foreach ($dosen as $d )
                            <option value="{{$d->kd_dosen}}">{{ $d->kd_dosen }} - {{ $d->nm_dosen }}</b></option>
                                    @endforeach
                                    </select> --}}
                                    <select style="width:200px;" class="select2-selection select2-selection--single" name="dosen_pengganti" id="dosen_pengganti"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Alasan Mengganti</span>
                                        </div>
                                        <textarea name="alasan" id="alasan" placeholder="Masukan alasan anda untuk pengajuan pengganti" required>@if(isset($jadwal->alasan)){{$jadwal->alasan}}</textarea>@else</textarea>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (isset($_POST['kirim']))
                        <button type="submit" class="btn btn-primary btn-lg"><i class="icon-send1"></i> Update</button>
                        @else
                        <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save"></i> Simpan</button>
                        @endif
                    </form>

                    <div class="card-body">
                        <div class="custom-btn-group">
                            <div class="table-responsive">
                                <table id="myTable" class="table custom-table m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode MTK</th>
                                            <th>Kode Dosen</th>
                                            <th>Kelas</th>
                                            <th>Waktu</th>
                                            <th>Ruang</th>
                                            <th>Dosen Pengganti</th>
                                            <th>Tanggal Pengganti</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>
    {{-- Pemisah --}}



    @endsection
    @push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var id = $("#id").val();
            var kd_mtk = $("#kd_mtk").val();
            var kelas = $("#kelas").val();
            var hari_t = $("#hari_t").val();
            var jam_t = $("#jam_t").val();
            var ruang = $("#ruang").val();
            var kd_dosen = $("#kd_dosen").val();
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-dp",
                    type: "get",
                    data: {
                        id: id,
                        kd_mtk: kd_mtk,
                        kelas: kelas,
                        hari_t: hari_t,
                        jam_t: jam_t,
                        ruang: ruang,
                        kd_dosen: kd_dosen
                    }
                },
                dom: 'Blfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                responsive: true,
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "kd_mtk",
                        name: "kd_mtk"
                    },
                    {
                        data: "kd_dosen",
                        name: "kd_dosen"
                    },
                    {
                        data: "kd_lokal",
                        name: "kd_lokal"
                    },
                    {
                        data: "jam_t",
                        name: "jam_t"
                    },
                    {
                        data: "no_ruang",
                        name: "no_ruang"
                    },
                    {
                        data: "kd_dp",
                        name: "kd_dp"
                    },
                    {
                        data: "tgl_ganti",
                        name: "tgl_ganti"
                    },
                    {
                        data: "ket",
                        name: "ket"
                    },
                    {
                        data: "aksi",
                        name: "aksi"
                    },
                ]

            });

            $("#dosen_pengganti").select2({
                placeholder: 'Cari Dengan Kode Dosen',
                ajax: {
                    url: '{!! route("jadwal.index") !!}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                if (item.kode != null) {
                                    return {
                                        text: item.kode + ' (' + item.username + ')',
                                        id: item.kode
                                    }
                                }
                            })
                        };
                    },
                    cache: true
                }

            });
        });
    </script>
    @endpush