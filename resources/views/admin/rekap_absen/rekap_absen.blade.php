@extends('layouts.dosen.main')
@section('content')
<div class="content-wrapper">

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="col-sm-5 col-md-5">
                            <div class="table-responsive">
                                <table class="table">   
                                    <?php foreach($mtk as $dtmtk):?>
                                    
                                    <tr>
                                        <td>Kelas</td><td>:
                                            @if (isset($kel_praktek))
                                            {{$kel_praktek}}
                                            @elseif(isset($kd_gabung))
                                            {{$kd_gabung}}
                                            @else
                                            {{$kd_lokal}}
                                            @endif
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Kode MTK</td><td>: {{$dtmtk->kd_mtk}}</td>								
                                    </tr>
                                    <tr>
                                        <td>MTK</td><td>: {{$dtmtk->nm_mtk}}</td>								
                                    </tr>
                                    <tr>
                                        <td></td><td></td>								
                                    </tr>
                                    <?php endforeach;?>
                                </table>
                            </div>
                         </div>	
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-btn-group">
                        <!-- Buttons -->
                        <div style="overflow:auto;">
                            <table id="myTable2" class="table custom-table">
                                <thead>
                                  @php
                                      $maxtemu = 0;
                                  @endphp
                                      @foreach ($cektemu as $r)
                                      @if ($r->pertemuan>$maxtemu)
                                      @php
                                          $maxtemu = $r->pertemuan;
                                      @endphp
                                      
                                      @endif  
                                      @endforeach
                                    <tr style="font-size:0.8em;">
                                      <th>#</th>
                                      <th>Nim</th>	
                                      <td width="20">Nama Mhs</td>
                                      @for ($i=1;$i<=$maxtemu;$i++)
                                      <th style="font-size:0.8em;">	
                                          <form action="
                                          @if (isset($kel_praktek))
                                            {{url('/detail-rekap-praktek')}}
                                            @elseif(isset($kd_gabung))
                                            {{url('/detail-rekap-gabung')}}
                                            @else
                                            {{url('/detail-rekap-teori')}}
                                            @endif
                                          " target="_detailabsen" method="post" id="myUbah">
                                            @csrf
                                            @if (isset($kel_praktek))
                                            <input type="hidden" name="kel_praktek" value="{{$r->kel_praktek}}">
                                            @elseif (isset($r->kd_gabung))
                                            <input type="hidden" name="kd_lokal" value="{{$r->kd_gabung}}">
                                            @else
                                            <input type="hidden" name="kd_lokal" value="{{$r->kd_lokal}}">
                                            @endif
                                          <input type="hidden" name="kd_mtk" value="{{$r->kd_mtk}}">
                                          					
                                              <input type="hidden" name="pertemuan" value="{{$i}}">
                                              <div class="td-actions">
                                                  <input type="submit" class="btn-success" data-toggle="tooltip" data-placement="top" title="Pertemuan {{$i}}" value="{{$i}}">
                                              </div>
                                          </th>
                                          
                                          
                                          </form>
                                          @endfor
                                      
                                      <th>Jumlah</th>
                                    </tr>
                                  
                                </thead>
                                
                                <tbody>
                                    
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($rekapmhs as $rekmhs)
                                        @php
                                            $prt = json_decode($rekmhs->rwyhadir,true);
                                          
                                        @endphp
                                  <tr style="font-size:0.8em;">
                                    <td>{{$no}}</td>
                                    <td>{{$rekmhs->nim}} </td>
                                    <td>{{$rekmhs->nm_mhs}}</td>
                                    @for ($j=1;$j<=$maxtemu;$j++)
                                        @if (!isset($prt["P$j"]))
                                        <td style="color:#F00;"> x </td>
                                        @elseif ($prt["P$j"]=='1') 
                                        <td style="color:#00F;"><strong> v </strong></td>
                                        @else
                                        <td style="color:#F00;"> x </td>
                                        @endif
                                 
                                    @endfor
                                    <td>{{$rekmhs->jml_hadir}}</td>
                                </tr>
                                @php
                                    $no++;
                                    @endphp
                                    @endforeach
                            </tbody>
                            <footer>
                               
                            </footer>
                            </table>
                          </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
       $('#myTable2').DataTable({
        dom: 'Blfrtip',
                    lengthMenu: [
                        [300 ],
                        [ 'Show All' ]
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
        });
     });
    </script>
@endpush