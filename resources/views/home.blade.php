@extends('main')

@section('content')
    
<section class="py-14 lg:py-32">
    <div class="container mx-auto">
        <h2 class="text-center text-3xl lg:text-3xl text-primary-dark-blue mb-5 lg:text-left lg:mb-10">Últimos Resultados</h2>
        <div class="grid grid-cols-1 gap-5 lg:gap-7 lg:grid-cols-4">
            <article class="bg-white">
                <div class="aspect-w-16 aspect-h-10 lg:aspect-w-4 lg:aspect-h-3">
                    <a href="{{ route('quiniela') }}">
                        <img class="object-cover" src="{{ asset('img/quiniela.png') }}" alt="multiple bills with different values and currencies">
                    </a>
                </div>
                <div class="px-7 pt-5 pb-10 lg:p-6">
                    <span class="text-neutral-grayish-blue text-xs">{{ date('d-m-Y', strtotime($journey[0]->league_date)) }}</span>
                    <h4 class="text-primary-dark-blue text-sm py-2">
                        <a href="{{ route('journey', $journey[0]->_id) }}" class="font-bold hover:text-red-400">
                            Quiniela {{ $journey[0]->working_day }} · {{ $journey[0]->modality }}
                        </a>
                    </h4>
                    <p class="text-neutral-grayish-blue text-xs py-2">
                        @foreach ($matches as $match)
                            <span class="border font-medium p-1">{{ $match->result }}</span>
                        @endforeach    
                    </p>
                </div>
            </article>
            <article class="bg-white">
                <div class="aspect-w-16 aspect-h-10 lg:aspect-w-4 lg:aspect-h-3">
                    <img class="object-cover" src="{{ asset('img/bonoloto.png') }}" alt="multiple bills with different values and currencies">
                </div>
                <div class="px-7 pt-5 pb-10 lg:p-6">
                    <span class="text-neutral-grayish-blue text-xs">{{ date('d-m-Y', strtotime($bonoloto[0]->raffle_date)) }}</span>
                    <h4 class="text-primary-dark-blue text-sm py-2">
                        <a href="#" class="font-bold hover:text-green-400">Bonoloto</a>
                    </h4>
                    <p class="text-neutral-grayish-blue text-xs py-2">
                        <span class="font-bold mr-2">{{ $bonoloto[0]->ball_0 }}</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->ball_1 }}</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->ball_2 }}</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->ball_3 }}</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->ball_4 }}</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->ball_5 }}</span>

                        <span class="font-bold p-1 border rounded-full bg-gray-100	">R</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->reinteger }}</span>

                        <span class="font-bold p-1 border rounded-full bg-gray-100	">C</span>
                        <span class="font-bold mr-2">{{ $bonoloto[0]->complementary }}</span>
                    </p>
                </div>
            </article>
        </div>
    </div>
</section>

@endsection