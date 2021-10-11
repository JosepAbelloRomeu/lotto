@extends('main')

@section('content')
    <section class="container mx-auto header relative pt-16 flex mt-5" style="max-height:860px">
        <table>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">Partido</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">getPrev</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">getPrev2</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">getBet</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($prevision as $match)
                    <tr class="whitespace-nowrap">
                        <td class="px-6 py-2 text-sm text-gray-500" >
                            {{ $loop->iteration }}. {{ $match['local'] }} - {{ $match['visitor'] }}
                        </td>
                        <td class="px-4 py-2 w-1/6 text-red-300 text-right">
                            {{ $match['result1'] }}
                        </td>
                        <td class="px-4 py-2 w-1/6 text-red-300 text-right">
                            {{ $match['result2'] }}
                        </td>
                        <td class="px-4 py-2 w-1/6 text-red-300 text-right">
                            {{ $match['result3'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
