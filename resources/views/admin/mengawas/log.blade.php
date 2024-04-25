@extends('layouts.dosen.main')


@section('content')

	<div class="main-container">


				<!-- Page header start -->
				
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="table-container">
								<div class="t-header">
                                   
									Berita Acara Mengawas
                             
                                </div>
								<br>
								<div class="table-responsive">
									<table class="custom-table">

										<tbody>

											<tr>
												<td>Nim</td>
												<td>{{ $log_mulai->nim }}</td>
											</tr>
											<tr>
												<td>Kelompok Ujian</td>
												<td>{{ $log_mulai->kel_ujian }}</td>
											</tr>
											<tr>
												<td>Matakuliah</td>
												<td><b>{{ $log_mulai->kd_mtk }}</b> </td>
											</tr>

											<tr>
												<td>Mulai Waktu Ujian </td>
												<td><b>{{ $log_mulai->awal_ujian }}</b></td>
											</tr>

											<tr>
												<td>Selesai Waktu Ujian </td>
												<td><b>{{ $log_mulai->akhir_ujian }}</b></td>
											</tr>
											<tr>
												<td>IP Address</td>
												<td>{{ $log_mulai->ipaddress }}</td>
											</tr>
											<tr>
												<td>Divace</td>
												<td>{{ $log_mulai->device }}</td>
											</tr>
											<tr>
												<td>Updated At</td>
												<td>{{ $log_mulai->updated_at }}</td>
											</tr>
											
											</tr>
										</tbody>
									</table>
								</div>
								<div class="nav-tabs-container">
									<!-- Navigation Tabs -->
									<ul class="nav nav-tabs" id="myTab3" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home3" aria-selected="true">
												<i class="icon-edit1"></i> Log Aktifitas 
											</a>
										</li>
										
				
									<!-- Tab Content -->
									<div class="tab-content" id="myTabContent3">
										<!-- Tab Pane 1 -->
										<div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
											<div class="row gutters">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													
														<div class="table-responsive">
															<table class="custom-table">
																		<thead>
																			<tr>
																				<th>No</th>
																				<th>NIM</th>
																				<th>Nama</th>
																				
																				<th>IP Address</th>
																				<th>Created At</th>
																				<th>Updated At</th>
																			</tr>
																		</thead>
																		<tbody>
																			@foreach ($pg as $item)
																			<td>{{ $loop->iteration }}</td>
																			<td>{{ $item->nim }}</td>
																			<td>{{ $item->nama }}</td>
																			
																			<td>{{ $item->ip_address }}</td>
																			<td>{{ $item->created_at }}</td>
																			<td>{{ $item->updated_at }}</td>
																			@endforeach
																		</tbody>
																	</table>
																	
																</tbody>
															</table>
															
														</div>
												
												</div>
											</div>
										</div>
				
										<!-- Tab Pane 2 -->
								
									</div>
								</div>
								</div>
							</div>

						


						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>

			
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
