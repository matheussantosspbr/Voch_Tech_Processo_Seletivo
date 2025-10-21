<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link href="/style/app.css" rel="stylesheet">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<script src="https://kit.fontawesome.com/22c21b90be.js" crossorigin="anonymous"></script>

{{-- Flowbite--}}
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

{{-- Sweetalert2 --}}
<script src="{{asset('/js/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>

{{-- JQUERY & Plugins --}}
<script src="{{asset('/js/jquery/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('/js/jquery/jquery.mask.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
@livewireStyles
@livewireScripts
