@extends('layouts.dosen.main')
@section('content')
<style>
	.hide {
		display: none;
	}
</style>
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="col-sm-5 col-md-5">
                         </div>	
                    </div>
                </div>
				<div class="btn-group">
				</div>
                <div class="card-body">
                    <div class="custom-btn-group">
                        <!-- Buttons -->
                        <div class="table-responsive">
							<table id="myTable2" class="table custom-table">
											<thead>
												<tr>
													<th>#</th>
													<th>Nip</th>
													<th>mtk</th>
													<th>Tgl Diganti</th>
													<th>Tgl Pengganti</th>
													<th>kls</th>
													<th>Hari</th>
													<th>Jam</th>
													<th>Ruang</th>
													<th>sts/Alasan</th>
													<th class="text-center">Aksi</th>
													<th>Created</th>
													<th>updated</th>
												</tr>
												</thead>
												<tbody>
													@foreach ($kuliah_pengganti as $kp)
												<tr>
													<td>{{$loop->iteration}}</td>
													<td>{{$kp->nip}} ({{$kp->kd_dosen}})</td>
													<td>{{$kp->nm_mtk}}</td>
													<td>{{$kp->tgl_yg_digantikan}}</td>
													<td>{{$kp->tgl_klh_pengganti}}</td>
													<td>@if (isset($kp->kel_praktek))
														{{$kp->kel_praktek}}
														@elseif(isset($kp->kd_gabung))
														{{$kp->kd_gabung}}
														<div class="hide"> {{$kp->detail_gabung}} </div>
														@else
														{{$kp->kd_lokal}}
														@endif</td>
													<td>{{$kp->hari_t}}</td>
													<td>{{$kp->jam_t}}</td>
													<td>{{$kp->no_ruang}}</td>
													<td>
														<a class="badge 
														@if ($kp->sts_pengajuan=='0')
														badge-danger 
														@elseif($kp->sts_pengajuan=='1')
														badge-warning 
														@else
														badge-success 
														@endif" data-toggle="tooltip" data-placement="bottom" title="{{ $kp->alasan }}">
														@if ($kp->sts_pengajuan=='0')
														Pengajuan Dosen
													@elseif($kp->sts_pengajuan=='1')
														ACC dari ADM
													@else
														ACC Ka. BAAK
													@endif
														</a>
													</td>
													<td>
														@php
														if ($kp->kd_lokal<>null) {
															$id=Crypt::encryptString($kp->kd_lokal.','.$kp->kd_mtk.','.$kp->tgl_yg_digantikan.','.$kp->tgl_klh_pengganti);
														} elseif($kp->kel_praktek<>null) {
															$id=Crypt::encryptString($kp->kel_praktek.','.$kp->kd_mtk.','.$kp->tgl_yg_digantikan.','.$kp->tgl_klh_pengganti);
														}else{
															$id=Crypt::encryptString($kp->kd_gabung.','.$kp->kd_mtk.','.$kp->tgl_yg_digantikan.','.$kp->tgl_klh_pengganti);
														}
														@endphp
														 @if ($kp->sts_pengajuan<>'0')
														<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button><div class="dropdown-menu">
														<a class="dropdown-item" href="{{url('/acc-pengganti-baak/'.$id)}}">Acc</a>
														<a href="{{url('/edit-pengganti-baak/'.$id)}}" class="dropdown-item" >Edit</a>
														<a href="{{url('/hapus-pengganti-baak/'.$id)}}" class="dropdown-item tombol-hapus">Hapus</a>
														</div></div>
														@endif
													</td>

														<td>{{$kp->created_at}}</td>
														<td>{{$kp->updated_at}}</td>
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
@endsection

@push('scripts')
		<script type="text/javascript">
        $('.tombol-hapus').on('click',function(e){
  e.preventDefault();
  const href=$(this).attr('href');
  Swal.fire({
    title: 'Apakah anda yakin',
    text: "Data akan dihapus",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus Data!'
  }).then((result) => {
    if (result.value) {
      document.location.href=href;
      
    }
  })
  });
	$(document).ready(function () {
       $('#myTable2').DataTable({
        dom: 'Blfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, 10000 ],
                        [ '10', '25', '50', 'Show All' ]
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],    
			responsive: true
        });

     });
			</script>
	@endpush
	
