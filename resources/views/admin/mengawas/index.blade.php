@extends('layouts.dosen.main')


@section('content')
<div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
      <div class="card-header badge-success">
							
        <h4 class="m-b-0 text-white">Mengawas Ujian</h4>
    </div>
      <div class="table-container " >
       <div class="" > 
        
      <br>
      <br>
      <br>
          <div class="row gutters">
        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="info-tiles">
                <div class="info-icon">
                    <i class="icon-activity"></i>
                </div>
                <div class="stats-detail">
                    <h3><a href="/mengawas-uts"> Ujian Tengah Semester (UTS)</a></h3>
                  
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="info-tiles">
                <div class="info-icon">
                    <i class="icon-filter_frames"></i>
                </div>
                <div class="stats-detail">
                    <h3><a href="/mengawas-uas">Ujian Akhir Semester (UAS)</a></h3>
                    
                </div>
            </div>
        </div>
</div>




      </div>
     
      </div>

    </div>
  </div>
 @endsection