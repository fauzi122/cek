@extends('layouts.dosen.main')
@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
            @if (isset($_POST['kirim']))
            <form action="{{ url('/update-pengganti-teori') }}" method="POST">  
                @else
                <form action="{{ url('/simpan-pengganti-teori') }}" method="POST">
            @endif
                @csrf
                <div class="row gutters">
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="matkul">Matakuliah</label>
                            <input type="text" class="form-control" id="matkul" placeholder="Matakuliah" name="matkul" value="{{$jadwal->nm_mtk}}" readonly>
                            <input type="hidden" name="no_j_klh" value="{{$jadwal->no_j_klh}}">
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
                            <input type="text" class="form-control" id="sks" placeholder="SKS" name="sks" value="@if(isset($jadwal->sksajar)){{$jadwal->sksajar}}@else{{$jadwal->sks}}@endif" readonly>
                        </div>
                        
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kampus">Kampus</label>
                            <input class="form-control" id="kampus" type="text" placeholder="Kampus" value="{{$jadwal->nm_kampus}}" name="kampus" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input class="form-control" id="kelas" type="text" placeholder="Kelas" value="{{$jadwal->kd_lokal}}" name="kelas" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="tgl_sebelum">Tanggal Digantikan</label>
                            <input class="form-control" id="tgl_sebelum" type="date" name="tgl_sebelum" value="@if(isset($jadwal->tgl_yg_digantikan)){{$jadwal->tgl_yg_digantikan}}@else @endif" required>
                           
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="tgl_pengganti">Tanggal Pengganti</label>
                            <input class="form-control" id="tgl_pengganti" type="date" name="tgl_pengganti" 
                            value="@if(isset($jadwal->tgl_klh_pengganti)){{$jadwal->tgl_klh_pengganti}}@else
                            @endif" required>
                        @if (isset($jadwal->tgl_klh_pengganti))
                            <input type="hidden" name="tgl_pengganti_old" value="{{$jadwal->tgl_klh_pengganti}}">
                        @endif
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="jam_masuk">Jam Masuk</label>
                            <input class="form-control" id="jam_masuk" type="time" name="jam_masuk" value="{{$jadwal->mulai}}" required>
                            <code>AM:Pagi || PM:Siang-Malam</code>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="jam_keluar">Jam Keluar</label>
                            <input class="form-control" id="jam_keluar" type="time" name="jam_keluar" value="{{$jadwal->selesai}}" required>
                            <code>AM:Pagi || PM:Siang-Malam</code>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="ruang">Ruangan</label>
                            <input class="form-control" id="ruang" type="text" name="ruang" value="{{$jadwal->no_ruang}}" required>
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
        </div>
        @if (!isset($_POST['kirim']))
       
            <div class="table-responsive">
                <table id="myTable" class="table custom-table m-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nip</th>
                                        <th>Matkul</th>
                                        <th>Kode Mtk</th>
                                        <th>Tgl Digantikan</th>
                                        <th>Tgl Pengganti</th>
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>No Ruang</th>
                                        <th>Status</th>
                                        <th class="text-center" >Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kuliah_pengganti as $kp)
                                        
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$kp->nip}}</td>
                                        <td>{{$kp->nm_mtk}}</td>
                                        <td>{{$kp->kd_mtk}}</td>
                                        <td>{{$kp->tgl_yg_digantikan}}</td>
                                        <td>{{$kp->tgl_klh_pengganti}}</td>
                                        <td>@if (isset($kp->kel_praktek))
                                            {{$kp->kel_praktek}}
                                            @elseif(isset($kp->kd_gabung))
                                            {{$kp->kd_gabung}}
                                            @else
                                            {{$kp->kd_lokal}}
                                            @endif</td>
                                        <td>{{$kp->hari_t}}</td>
                                        <td>{{$kp->jam_t}}</td>
                                        <td>{{$kp->no_ruang}}</td>
                                        <td><span class="badge 
                                            @if ($kp->sts_pengajuan=='0')
                                            badge-danger 
                                            @elseif($kp->sts_pengajuan=='1')
                                            badge-warning 
                                            @else
                                            badge-success 
                                            @endif
                                            "> 
                                            @if ($kp->sts_pengajuan=='0')
                                                Pengajuan Dosen
                                            @elseif($kp->sts_pengajuan=='1')
                                                ACC dari ADM
                                            @else
                                                ACC Ka. BAAK
                                            @endif</span></td>
                                        {{-- <td>
                                            <form action="{{url('/pengganti-teori')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="kd_lokal" value="{{$kp->kd_lokal}}">
                                                <input type="hidden" name="kd_mtk" value="{{$kp->kd_mtk}}">
                                                <input type="hidden" name="tgl_pengganti" value="{{$kp->tgl_klh_pengganti}}">
                                                <button type="submit" name="kirim" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-edit1"></i></button>
                                            </form>
                                        </td> --}}
                                        <td>
                                        @if ($kp->sts_pengajuan=='0')
                                            <form action="{{url('/hapus-pengganti-teori')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="kd_lokal" value="{{$kp->kd_lokal}}">
                                                <input type="hidden" name="kd_mtk" value="{{$kp->kd_mtk}}">
                                                <input type="hidden" name="tgl_pengganti" value="{{$kp->tgl_klh_pengganti}}">
                                                <button type="submit" name="kirim" class="btn" data-toggle="tooltip" data-placement="top" title="Hapus" id="btnDelete"><i class="icon-delete"></i></button>
                                            </form>
                                        @elseif($kp->sts_pengajuan=='2'&&$kp->tgl_klh_pengganti==date('Y-m-d'))
                                        <form action="{{url('/create-teori-pengganti')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="kd_mtk" value="{{$kp->kd_mtk}}">
                                            <input type="hidden" name="nm_mtk" value="{{$kp->nm_mtk}}">
                                            <input type="hidden" name="kd_dosen" value="{{$kp->kd_dosen}}">
                                            <input type="hidden" name="sks" value="{{$kp->sksajar}}">
                                            <input type="hidden" name="kd_lokal" value="{{$kp->kd_lokal}}">
                                            <input type="hidden" name="hari_t" value="{{$kp->hari_t}}">
                                            <input type="hidden" name="jam_t" value="{{$kp->jam_t}}">
                                            <input type="hidden" name="no_ruang" value="{{$kp->no_ruang}}">
                                            <input type="hidden" name="mulai" value="{{$kp->mulai}}">
                                            <input type="hidden" name="selesai" value="{{$kp->selesai}}">


                                        {{--  <button type='submit' class='btn btn-primary left'> Masuk Kelas</button>  --}}
                                         @php 
                            if($ip == null){
                                $ip = json_decode('{"kd_cabang":""}');
                            }
                         @endphp
                        {{--  @if ($dayList[$day]==$jad->hari_t)  --}}
                        {{--  Tombol IP  --}}
                        @if (substr($kp->no_ruang,0,2)=='EL' || substr($kp->no_ruang,0,2)=='EN' || substr($kp->no_ruang,0,2)=='ET' || substr($kp->no_ruang,0,2)=='EX')
                        <button type='submit' class='btn btn-primary left'> Masuk Kelas</button>
                        @elseif(substr($kp->no_ruang,-2)==$ip->kd_cabang)
                        <button type='submit' class='btn btn-primary left'> Masuk Kelas</button>
                        @else
                        <span class="badge badge-secondary mt-1">Diluar Jaringan Kampus ({{$ipclient}})</span>
                        {{--  <button type='button' class='btn btn-danger left'> </button><br>  --}}
                        @endif
                                         </form>  
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    
                @endif
    </div>
</div>
{{-- Pemisah --}}

        
    
@endsection
@push('scripts')
		<script type="text/javascript">
		$('#btnDelete').on('click',function(e){
			document.onsubmit=function(){
           return confirm('Sure?');
       }
	});
    $(document).ready(function () {
       $('#myTable').DataTable({
        dom: 'Blfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, 10000 ],
                        [ '10', '25', '50', 'Show All' ]
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
        });
     });
			</script>
	@endpush
