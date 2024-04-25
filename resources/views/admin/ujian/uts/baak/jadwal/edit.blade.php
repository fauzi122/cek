
@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                
                <div class="card-header badge-info">
                
                    <h4 class="m-b-0 text-white">

                       Edit Jadwal Ujian - {{ $jadwal->paket }}</h4>
                </div>

                <div class="table-container">
                    @php
						$id=Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket);                                    
						@endphp
                      
                    <form method="POST" action="/update/jadwal-ujian/{{ $id }}">
                        @csrf
                        @method('PUT')
                        <table class="table table-borderless">
                            <!-- Dynamically create form fields for each database column -->
                            <tr>
                                <td>NIP:</td>
                                <td><input type="text" name="nip" class="form-control" value="{{ old('nip', $jadwal->nip) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Kode Dosen:</td>
                                <td><input type="text" name="kd_dosen" class="form-control" value="{{ old('kd_dosen', $jadwal->kd_dosen) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Kode Lokal:</td>
                                <td><input type="text" name="kd_lokal" class="form-control" value="{{ old('kd_lokal', $jadwal->kd_lokal) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Hari:</td>
                                <td><input type="text" name="hari_t" class="form-control" value="{{ old('hari_t', $jadwal->hari_t) }}"required></td>
                            </tr>
                            <tr>
                                <td>Nomor Ruang:</td>
                                <td><input type="text" name="no_ruang" class="form-control" value="{{ old('no_ruang', $jadwal->no_ruang) }}"required></td>
                            </tr>
                            <tr>
                                <td>Nama Mata Kuliah:</td>
                                <td><input type="text" name="nm_mtk" class="form-control" value="{{ old('nm_mtk', $jadwal->nm_mtk) }}"required readonly ></td>
                            </tr>
                            <tr>
                                <td>Kode Mata Kuliah:</td>
                                <td><input type="text" name="kd_mtk" class="form-control" value="{{ old('kd_mtk', $jadwal->kd_mtk) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>SKS:</td>
                                <td><input type="number" name="sks" class="form-control" value="{{ old('sks', $jadwal->sks) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Jam:</td>
                                <td><input type="text" name="jam_t" class="form-control" value="{{ old('jam_t', $jadwal->jam_t) }}"required></td>
                            </tr>
                            <tr>
                                <td>Mulai:</td>
                                <td><input type="time" name="mulai" class="form-control" value="{{ old('mulai', $jadwal->mulai) }}"required></td>
                            </tr>
                            <tr>
                                <td>Selesai:</td>
                                <td><input type="time" name="selesai" class="form-control" value="{{ old('selesai', $jadwal->selesai) }}"required></td>
                            </tr>
                            <tr>
                                <td>Tanggal Ujian:</td>
                                <td><input type="date" name="tgl_ujian" class="form-control" value="{{ old('tgl_ujian', $jadwal->tgl_ujian) }}"required></td>
                            </tr>
                            <tr>
                                <td>Nama Kampus:</td>
                                <td><input type="text" name="nm_kampus" class="form-control" value="{{ old('nm_kampus', $jadwal->nm_kampus) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Paket:</td>
                                <td><input type="text" name="paket" class="form-control" value="{{ old('paket', $jadwal->paket) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Waktu:</td>
                                <td><input type="text" name="waktu" class="form-control" value="{{ old('waktu', $jadwal->waktu) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Jumlah Soal:</td>
                                <td><input type="number" name="jml_soal" class="form-control" value="{{ old('jml_soal', $jadwal->jml_soal) }}"required readonly></td>
                            </tr>
                            <tr>
                                <td>Jumlah Soal Essay:</td>
                                <td><input type="number" name="jml_soal_essay" class="form-control" value="{{ old('jml_soal_essay', $jadwal->jml_soal_essay) }}"required readonly></td>
                            </tr>
                            {{-- <tr>
                                <td>Tampil:</td>
                                <td><input type="checkbox" name="tampil" class="form-check-input" {{ $jadwal->tampil ? 'checked' : '' }}></td>
                            </tr> --}}
                            <tr>
                                <td>Kelompok Ujian:</td>
                                <td><input type="text" name="kel_ujian" class="form-control" value="{{ old('kel_ujian', $jadwal->kel_ujian) }}"required readonly></td>
                            </tr>
                           
                            <!-- Optional: created_at and updated_at fields can be displayed but generally are not editable -->
                            <tr>
                                <td colspan="2" class="text-right">
                                    <button type="submit" class="btn btn-info">Update</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
