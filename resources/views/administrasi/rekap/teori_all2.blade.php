@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
    <div class="table-container">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="alert-notify-body">
                <div class="alert-notify-title">
                    <h4>Rekap Ajar Teori ALL</h4>
                </div>
                <br>
                <h5>
                    *Catatan: kode dosen dapat dikosongkan jika pencarian hanya ingin berdasarkan tanggal saja
                </h5>
                <p>
                    <form action="/cari-rekap-teori" method="GET">
                        <table class="table custom-table">
                            <tr>
                                <td>Kode Dosen</td>
                                <td><input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen" class="nilai form-control"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>
                                    <input type="date" required name="tgl_awal" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Masukkan Tanggal Awal" class="nilai form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td>
                                    <input type="date" required name="tgl_akhir" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Masukkan Tanggal Akhir" class="nilai form-control">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;">
                                    <button type="submit" class="btn btn-info">Cari Data Rekap</button><br>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="card-body">
                    <form action="/rekap/teori-all" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="q" placeholder="cari berdasarkan kode dosen">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10%">NIP</th>
                                    <th scope="col">kd</th>
                                    <th scope="col">KELAS</th>
                                    <th scope="col">SKS</th>
                                    <th scope="col">Kode MTK</th>
                                    <th scope="col">TANGGAL</th>
                                    <th scope="col">HARI</th>
                                    <th scope="col">JAM MASUK</th>
                                    <th scope="col">JAM KELUAR</th>
                                    <th scope="col">NO RUANG</th>
                                    <th scope="col">PERTEMUAN</th>
                                    <th scope="col">sts_ajar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapajarall as $no => $role)
                                <tr>
                                    <td>{{ $role->nip }}</td>
                                    <td>{{ $role->kd_dosen }}</td>
                                    <td>{{ $role->kd_lokal }}</td>
                                    <td>{{ $role->sks }}</td>
                                    <td>{{ $role->nm_mtk }} - <b>{{ $role->kd_mtk }}</b></td>
                                    <td>{{ $role->tgl_ajar_masuk }}</td>
                                    <td>{{ $role->hari_ajar_masuk }}</td>
                                    <td><h5>{{ $role->jam_masuk }}</h5></td>
                                    <td><h5>{{ $role->jam_keluar }}</h5></td>
                                    <td>{{ $role->no_ruang }}</td>
                                    <td>{{ $role->pertemuan }}</td>
                                    <td>{{ $role->sts_ajar }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$rekapajarall->links("vendor.pagination.bootstrap-4")}}
                        </div>
                        <br>
                        <h3>Catatan (STS AJAR):</h3>
                        <p>KP = Kelas Pengganti</p>
                        <p>M = Input Manual</p>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <p>a</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

