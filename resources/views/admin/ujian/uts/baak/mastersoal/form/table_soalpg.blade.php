@can('master_soal_ujian.add_soal') 
    <a href="/baak/uts-create-pilih/{{$id}}" class="btn btn-success">Input Soal Pilihan Ganda</a>
									
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
                                      Import Excel Soal Pilihan Ganda
                                    </button>
                                    @endcan                       
                                  <p>
                                    <br>
                                  <h4>List Soal Pilihan Ganda</h4>	
                                  <hr>
                                  </p>
                                  @can('master_soal_ujian.acc_prodi') 

                                  @php
                                    $jenis = $soal->jenis_mtk;
                                @endphp
                                
                                
                                
                                <form action="{{ url('/prodi/aprov-soal') }}" method="POST">
                                    @csrf
                                    <input type="hidden" readonly name="kd_mtk" value="{{ $soal->kd_mtk }}">
                                    <input type="hidden" readonly name="paket" value="{{ $soal->paket }}">
                                    <input type="hidden" readonly name="jenis_mtk" value="{{ $soal->jenis_mtk }}">
                                
                                    @if(isset($acc->perakit_kirim) && $acc->perakit_kirim == 1)
                                        <button type="submit" class="btn btn-primary" id="persetujuanKaprodiBtn">
                                            <i class="icon-check"></i> Persetujuan Kaprodi
                                        </button>
                                    @elseif (isset($acc->perakit_kirim_essay) && $acc->perakit_kirim_essay == 1)
                                        <button type="submit" class="btn btn-primary" id="persetujuanKaprodiBtn">
                                            <i class="icon-check"></i> Persetujuan Kaprodi
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-secondary" disabled title="Anda belum bisa memberikan persetujuan karena perakit belum mengirim soal">
                                            <i class="icon-warning"></i> Persetujuan Kaprodi
                                        </button>
                                    @endif
                                    <!-- Tombol Download Excel -->

                                    
                                    @endcan
                                
                                    <table id="myTable1" class="table custom-table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkAll"></th>
                                                <th>Soal</th>

                                                <th style="text-align: center;">updated_at</th>
                                               
                                                <th style="text-align: center;">Dosen</th>
                                                <th style="text-align: center;">id</th>
                                                <th style="text-align: center; width: 100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($soals as $no => $soal)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="soal-checkbox" name="soal_ids[]" value="{{ $soal->id }}">
                                                </td>

                                            <td>
                                                {{ strip_tags($soal->soal) }}
                                                   <p></p>
                                                   @if ($soal->file!=null)
                                                   <img src="{{ Storage::url('public/soal/'.$soal->file) }}" class="img-thumbnail" height="150" width="200"/>
                                                    @endif
                                              <br><B> Kunci : {{ $soal->kunci }}</B>
                                              <br> A. {{ $soal->pila }}
                                              <br> B. {{ $soal->pilb }}
                                              <br> C. {{ $soal->pilc }}
                                              <br> D. {{ $soal->pild }}
                                              <br> E. {{ $soal->pile }}
                                              <p></p> Status :
                                              @php
                                                $detail = Crypt::encryptString($soal->id);
                                            @endphp
                                           
                                                @if ($soal->status == 'Y')
                                                    <span class='badge badge-pill badge-light'>Tampil</span>
                                                @else
                                                    <span class='badge badge-pill badge-secondary'>Tidak tampil</span>
                                                @endif
                                        
                                                  
                                            </td>
                                                <td style="text-align: center;">{{ $soal->updated_at }}</td>
                                                <td style="text-align: center;">{{ $soal->id_user }}</td>
                                                <td style="text-align: center;"><b>{{ $soal->id }}</b></td>
                                                <td>
                                                    <center>
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Menu
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                @can('master_soal_ujian.edit')
                                                                <a class="dropdown-item" href="/baak/edit-detail/soal-uts/{{$detail}}">Edit Data Soal</a>
                                                                <a class="dropdown-item" href="/baak/detail/soal-show-uts/{{$detail}}">Show Data Soal</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </center>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
<script>
    var checkedBoxes = {};

    $(document).ready(function() {
        var table = $('#myTable1').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [
                    [-1, 200, 100],
                    ['Show All', '200', '100']
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                responsive: true
            });
       

        table.on('draw', function() {
            $('.soal-checkbox').each(function() {
                this.checked = checkedBoxes[this.value] || false;
            });
        });

        $('#myTable1 tbody').on('change', '.soal-checkbox', function() {
            var id = this.value;
            checkedBoxes[id] = this.checked;
        });

        $('#checkAll').on('click', function() {
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
            $('input[type="checkbox"]', rows).each(function() {
                var id = this.value;
                checkedBoxes[id] = this.checked; // Update nilai checkedBoxes saat Check All
            });
        });

        $('#persetujuanKaprodiBtn').on('click', function(event) {
            var selectedCheckboxes = $('.soal-checkbox:checked');
            if (selectedCheckboxes.length === 0) {
                event.preventDefault();
                alert('Silahkan pilih minimal satu soal sebelum memberikan persetujuan.');
            } else {
                var soal_ids = $.map(selectedCheckboxes, function(checkbox) {
                    return checkbox.value;
                });
                // Simpan array soal_ids ke dalam input hidden sebelum pengiriman formulir
                $('input[name="soal_ids"]').val(JSON.stringify(soal_ids));
            }
        });
    });
</script>
                                
                                