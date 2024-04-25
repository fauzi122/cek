 @extends('layouts.dosen.main')
 @section('content')
 <div class="content-wrapper">
	<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
	<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
	<!-- Row start -->
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="task-section">
				<!-- Row start -->
				<div class="row no-gutters">
					<div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4">
						<div class="labels-container">
							<div class="mt-5"></div>
							
						</div>
					</div>
					<div class="col-xl-11 col-lg-11 col-md-9 col-sm-9 col-8">
						<div class="tasks-container">
							<div class="modal fade" id="addNewTask" tabindex="-1" role="dialog" aria-labelledby="addNewTaskLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="addNewTaskLabel">Input Forum Diskusi</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form class="row gutters" method="post" action="/tambah-diskusi" enctype="multipart/form-data">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<div class="form-group mb-0">
														@csrf
														<label for="addResss">Judul Diskusi*</label>
														<input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" value="{{ old('judul') }}">
														@error('judul')
														<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<label for="addResss">Isi Form Diskusi*</label>
														<textarea class="form-control @error('chat') is-invalid @enderror" name="chat">{{ old('chat') }}</textarea>
														@error('chat')
														<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<div class="form-group">
															<label class="label">Lampiran</label>
															<div class="custom-date-input">
																<input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
																<code>File PDF Max 2MB</code>
																@error('file')
																<div class="invalid-feedback">{{ $message }}</div>
																@enderror
															</div>
														</div>
														<input type="hidden" name="kd_lokal" value="{{$request[0]}}">
														<input type="hidden" name="kd_mtk" value="{{$request[1]}}">
													</div>
												</div>
											</div>
											<div class="modal-footer custom">
												<div class="left-side">
													<button type="button" class="btn btn-link danger btn-block" data-dismiss="modal">Cancel</button>
												</div>
												<div class="divider"></div>
												<div class="right-side">
													<button type="submit" class="btn btn-link success btn-block">Create</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="tasks-header">
								<h3>Forum Diskusi <span class="date" id="todays-date"></span></h3>
								<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addNewTask">Add New Task</button>
							</div>
							<div class="tasksContainerScroll">
								<!-- Row start -->
								<div class="row no-gutters justify-content-center">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<section class="task-list">
											<!-- Task #1 -->
											@foreach ($chat->get() as $ct)
											<div class="task-block">
												<div class="task-checkbox">
													{{-- <input type="checkbox" name="task_00"> --}}
													<div class="ripple-container">
														<div class="check-off"></div>
														<div class="check-on">
															{{-- <i class="icon-check1"></i> --}}
														</div>
													</div>
												</div>
												<div class="task-details">
													<div class="task-name">
														{{$ct->judul}}
													</div>
													<form action="/download-file-diskusi" method="post">
													<div class="task-desc readmore">{{$ct->chat}}
														@if (isset($ct->file)&&$ct->file<>'')
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$id}}">
                                                            <input type="hidden" name="file" value="{{$ct->file}}">
                                                            <button type="submit" class="badge badge-info"><i class="icon-download"></i> Unduh File</button>
															@endif
														</div>
													</form>  
													
													<div class="task-types">
														<form action="/hapus-diskusi/{{$ct->id_chat}}" method="post" id="delete-post-form">
															@method('delete')
                											@csrf
															<input type="hidden" name="id_chat" value="{{$ct->id_chat}}">
															<input type="hidden" name="id" value="{{$id}}">
														<span class="badge badge-info"><i class="icon-emoji-happy"> </i>
															@if (isset($ct->name))
															{{$ct->name}}
														@else
															{{$ct->nm_mhs}}												
														@endif
														</span>
														<span class="badge badge-primary"><i class="icon-calendar"> </i> {{$ct->created_at}}</span>
															<button id="btnDelete" class="badge badge-danger"><i class="icon-trash"> </i></button>
														</form>
														
													</div>
												</div>
												<form action="/form-komentar" method="POST">
													@csrf
													<input type="hidden" name="id_chat" value="{{$ct->id_chat}}">
													<input type="hidden" name="id" value="{{$id}}">
													{{-- <button type='submit' class='btn btn-info btn-rounded'> Komentar <span class="badge badge-pill badge-danger"></span></button> --}}
												</form>
												@php
												$kombinasi=Crypt::encryptString($ct->id_chat.','.$id);
												@endphp
												<a href="/form-komentar/{{$kombinasi}}" class="btn btn-info btn-rounded">Komentar <span class="badge badge-pill badge-danger">{{$ct->jml}}</span></a>
												<ul class="task-actions">
													<li>
														{{-- <button type="button" class="btn btn-info btn-rounded btn-">
															Komentar <span class="badge badge-pill badge-danger">2</span>
															<span class="sr-only">Komentar</span>
														</button> --}}
													</li>
													
												</ul>
											</div>
											@endforeach
										</section>
									</div>
								</div>
								<!-- Row end -->
							</div>
						</div>
					</div>
				</div>
				<!-- Row end -->
			</div>
		</div>
	</div>
	<!-- Row end -->

</div>
    @endsection
	@push('scripts')
		<script>
			$(document).ready(function () {
    $(".readmore").expander({
          slicePoint : 100,
          expandText: 'More',
          userCollapseText : 'Less'
    });
}); 
		</script>
		<script type="text/javascript">
		$('#btnDelete').on('click',function(e){
			document.onsubmit=function(){
           return confirm('Sure?');
       }
	});
			</script>
	@endpush