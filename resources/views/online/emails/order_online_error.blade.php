<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Email - Ticketing Online</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600" rel="stylesheet"
          type="text/css">

    <!-- Styles -->
    <style>
        table {
            width: 100%;
            vertical-align: top;
        }

        table tr {
            margin-top: 5px;
        }

        .table-header, .table-event {
            font-size: 11px;
        }

        .bordered {
            border: 1px solid #fff;
        }

        .bordered-header {
            background: #8c7d70;
            color: #fff;
        }

        .bordered-total {
            background: #c0c0c0;
        }
    </style>
</head>

<body>
<div id="app" class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/images/logo/logo_aditus_black_white.jpg" alt="Aditus" height="50"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <span class="acceptation1">
                <h4>Attenzione,</h4>
                <p>c'è stato un problema con un ordine a nome di <strong>{{ $user->last_name ?? '' }} {{ $user->first_name ?? '' }}</strong> creato il {{ \Carbon\Carbon::now()->format("d/m/Y") }} alle ore {{ \Carbon\Carbon::now()->format("H:i:s") }}.<br/><br>
                Questo l'errore riscontrato:<br>
                    @isset($error)
                        <strong>{{ $error }}</strong><br>
                    @endisset
                </p><br/><br/>

            </span>
        </div>
    </div>
    <br/>
    <br/>

</div>

</body>
</html>
