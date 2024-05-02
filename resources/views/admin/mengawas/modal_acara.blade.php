<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Large modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Form Berita Acara Ujian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- @if(!empty($soal->kd_gabung))
                <form method="POST" action="{{ route('store-berita-mengaws-ujian-gabung') }}">
                    @csrf
                    <input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
                    <input type="hidden" name="kd_gabung" value="{{ $soal->kd_gabung }}">
                    <input type="hidden" name="paket" value="{{ $soal->paket }}">
                
                    <div class="form-group">
                        <label for="isi">Berita Acara:</label>
                        <textarea class="form-control" id="isi" name="isi" rows="7">{{ $beritaAcara->isi ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Kirim Data
                    </button> 
                </form>
                @else --}}
                <form method="POST" action="{{ route('store-berita-mengaws-ujian') }}">
                    {{-- <form action="/store/berita-mengawas-uts/" method="post" enctype="multipart/form-data"> --}}
                        @csrf
                        <input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
                        <input type="hidden" name="kel_ujian" value="{{ $soal->kel_ujian }}">
                        <input type="hidden" name="paket" value="{{ $soal->paket }}">
                    
                        <div class="form-group">
                            <label for="isi">Berita Acara:</label>
                            <textarea class="form-control" id="isi" name="isi" rows="7">{{ $beritaAcara->isi ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Kirim Data
                        </button> 
                    </form>
                {{-- @endif --}}
                <hr>
                {{-- <label>
                    <h5>*Catatan :</h5> 
                    <br>
                    <h6> 
                        1. Upload soal harus sesuai format excel yang tersedia.  
                        <br>
                        <br>
                    </h6> 
                </label> --}}
            </div>
        </div>
    </div>
</div>