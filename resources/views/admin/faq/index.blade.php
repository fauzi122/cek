@extends('layouts.dosen.main')

@section('content')

    <div class="content-wrapper">
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        
                <div class="accordion toggle-icons lg" id="toggleIcons">
                    <div class="accordion-container">
                        <div class="accordion-header" id="toggleIconsOne">
                            <a  href="" class="" data-toggle="collapse" data-target="#toggleIconsCollapseOne" aria-expanded="true" aria-controls="toggleIconsCollapseOne">
                             Apa itu MyBest   ?
                            </a>
                        </div>
                        <div id="toggleIconsCollapseOne" class="collapse show" aria-labelledby="toggleIconsOne" data-parent="#toggleIcons">
                            <div class="accordion-body">
                                <p>
                                   't heard of them accusamus labore sustainable VHS.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-container">
                        <div class="accordion-header" id="toggleIconsTwo">
                            <a  href="" class="collapsed" data-toggle="collapse" data-target="#toggleIconsCollapseTwo" aria-expanded="false" aria-controls="toggleIconsCollapseTwo">
                                Kenapa Kita Harus Menggunakan MyBest ?
                            </a>
                        </div>
                        <div id="toggleIconsCollapseTwo" class="collapse" aria-labelledby="toggleIconsTwo" data-parent="#toggleIcons">
                            <div class="accordion-body">
                                <P>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</P>
                            </div>
                        </div>
                   
                </div>
        
            </div>
        </div>
</div>


@endsection