@extends('layouts.dosen.main')
@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <form action="/input-semester" method="POST">
                    @csrf
                <div class="row gutters">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" name="semester" class="form-control time" placeholder="Semester" value="{{$penilaian->smt}}">
                            <code>Contoh : '1','2','3','5','7','8','9'</code>
                        </div>
                        <div class="form-group mb">
                            <button type="submit" class="btn btn-info">Save</button>
                            </div>
                            
                    </div>
                    </form>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            @php
     for ($i= 1; $i <= $penilaian->lastPage; $i++) { 
			if ( $bagi = $i % 10 == 0 ) {
                echo "
                <a href='".url("/send-semester/".Crypt::encryptString($i)) ."' type='button' class='btn btn-info'>Klik $i</a>
                "; 
			}
		}
        if (substr($penilaian->lastPage,1)!='0') {
            echo "
                <a href='".url("/send-semester/".Crypt::encryptString($penilaian->lastPage)) ."' type='button' class='btn btn-info'>Klik $penilaian->lastPage</a>
                ";
            }
 @endphp
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <a href="{{url("/hapus-mhs")}}" type='button' class='btn btn-info'> Hapus Mahasiswa</a>
@php
for ($i= 1; $i <= $penilaian->lastPage; $i++) { 
       if ( $bagi = $i % 10 == 0 ) {
           echo "
           <a href='".url("/send-mhs/".Crypt::encryptString($i)) ."' type='button' class='btn btn-info'>Klik $i</a>
           "; 
       }
   }
   if (substr($penilaian->lastPage,1)!='0') {
       echo "
           <a href='".url("/send-mhs/".Crypt::encryptString($penilaian->lastPage)) ."' type='button' class='btn btn-info'>Klik $penilaian->lastPage</a>
           ";
       }
@endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $('.time').mask("'0','0','0','0','0','0','0','0','0'");
     });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
@endpush
