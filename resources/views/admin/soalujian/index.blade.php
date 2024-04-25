
@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
      <div class="card-header badge-primary">
							
        <h4 class="m-b-0 text-white">Master Soal Ujian</h4>
    </div>
      <div class="table-container " >
       <div class="" > 

      <br>
      <br>  
            <div class="row gutters">
                @foreach ($encryptedExamTypes as $examType => $encryptedValue)
                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="info-tiles">
                        <div class="info-icon">
                            <i class="icon-activity"></i>
                        </div>
                        <div class="stats-detail">
                            <h3><a href="/uts-soal/{{ $encryptedValue }}">Master Soal {{ ucwords(strtolower($examType)) }}</a></h3>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
      <hr>
      </div>
     
      </div>

    </div>
  </div>
  <!-- Row end -->


       

        
</div>
</div>

@endsection
