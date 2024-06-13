@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">
									
									Rekapitulasi SKS Mengawas Ujian</h4>
							</div>
						
							<div class="table-container">
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
                                                <th>nip</th>
                                                <th>nama</th>
                                                <th>KD Dosen</th>
                                                <th>Dept</th>
                                                <th>OT</th>
                                                <th>Total SKS</th>
                                                @if (!empty($results))
                                                    @foreach ($results[0] as $key => $value)
                                                        @if ($key != 'kd_dosen' && $key != 'total_sks')
                                                            <th>{{ $key }}</th>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tr>
										</thead>
										<tbody>
											@foreach ($results as $result)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <a href="http://">
                                                {{ $result->kd_dosen }}
                                            </a>
                                            </td>
                                            <td></td>
                                            <td>{{ $result->ot }}</td>
                                            <td>{{ $result->total_sks }}</td>
                                            @foreach ($result as $key => $value)
                                                @if ($key != 'kd_dosen' && $key != 'total_sks')
                                                    <td>{{ $value }}</td>
                                                @endif
                                            @endforeach
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
@endsection
