{{-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div> --}}

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <div class="p-3 rounded">
        <img src="{{ Storage::url('public/icon/login2.png') }}" style="width:600px;height:500px;" alt="4215"/>
    </div>
    <div class="p-3 rounded">
        <div class="w-full sm:max-w-md mt-20 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
