
@php
    $sekarang = now();
@endphp

@if ($setting && $sekarang->between($setting->mulai, $setting->selsai))
@if ($aprov)
    <div class="alert alert-info">Soal sudah dikirim, Anda tidak dapat menambah, edit, dan hapus</div>
@else
    <a href="/uts-create-essay/{{$id}}" class="btn btn-success">Input Soal Essay</a>
    {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal1">
        Import Excel Soal Essay
    </button> --}}
    @if($essay->isNotEmpty())
    <a href="{{ route('kirim.soalessay.uts', $kirim) }}" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin akan mengirim semua soal?')">Kirim Semua Soal Essay</a>

    <ul>

  </ul>
    @else
    <a href="" title="isi dulu bank soalnya" class="btn btn-secondary" onclick="return false;">
        <span class="icon-warning">Kirim Semua Soal Essay</span>
    </a>
@endif 
   
@endif
<br><br>
<h4>List Soal Pilihan Essay</h4>
<hr>

@if (!$aprov)
    <form action="{{ url('/delete-soal-essay-uts') }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirmDeletion();">Hapus Soal Essay Terpilih</button>
@endif
@else
    <div class="alert alert-warning">Bukan periode aktivitas. Anda tidak dapat menambah, mengedit, atau menghapus soal saat ini.</div>
@endif

<table id="copy-print-csv" class="table custom-table">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAll1"></th>
            <th>Soal</th>
            <th style="text-align: center;">Gambar</th>
            <th style="text-align: center;">Updated</th>
            <th style="text-align: center;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($essay as $item)
        <tr>
            <td><input type="checkbox" name="essayIds[]" value="{{ $item->id }}"></td>
            <td>

                {{ Str::limit(strip_tags($item->soal), 100) }}
                @if(strlen(strip_tags($item->soal)) > 100)
                <a href="/essay/soal-show-uts/{{ Crypt::encryptString($item->id) }}">Lihat Lebih Lengkap</a>

                @endif
            </td>
            <td style="text-align: center;">
                @if ($item->file != '')
                    <center>
                        <a href="/edit-essay/soal-uts/{{ Crypt::encryptString($item->id) }}">cek gambar</a>
                    </center>
                @endif
            </td>
            <td style="text-align: center;">{{ $item->updated_at }}</td>
            <td>
                <center>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            menu
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            @if (!$aprov)
                                <a class="dropdown-item" href="/edit-essay/soal-uts/{{ Crypt::encryptString($item->id) }}">Edit</a>
                            @endif
                            <a class="dropdown-item" href="/essay/soal-show-uts/{{ Crypt::encryptString($item->id) }}">Show Data Soal</a>
                        </div>
                    </div>
                </center>
            </td>
        </tr>
        @endforeach        
    </tbody>
</table>

@if (!$aprov)
    </form>
@endif
