@if ($jml_jawab->count())
									<div class="card text-center">
										<div class="card-header">
											<div class="card-title">Nomor Soal Pilihan Ganda</div>
										</div>
										<div class="card-body">
											<div class="categoriesx">
                                        <center>
                                                
                                            @foreach ($jml_jawab as $urut=>$jml)
                                                <span class="no_soal badge badge-pill"  style="background-color:#1980d4;" id="{{ 'nav'.$jml->id }}" data-id="{{ $jml->id }}" data-no="{{ $urut+1 }}" data-soal="{{ $jml->id_soal}}"><a href="#">{{ $urut+1 < 10 ? '0':'' }}{{ $urut+1 }}</a></span>
                                            @endforeach
                                                <span class="no_soal badge badge-pill badge-light dis"  data-no="{{ $urut+2 }}" data-random="1" data-soal="{{ $jml->id_soal}}"><a href="#" >Lanjut</a></span>
                                                
                                            </center>
											</div>
										</div>
										</div>
									</div>
								</div>
@endif
                                <script>
    $(document).ready(function() {
        $('.no_soal').click(function() {
         $("#dis").css({
				"pointer-events": "auto" 
			});
			var $this = $(this);
			var id_soal = $this.attr('data-id');
			var no_urut = $this.attr('data-no');
			var random = $this.attr('data-random');
			var soal = $this.attr('data-soal');
            
			$.ajax({
				type: "GET",
                dataType: "json",
				url: "/get-soal",
                data: {
					id_soal: id_soal,
					no_urut: no_urut,
					random: random,
					soal: soal
				},
				success: function(data) {
                    console.log(data.html);
					$('#wrap-soal').html(data.html);
				}
			})
		});
    });
        </script>