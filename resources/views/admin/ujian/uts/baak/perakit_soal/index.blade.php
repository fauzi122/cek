@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">


				<!-- Page header start -->
				
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">
									<a href="/perakit-soal-create" title="tambah data panitia">
										<i class="icon icon-plus"></i>

									</a>Data Perakit Soal Ujian</h4>
							</div>

                           
							<div class="table-container">
                                @can('add_perakit_ujian')
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
                                    Import Perakit Soal  {{ $pecah[0] ?? 'Tidak ada nilai' }}
                                  </button>
                                  @endcan
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>Kd</th>
											  <th>Nama</th>
											
											  <th>MTK</th>
                                              <th>Perakit old</th>
                                              <th>jenis ujian</th>
											  <th>paket</th>
											  
											  <th>Petugas</th>
											  <th>ACC</th>
											
											
											  <th>Updated_at</th>
											  
											   <th> 
                                                <center>
                                                Aksi
                                              </center>
                                            </th> 
											</tr>
										</thead>
										<tbody>
											@foreach ($panitia as $no => $panitia)
											<tr>
                                               
											<td>{{ $panitia->kd_dosen }}</td>
											 <td>{{ $panitia->username }}-{{ $panitia->name }}</td>

											 <td>{{ $panitia->kd_mtk }}</td>
                                             <td>{{ $panitia->id_user }}</td>
                                             <td>{{ $panitia->jenis_mtk }}</td>
											 <td>{{ $panitia->paket }}</td>
											 
											 <td>{{ $panitia->petugas }}</td>
											 <td>
												<label class="switch">
													<input type="checkbox" class="status-checkbox" id="switch{{ $panitia->id }}" data-id="{{ $panitia->id }}" {{ $panitia->status ? 'checked' : '' }}>
													<span class="slider round"></span>
												</label>
											</td>
											
											 <td>{{ $panitia->updated_at }}</td>
										
											<td>
                                                
                                                @if ($panitia->kd_dosen !== $panitia->id_user)
                                            <form action="{{ route('perakit.update', $panitia->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="jenis_mtk" value="{{ $panitia->jenis_mtk }}">
                                                <input type="hidden" name="perakit_new" value="{{ $panitia->kd_dosen }}">
                                                <input type="hidden" name="kd_mtk" value="{{ $panitia->kd_mtk }}">
                                                <input type="hidden" name="jenis" value="{{ $panitia->paket }}">
                                                <button type="submit" class="btn btn-xs btn-info">Ubah Perakit</button>
                                            </form>
                                        @else
                                            {{-- <p>Data tidak dapat diubah karena kd_dosen dan id_user sama.</p> --}}
                                        @endif

                                                
                                        @can('destroy_perakit_ujian')   
                                                <center>
													<form method="POST" class="d-inline"
													 onsubmit="return confirm('Masukan ke tempat sampah?')" 
													 action="/adm-perakit-soal/{{ $panitia->id }}/destroy">
												   @csrf
												   <input type="hidden" value="DELETE" name="_method">
												   <button type="submit" value="Delete" class="btn btn-xs btn-danger">
													 <i class="fas fa-trash"></i> Hapus </button>
											   </form>
																   
												</center>
                                                @endcan
										</td>
                        

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
@include('admin.ujian.uts.baak.perakit_soal.modal_perakit')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function () {
			$('.status-checkbox').on('change', function () {
				const id = $(this).data('id');
				const status = $(this).is(':checked') ? 1 : 0;

				$.ajax({
					method: 'POST',
					url: '{{ route("update-stsperakit") }}',
					data: {
						id: id, 
						status: status, 
						_token: '{{ csrf_token() }}'
					},
					success: function (response) {
						console.log('Status updated successfully:', response.message);
					},
					error: function (xhr, status, error) {
						console.error('Error updating status:', error);
					}
				});
			});
		});
	</script>
@endsection
<style>
    /* Toggle Switch CSS */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    /* Custom Select CSS */
    .custom-select {
        font-family: Arial, sans-serif;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        outline: none;
        display: inline-block;
        width: auto; /* Sesuaikan lebar sesuai dengan kebutuhan */
        cursor: pointer;
        font-size: 1.1em; /* Ukuran font diperbesar */
    }

    .custom-select:focus {
        border-color: #5b9bd5;
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
    }

    .custom-select option {
        padding: 12px;
        border-bottom: 1px solid #ddd; /* Menambah garis pemisah antar pilihan */
    }

    /* Custom Table CSS */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 1em; /* Ukuran font diperbesar */
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .custom-table thead tr {
        background-color: #009879;
        color: white;
        text-align: left;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px 15px;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .custom-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .custom-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .custom-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }
</style>