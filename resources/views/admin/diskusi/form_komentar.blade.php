@extends('layouts.dosen.main')
@section('content')

<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

	<!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="chat-section">
                <!-- Row start -->
                <div class="row no-gutters">
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1">
                        <div class="users-container">
                           
                            
                        </div>
                    </div>
                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
                        <div class="active-user-chatting">
                            @foreach ($chat->get() as $ct)
                            <div class="active-user-info">
                            <span class="badge badge-primary"><i class="icon-emoji-happy"> </i> @if (isset($ct->name))
                                {{$ct->user}}
                            @else
                                {{$ct->nim}}												
                            @endif</span>
                                <div class="avatar-info">
                                    <h5>{{$ct->judul}}</h5>
                                    <div class="typing readmore1">{{$ct->chat}}</div>
                                </div>
                            </div>
                            @endforeach

                           

                        </div>
                        <div class="chat-container">
                            <div class="chatContainerScroll">
                                <ul class="chat-box">
                                    @foreach ($komentar as $kom)
                                    <li class='chat-left'>
                                        <div class='chat-avatar'>
                                            <div class='chat-name'>
                                                @if (isset($kom->name))
                                                {{$kom->user_komentar}}
                                            @else
                                                {{$kom->user_komentar}}												
                                            @endif
                                            </div>
                                        </div>
                                        <div class='chat-text'>
                                            <div class='chat-avatar'>
                                                <div class='chat-name'>
                                                    @if (isset($kom->name))
                                                    {{$kom->name}}
                                                @else
                                                    {{$kom->nm_mhs}}												
                                                @endif
                                                </div>
                                            <p class="readmore">{{$kom->komentar}}</p>
                                            <div class='chat-hour'>{{$kom->created_at}}<span class='icon-done_all'></span></div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        <form action="/send-komentar" method="post">
                            @csrf
                            <div class="chat-form">
                                <div class="form-group">
                                    <textarea class="form-control" name="komentar" placeholder="Write your comment..." required></textarea>
                                    <input type="hidden" name="id_chat" value="{{$ct->id_chat}}">
                                    <input type="hidden" name="id" value="{{$kombinasi}}">
                                    <button class="btn btn-primary">
                                        <i class="icon-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <!-- Row end -->
            </div>
        </div>
    </div>
    <!-- Row end -->




@endsection
@push('scripts')
		<script>
			$(document).ready(function () {
    $(".readmore1").expander({
          slicePoint : 50,
          expandText: 'More',
          userCollapseText : 'Less'
    });
    $(".readmore").expander({
          slicePoint : 100,
          expandText: 'More',
          userCollapseText : 'Less'
    });
}); 
		</script>
        @endpush