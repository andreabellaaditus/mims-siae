<div style="page-break-after: always;"></div>

<div style="margin-top:250px;">
    <table style="width: 100%; vertical-align: top; font-size:13px;">
        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:30px;">
                <strong></strong><br/> SERVIZI AGGIUNTIVI
            </td>
        </tr>
        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;">Stampa il seguente codice per accedere ai servizi appena acquistati
            </td>
        </tr>
        <tr style="margin:50px 0px 50px 0px;" align="center">
            <td>
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($order->qr_code)) !!}">
            </td>
        </tr>
        <tr style="margin:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;"></td>

        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;">

                Di seguito troverai le istruzioni per usufruire al meglio i tuoi servizi

            </td>
        </tr>
    </table>
</div>