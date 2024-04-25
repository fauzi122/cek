 
                                   @php
                                    $sekarang = now();
                                @endphp
                                
                                @if ($setting && $sekarang->between($setting->mulai, $setting->selsai))
                                                                    @if ($aprov)
                                                                    <div class="alert alert-info">Soal sudah dikirim, Anda tidak dapat menambah, edit, dan hapus</div>
                                                                    @else
                                                                    <a href="/uts-create-pilih/{{$id}}" class="btn btn-success">Input Soal Pilihan Ganda</a>
                                                                                  
                                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
                                                                        Import Excel Soal Pilihan Ganda
                                                                    </button>
                                                                
                                                               @if($soals->isNotEmpty())
                                                                    <a href="{{ route('kirim.soal.uts', $kirim) }}" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin akan mengirim semua soal?')">Kirim Semua Soal Pilihan Ganda</a>
                                                                    <ul>
                                
                                                                  </ul>
                                                                    @else
                                                                    <a href="" title="isi dulu bank soalnya" class="btn btn-secondary" onclick="return false;">
                                                                      <span class="icon-warning">Kirim Semua Soal Pilihan Ganda.</span>
                                                                  </a>
                                                                  
                                                                @endif 
                                                                    @endif  
                                
                                                                  <p>
                                                                    <br>
                                                                  <h4>List Soal Pilihan Ganda</h4>	
                                                                  <hr>
                                                                  </p>
                                                                  <form action="{{ url('/delete-soal-uts') }}" method="POST">
                                                                    @if (!$aprov)
                                                                    @csrf <!-- Token CSRF untuk keamanan -->
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" onclick="return confirmDeletion();">Hapus Soal Terpilih</button>
                                                                    @endif
                                                                    @else
                                    <div class="alert alert-warning">Bukan periode aktivitas. Anda tidak dapat menambah, mengedit, atau menghapus soal saat ini.</div>
                                @endif
                                                                    <table id="myTable5" class="table custom-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><input type="checkbox" id="selectAll"></th>
                                                                                {{-- <th>NO</th> --}}
                                                                                <th>Soal</th>
                                                                                <th style="text-align: center;">Kunci</th>
                                                                                <th style="text-align: center;">Gambar</th>
                                                                                <th style="text-align: center;">Diperbarui</th>
                                                                                <th style="text-align: center;">Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($soals as $no => $soals)
                                                                            <tr>
                                                                                <td>
                                
                                                                                  <input type="checkbox" name="deleteIds[]" value="{{ $soals->id }}">
                                                                                
                                                                                </td>
                                                                                {{-- <td>{{ ++$no }}</td> --}}
                                                                                <td>{!! ($soals->soal) !!}</td>
                                                                                <td style="text-align: center;">{{ $soals->kunci }}</td>
                                                                                <td style="text-align: center;">
                                                                                    @if ($soals->file != '')
                                                                                        <a href="/edit-detail/soal-uts/{{ Crypt::encryptString($soals->id) }}"><span class='badge badge-pill badge-info'>gambar</span></a>
                                                                                    @endif
                                                                                </td>
                                                                                <td style="text-align: center;">{{ $soals->updated_at }}</td>
                                                                                <td style="text-align: center;">
                                                                                  @if (!$aprov)
                                                                                    <a href="/edit-detail/soal-uts/{{ Crypt::encryptString($soals->id) }}" class="btn btn-sm btn-success">edit</a>
                                                                                  @endif  
                                                                                    <a href="/detail/soal-show-uts/{{ Crypt::encryptString($soals->id) }}" class="btn btn-sm btn-info">show</a>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                
                                                                </form>