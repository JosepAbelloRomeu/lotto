@extends('main')

@section('content')

    <div class="main mt-16">
        <section class="container mx-auto header relative pt-16 flex h-screen mt-5">
            <div class="grid grid-cols-3 gap-1">
                <form action="{{ route('handle-result') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        @for ($i = 1; $i <= 15; $i++)
                            <fieldset class="mb-2">
                                <span>{{ $i }}. </span>
                                @for ($j = 1; $j <= 2; $j++)
                                    <select class="js-example-basic-single" style="width: 200px" name="equipo-{{ $i }}-{{ $j }}"></select>
                                    @if($j == 1) v.s. @endif
                                @endfor
                            </fieldset>
                        @endfor
                    </div>
                    <div class="options mb-8">
                        <label for="column-select">Columnas</label>
                        <select id="column-select">
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <input class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow cursor-pointer" type="submit" value="Generar">
                </form>
                <div id="columns" class="col-span-2">
                    <h4 class="mb-6">Pronóstico de columnas</h4>
                    <div id="column-rows"></div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                ajax: {
                    delay: 250,
                    url: "{{ route('teams-ajax') }}",
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

            $( "#column-select" ).change(function() {
                $('#column-rows').empty();
                let columns = $('#column-select option:selected').val();
                for (let i = 1; i <= columns; i++) {
                    let field = '<div class="block mb-3 column-row">Columna '+i+'</div>';
                    $('#column-rows').append(field);
                }
            });

        });
    </script>
@endsection
