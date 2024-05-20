<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Import Perakit Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/adm/upload-perakit-soal" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="file">File (.xls, .xlsx)
                        <a href="{{ Storage::url('public/panduan/perakit.xlsx') }}" class="btn btn-info btn-sm">
                            Unduh Format File
                        </a>
                    </label>
                    <div class="form-group">
                        <input type="text" hidden  name="paket" value="{{ $pecah[0] ?? 'Tidak ada nilai' }}">
                        {{-- <input type="text" hidden  name="jenis" value="{{ $soal->paket }}"> --}}
                        <br>
                        <input type="text" hidden name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                        <p class="text-danger">{{ $errors->first('file') }}</p>
                        <input type="file" class="btn btn-primary" name="file">
                        <button class="btn btn-info btn-lg">
                            <i class="icon-upload"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
