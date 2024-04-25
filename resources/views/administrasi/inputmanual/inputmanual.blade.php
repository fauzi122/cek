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
						<form name=frmTest action="{{ url('/input-manual') }}" method="POST">
							@csrf
						<label>Pemilihan Dosen<span class="danger">*</span></label>
						<select class="form-control selectpicker" data-live-search="true" name="dosen" data-placeholder="Click to Choose..." required onChange="frmTest.submit();">
							<option value="">Click to Choose Lecturer...</option>
							@foreach ($dosen as $kp)
								<option value="{{$kp->kode}}">{{$kp->kode}} - {{$kp->name}}</option>
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
	@if (isset($_POST['dosen']))
	
	@php
		$id=$_POST['dosen'];
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
													<th>Kd MTK</th>
													<th>Hari</th>
													<th>Kelas</th>
													<th>Waktu</th>
													<th>No Ruang</th>
													<th>Kampus</th>
													<th class="text-center">Aksi</th>
												</tr>
												</thead>
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
		$('#btnAksi').on('click',function(e){
		document.onsubmit=function(){
	   return confirm('Sure?');
   }
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
            paging: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url('/manual-side/'.$id) }}',
			
            columns: [
                { name: 'nomer',render: function (data, type, row, meta) {
	                    return meta.row + meta.settings._iDisplayStart + 1;
	                } },
                    { data: 'nip', name: 'nip' },
                    { data: 'nm_mtk', name: 'nm_mtk' },
                    { data: 'kd_mtk', name: 'kd_mtk' },
                    { data: 'hari_t', name: 'hari_t' },
                    { data: 'kelas', name: 'kelas' },
                    { data: 'jam_t', name: 'jam_t' },
                    { data: 'no_ruang', name: 'no_ruang' },
                    { data: 'nm_kampus', name: 'nm_kampus' },
                    { data: 'acc', name: 'acc' }
            ]
        });
     });
	
			</script>
<script type="text/javascript">
    var path = "{{ url('/cari-dosen') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> --}}
	@endpush
	
		@endif
</div>
@endsection
