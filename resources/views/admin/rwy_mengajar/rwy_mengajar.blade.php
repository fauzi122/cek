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
						<form name=frmTest action="{{ url('/riwayat-mengajar') }}" method="POST">
							@csrf
						<label>Semester<span class="danger">*</span></label>
						<select class="form-control selectpicker" data-live-search="true" name="jklh" data-placeholder="Click to Semester..." required onChange="frmTest.submit();">
							<option value="">Click to Choose Semester...</option>
							@foreach ($riwayat as $rwy)
								<option value="{{$rwy->no_j_klh}}">{{$rwy->no_j_klh}} - {{$rwy->periode}}</option>
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
	@if (isset($_POST['jklh']))
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
													<th>No Jadwal Kuliah</th>
													<th>Kode Mata Kuliah</th>
													<th>Nama Mata Kuliah</th>
													<th>Kelas</th>
													<th>Kelompok Praktek</th>
													<th>Kelas Gabung</th>
												</tr>
												</thead>
												<tbody>
													@foreach ($all_riwayat as $all_rwy)
												<tr>
													<td>{{$loop->iteration}}</td>
													<td>{{$all_rwy->no_j_klh}}</td>
													<td>{{$all_rwy->kd_mtk}}</td>
													<td>{{$all_rwy->nm_mtk}}</td>
													<td>{{$all_rwy->kd_lokal}}</td>
													<td>{{$all_rwy->kel_praktek}}</td>
													<td>{{$all_rwy->kd_gabung}}</td>
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
