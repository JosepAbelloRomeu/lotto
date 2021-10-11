@extends('main')

@section('content')

<section class="header relative pt-16 items-center flex h-screen" style="max-height:860px">
    <div class="container mx-auto items-center flex flex-wrap">
        <div class="w-full md:w-8/12 lg:w-6/12 xl:w-6/12 px-4">
            <div class="pt-32 sm:pt-0">
                <h2 class="font-semibold text-4xl text-blueGray-600 pb-6">Última jornada</h2>
                <table>
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500 text-left" colspan="4">
                                <a href="{{ route('journey', $journey[0]->_id) }}" class="text-sm">Jornada {{ $journey[0]->working_day }}</a> · <span class="italic">{{ $journey[0]->league_date }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($matches as $match)
                            <tr class="whitespace-nowrap">
                                <td class="px-6 py-2 text-sm text-gray-500" >
                                    {{ $loop->iteration }}. {{ $match->local }} - {{ $match->visitor }}
                                </td>
                                @if($match->resultWithGoals)
                                    <td></td>
                                    <td></td>
                                    <td class="px-4 py-2 w-1/6 text-blue-900 font-bold text-right">{{ $match->resultWithGoals }}</td>
                                @else
                                    <td class="px-4 py-2 w-1/6 {{ $match->result == '1' ? 'text-blue-900 font-bold' : 'text-red-300' }} text-right">
                                        1
                                    </td>
                                    <td class="px-4 py-2 w-1/6 {{ $match->result == 'X' ? 'text-blue-900 font-bold' : 'text-red-300' }} text-right">
                                        X
                                    </td>
                                    <td class="px-4 py-2 w-1/6 {{ $match->result == '2' ? 'text-blue-900 font-bold' : 'text-red-300' }} text-right">
                                        2
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
