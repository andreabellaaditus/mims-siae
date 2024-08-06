<html>
<body style="font-family: 'montserrat'; font-size:12px; padding:0; margin:0;">
<div style="position: fixed; top: 10px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tr style="margin-top:5px;">
            <td colspan="2">
                <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/images/logo/logo_aditus_black_white.jpg"
                     alt="Aditus" height="50"/>
            </td>
        </tr>
    </table>
</div>

<div style="min-height: 200px; margin-top:190px;">&nbsp;</div>


<p style="font-family: 'montserrat'; font-size:14px; padding:0; margin:0;">
    Gentile
    <strong>{{ ((isset($order->user->client->business_name) && $order->user->client->business_name != "") ? $order->user->client->business_name : $order->user->first_name .' '. $order->user->last_name) }}</strong>,<br/>grazie
    per aver scelto Aditus S.r.l. per i tuoi acquisti.<br>
    Di seguito il riepilogo dei servizi acquistati in
    data {{ \Carbon\Carbon::parse($order->created_at)->format("d/m/Y") }} alle
    ore {{ \Carbon\Carbon::parse($order->created_at)->format("H:i:s") }}</p>

<div style="min-height: 200px; margin-top:40px;">&nbsp;</div>

<table style="width: 100%; vertical-align: top;" cellspacing='0' cellpadding='5'>
    <tr style="margin-top:5px;">
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;"><strong>Sito Archeologico/Polo
                Museale</strong></td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;"><strong>Tipologia</strong></td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;"><strong>Prezzo Unitario</strong></td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;"><strong>Quantità</strong></td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;" align='right'><strong>Totale</strong></td>
    </tr>
    @foreach($order->items as $item)
        @if ($item->product->service->product_category->name != "ticket")
            <tr style="margin-top:5px;">
                <td style="border: 1px solid #fff;">{!! $item->product->service->simple_name !!}</td>
                <td style="border: 1px solid #fff;">{!! $item->product->name !!}</td>
                <td style="border: 1px solid #fff;">{{ number_format($item->product->price_sale,2,",",".") }}&euro;</td>
                <td style="border: 1px solid #fff;">{{ $item->qty }}</td>
                <td style="border: 1px solid #fff;" align='right'>
                    {{ number_format($item->qty*$item->product->price_sale,2,",",".") }}&euro;
                </td>
            </tr>
        @endif
    @endforeach
</table>

<div style="min-height: 200px; margin-top:40px;">&nbsp;</div>

<div style="position: fixed; bottom: 100px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tbody>
        <tr style="margin-top:5px;" align="center">
            <td width="100%" align="left">
                <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/images/logo/logo_aditus_black_white.jpg"
                     alt="Aditus" height="50"/> <br/>
                Aditus S.r.l.<br/>
                Via Caboto, 35, 10129 Torino<br/>
                CF/P.IVA 09896500015
            </td>
        </tr>
        </tbody>
    </table>
</div>

@foreach($order->items as $item)
    @if ($item->product->service->product_category->name != "ticket")

        <div style="page-break-after: always;"></div>

        <div style="margin-top:250px;">
            <table style="width: 100%; vertical-align: top; font-size:13px;">
                <tr style="margin-top:5px;" align="center">
                    <td style="font-family: 'montserrat'; font-size:30px;">
                        <strong></strong><br/> {{ $item->product->name }}
                    </td>
                </tr>
                <tr style="margin-top:5px;" align="left">
                    <td style="font-family: 'montserrat'; font-size:16px;">Stampa il seguente codice per accedere
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
                        E' valido a partire dal <strong>{{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}</strong> e
                        consentirà un singolo accesso per <b>
                            {{$item->qty == 1 ? 'un\'unica persona' : ' un massimo di '.$item->qty.' persone'}}</b> fino
                        all'orario di chiusura.

                    </td>
                </tr>
            </table>
        </div>
    @endif
@endforeach

</body>
</html>
