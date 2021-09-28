<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Lotto</title>
</head>

<body class="text-blueGray-700 antialiased">

    @include('partials.header')

    <div id="__next">

        <nav class="fixed z-50 w-full bg-white top-0 flex flex-wrap items-center justify-between px-2 py-3 shadow-lg">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start"><a
                        class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-blueGray-700"
                        href="{{ route('home') }}">Lotto</a><button
                        class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
                        type="button"><i class="fas fa-bars"></i></button></div>
                <div class="lg:flex flex-grow items-center hidden" id="example-navbar-danger">
                    <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                        <li class="nav-item"><a
                                class="px-3 py-2 flex items-center text-xs uppercase font-bold text-blueGray-700 hover:text-blueGray-500"
                                href="{{ route('hits') }}"><i
                                    class="far fa-file-alt text-lg leading-lg text-blueGray-400"></i><span
                                    class="ml-2">Hits</span></a></li>
                        <li class="nav-item"><a
                                class="download-button px-3 py-2 flex items-center text-xs uppercase font-bold text-blueGray-700 hover:text-blueGray-500"
                                href="{{ route('result') }}"><i
                                    class="fas fa-arrow-alt-circle-down text-lg leading-lg text-blueGray-400"></i><span
                                    class="ml-2">Result</span></a></li>
                        <li class="nav-item"><a
                                href="{{ route('generate') }}"
                                class="download-button px-3 py-2 flex items-center text-xs uppercase font-bold text-blueGray-700 hover:text-blueGray-500"><i
                                    class="fab fa-sketch text-lg leading-lg text-blueGray-400"></i><span
                                    class="ml-2">Generator</span></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    @include('partials.footer')

</body>

</html>
