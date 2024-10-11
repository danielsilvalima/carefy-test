

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Importar CSV</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        
        
    </style>
</head>

<body>
    <div class="container">
        <div class="card my-5 border-light shadow">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">HOME</a></li>
                        <li class="breadcrumb-item " ><a href="/patient">PACIENTES</a></li>
                    </ol>

                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card my-5 border-light shadow">
            <h3 class="card-header">Importar Excel</h3>
            <div class="card-body">
                @session('success')
                    <div class="alert alert-success" role="alert">{!! $value !!}</div>
                @endsession

                @session('error')
                    <div class="alert alert-danger" role="alert">{!! $value !!}</div>
                @endsession

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('home.readingCSV') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="input-group my-4">
                        <input type="file" name="fileUpload" class="form-control" id="fileUpload" accept=".csv">
                        <button type="submit" class="btn btn-outline-info" id="fileBtn"><i
                                class="fa-solid fa-upload"></i> Ler CSV</button>
                                
                    </div>

                </form>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Dta Nascimento</th>
                            <th>Guia</th>
                            <th>Dta entrada</th>
                            <th>Dta saída</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient['codigo'] }}</td>
                                <td>{{ $patient['nome'] }}</td>
                                <td>{{ $patient['nascimento'] }}</td>
                                <td>{{ $patient['guia'] }}</td>
                                <td>{{ $patient['entrada'] }}</td>
                                <td>{{ $patient['saida'] }}</td>
                                <td class="{{ $patient['status'] == 'INVALIDO' ? 'text-danger' : 'text-success' }}"> {{ $patient['status'] }}</td>
                            </tr>                            
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('home.store') }}" method="POST">
                    @csrf

                    @foreach ($patients as $index => $patient)
                        <input type="hidden" name="patients[{{ $index }}][codigo]" value="{{ $patient['codigo'] }}">
                        <input type="hidden" name="patients[{{ $index }}][nome]" value="{{ $patient['nome'] }}">
                        <input type="hidden" name="patients[{{ $index }}][nascimento]" value="{{ $patient['nascimento'] }}">
                        <input type="hidden" name="patients[{{ $index }}][guia]" value="{{ $patient['guia'] }}">
                        <input type="hidden" name="patients[{{ $index }}][entrada]" value="{{ $patient['entrada'] }}">
                        <input type="hidden" name="patients[{{ $index }}][saida]" value="{{ $patient['saida'] }}">
                        <input type="hidden" name="patients[{{ $index }}][status]" value="{{ $patient['status'] }}">
                    @endforeach

                    <button type="submit" class="btn btn-outline-success" id="submit"> Gravar CSV</button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>

