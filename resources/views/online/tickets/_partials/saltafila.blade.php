<div style="page-break-after: always;"></div>

<div style="margin-top:250px;">
    <table style="width: 100%; vertical-align: top; font-size:13px;">
        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:30px;">
                <strong></strong><br/> {{ $item->product->name }}
            </td>
        </tr>
        <tr style="margin-top:5px;" align="left">
            <td style="font-family: 'montserrat'; font-size:16px;">Stampa il seguente codice per
                accedere
                direttamente al controllo accessi del <b>Teatro Antico di Taormina</b>, senza far code
                alle casse
            </td>
        </tr>
        <tr style="margin:50px 0px 50px 0px;" align="center">
            <td>
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($item->printable_qr_code)) !!}">
            </td>
        </tr>
        <tr style="margin:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;"></td>

        <tr style="margin-top:5px;" align="left">
            <td style="font-family: 'montserrat'; font-size:16px;">


                Il codice quì presente è univoco e sarà rilevato direttamente al controllo accessi.<br>
                E' valido a partire dal
                <strong>{{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}</strong> e consentirà un
                singolo accesso per <b>
                    {{$item->qty == 1 ? 'un\'unica persona' : ' un massimo di '.$item->qty.' persone'}}</b>
                fino all'orario di chiusura.

            </td>
        </tr>
    </table>
</div>