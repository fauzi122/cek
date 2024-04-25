@extends('layouts.dosen.main')
@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

<div class="content-wrapper">
	<div class="card">
		<div class="card-body">

			<!-- Row start -->
			<div class="row gutters">
				
				<div class="col-xl-12 col-lg col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<form name=frmTest action="{{ url('/cek-kuliah-pengganti') }}" method="POST">
							@csrf
						<label>Pemilihan Kampus<span class="danger">*</span></label>
						<select class="form-control selectpicker" data-live-search="true" name="kampus" data-placeholder="Click to Choose..." required onChange="frmTest.submit();">
							<option value="">Click to Choose Campus...</option>
							@foreach ($kampus as $kp)
								<option value="{{$kp->kd_kampus}}">{{$kp->kd_kampus}} - {{$kp->nm_kampus}} ( {{$kp->alm_kampus}} )</option>
							@endforeach
						</select>
						</form>
					</div>
				</div>
			</div>
			<!-- Row end -->

		</div>
	</div>
	@php
		// dd($_POST['frmTest']);
	@endphp
	@if (isset($_POST['kampus']))
	
	@php
		$id=$_POST['kampus'];
	@endphp
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
													<th>Matkul</th>
													<th>Tgl Digantikan</th>
													<th>Tgl Pengganti</th>
													<th>Kelas</th>
													<th>Hari</th>
													<th>Jam</th>
													<th>No Ruang</th>
													<th>Status/Alasan</th>
													<th class="text-center">Aksi</th>
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
														@else
														{{$kp->kd_lokal}}
														@endif</td>
													<td>{{$kp->hari_t}}</td>
													<td>{{$kp->jam_t}}</td>
													<td>{{$kp->no_ruang}}</td>
													<td><a class="badge 
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
														</a></td>
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
														 @if ($kp->sts_pengajuan=='0')
														<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button><div class="dropdown-menu">
														<a class="dropdown-item" href="{{url('/acc-pengganti/'.$id)}}">Acc</a>
														<a href="{{url('/edit-pengganti/'.$id)}}" class="dropdown-item" >Edit</a>
														<a href="{{url('/hapus-pengganti/'.$id)}}" class="dropdown-item tombol-hapus" >Hapus</a>
														</div></div>
														@endif
													</td>
												</tr>
												@endforeach
												<tbody>
											</tbody>
										</table>
									</div>
								</div>
                </div>
            </div>
        </div>
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
	<div class="modal fade"  aria-labelledby="myLargeModalLabel" id="edit" >
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
			</div>
			<form method="post" action="" role="form" enctype="multipart/form-data">
			<div class="modal-body">
				<h3>Bidang B</h3>
					<b>Menghasilkan karya ilmiah hasil penelitian atau pemikiran yang dipublikasikan</b><br>
					Jurnal internasional bereputasi (terindeks pada database internasional bereputasi dan berfaktor dampak) 
					<hr>
					
					<div class="row">
					  <div class="col-md-4">
						<div class="form-group">
						  <label for="tahun_akademik">Semester</label>
						  <input type="text" name="thn_akademik" value=""  class="form-control" id="thn_akademik" maxlength="150" readonly>
						</div>
					  </div>
			</div>
	
				<div class="modal-footer">
					<div class="btn-group pull-right">
						<button type="submit" class="btn btn-primary">Update</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
		@endif
</div>
@endsection
