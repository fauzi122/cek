@if ($errors->any())
<center>
    <div {{ $attributes }}>
        {{-- <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div> --}}
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </ul>
    </div>
    
        <div class="avatar sm">
            <img src="{{ Storage::url('public/icon/convert.png') }}" class="circle" style="width:250px;height:100px;" alt="4215"/>
        </div>
</center>
    @else
    <center>
        <div class="avatar sm">
            <img src="{{ Storage::url('public/mybest_3.png') }}" class="circle" style="width:250px;height:100px;" alt="4215"/>
    </div></center>
    @endif

