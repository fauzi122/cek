
    <a href="/baak/uts-create-essay/{{$id}}" class="btn btn-success">Input Soal Essay</a>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal1">
    Import Excel Soal Essay
  </button>

<br>
<br>
 
  <h4>List Soal Pilihan Essay</h4>
  <hr>
  </p>
  @can('master_soal_ujian.acc_prodi') 
  @php
    $jenis = $soal->jenis_mtk;
@endphp

<form action="{{ url('/prodi/aprov-soal-essay') }}" method="POST">
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


    @endcan   
    <br>                    
    <table id="myTable1" class="table custom-table">
              <thead>
                <tr>
                  <th><input type="checkbox" id="checkAll"></th>
                  <th>No</th>
                  <th>Soal</th>
                  <th style="text-align: center;">Status</th>
                  <th style="text-align: center;">Updated</th>
                  <th style="text-align: center;">dosen</th>
                  <th  style="text-align: center;">Aksi </th>
                </tr>
               </thead>
              <tbody>
                @foreach ($essay as $no => $essay)
                @php
                  $detail_essay=Crypt::encryptString($essay->id);                                    
                  @endphp
             <tr>
              <td>
               
                <input type="checkbox" class="soal-checkbox" name="soal_ids[]" value="{{ $essay->id }}">
            </td>
             <td>{{ ++$no }}</td>
             <td>
              
                {{ Str::limit(strip_tags($essay->soal), 100) }}
                @if(strlen(strip_tags($essay->soal)) > 100)
                <a href="/baak/essay/soal-show-uts/{{$detail_essay}}">Lihat Lebih Lengkap</a>
                @endif
           
            
          
            </td>
             <td>
             


              @if ($essay->status == 'Y')
              <center><span class='badge badge-pill badge-light'>Tampil</span></center>
                 
             @else
              <center><span class='badge badge-pill badge-secondary'>Tidak tampil</span></center>
                 
             @endif

              <p></p>
               @if ($essay->file == '')
                {{--  <center><span class='badge badge-pill badge-light'></span></center>  --}}
                   
               @else
                <center>
                <a href="/baak/essay/soal-show-uts/{{$detail_essay}}"> <span class='badge badge-pill badge-info'>cek gambar</span>
                </a>
                </center>
                   
               @endif
             </td>
             <td  style="text-align: center;">{{$essay->updated_at}}</td>
             <td  style="text-align: center;">{{$essay->id_user}}</td>
             <td>
              <center>

               <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    menu
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="/baak/edit-essay/soal-uts/{{$detail_essay}}">Edit Data Soal</a>
                        <a class="dropdown-item" href="/baak/essay/soal-show-uts/{{$detail_essay}}">Show Data Soal</a>
                    </div>
            </div>
             </center>
             </td>
          
             </tr>
             @endforeach        
              </tbody>
            </table>
            <script>
              document.getElementById('checkAll').onclick = function() {
                  var checkboxes = document.querySelectorAll('.soal-checkbox');
                  for (var checkbox of checkboxes) {
                      checkbox.checked = this.checked;
                  }
              };
          
              document.getElementById('persetujuanKaprodiBtn').onclick = function(event) {
                  var selectedCheckboxes = document.querySelectorAll('.soal-checkbox:checked');
                  if (selectedCheckboxes.length === 0) {
                      event.preventDefault();
                      alert('Silahkan pilih minimal satu soal sebelum memberikan persetujuan.');
                  }
              };
          </script>
          <script>
            $(document).ready(function() {
                var table = $('#myTable1').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [
                        [-1, 10, 25, 50],
                        ['Show All', '10', '25', '50']
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    responsive: true
                });
            });
        </script>