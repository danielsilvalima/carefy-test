<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consulta de Pacientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .bg-label-primary {
            background-color: #eee6ff !important;
            color: #9055fd !important;
        }

        .bg-label-success {
            background-color: #eee6ff !important;
            color: #9055fd !important;
        }

        .bg-label-danger {
            background-color: #eee6ff !important;
            color: #9055fd !important;
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }
        .badge {
            line-height: 1.05;
        }
        
    </style>
</head>
    <div class="container">
        <div class="card my-5 border-light shadow">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">HOME</a></li>
                        <li class="breadcrumb-item " ><a href="/patient">PACIENTES</a></li>
                    </ol>

                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card my-5 border-light shadow">
            
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

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Dta Nascimento</th>
                            <th>Guia</th>
                            <th>Dta entrada</th>
                            <th>Dta saída</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient['code'] }}</td>
                                <td>{{ $patient['name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($patient['birth_at'])->format('d/m/Y') }}</td>
                                <td>{{ $patient['guide'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($patient['admission_at'])->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($patient['departure_at'])->format('d/m/Y') }}</td>
                            </tr>                            
                        @endforeach
                    </tbody>
                </table>

                

                <a type="button" href="/home" class="btn btn-outline-info" id="cancel"> CANCELAR</a>

            </div>
        </div>
    </div>