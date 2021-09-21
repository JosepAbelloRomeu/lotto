<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    <body>
        <form action="{{ route('handle-result') }}" method="POST">
            @csrf
            @for ($i = 1; $i <= 15; $i++)
                <h3>Partido {{ $i }}</h3>
                <fieldset>
                    @for ($j = 1; $j <= 2; $j++)
                        <span>Equipo {{ $j }}</span>
                        <select class="js-example-basic-single" style="width: 200px" name="equipo-{{ $i }}-{{ $j }}"></select>
                    @endfor
                </fieldset>
            @endfor
            <input type="submit" value="Consultar">
        </form>

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
            });
        </script>
    </body>

</html>
