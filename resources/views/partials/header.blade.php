<div class="fixed z-50 top-0 w-full bg-white">
    <nav class="container mx-auto flex justify-between items-center z-20">
        <div class="my-5 w-36 lg:my-6">
            <a href="{{ route('home') }}"><img src="{{ asset('img/logo.png') }}" alt="Tot Encerts Logo"></a>
        </div>
        <div class="hidden lg:block text-sm text-neutral-grayish-blue">
            <a class="mx-3 py-5 hover:gradient-border-bottom text-red-400" href="{{ route('quiniela') }}">Quiniela</a>
            <a class="mx-3 py-5 hover:gradient-border-bottom text-green-400" href="#">Bonoloto</a>
        </div>
        <div class="" id="example-navbar-danger">
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
    </nav>
</div>