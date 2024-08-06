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

<table style="width: 100%; vertical-align: top; font-size:13px;">
    <tr style="margin-top:5px;">
        <td width="50%" align="left" style='vertical-align: top;'>
            <strong>NUMERO ORDINE: </strong><?php echo $order->order_number ?><br/>
            <strong>DATA: </strong>
            <?php
            $order_date = new \Carbon\Carbon($order->created_at);
            $order_date_formatted = $order_date->format('d/m/Y');
            echo $order_date_formatted;
            ?>
        </td>
        <td width="50%" align="right">
            <?php
            if (isset($order->user->client->business_name) && $order->user->client->business_name != "") {
                echo $order->user->client->business_name . "<br>";
            } else {
                echo $order->user->first_name . " " . $order->user->last_name . "<br>";
            }
            if (isset($order->user->client->vat) && $order->user->client->vat != "") {
                echo "Partita IVA: " . $order->user->client->vat . "<br>";
            }
            if (isset($order->user->client->tax_code) && $order->user->client->tax_code != "") {
                echo "Codice Fiscale: " . $order->user->client->tax_code . "<br>";
            }

            if ($order->user->client->address != "" && $order->user->client->cap != "") {
                echo $order->user->client->address . " " . $order->user->client->cap . "<br>";
            }
            if ($order->user->client->address != "" && $order->user->client->cap == "") {
                echo $order->user->client->address . "<br>";
            }
            if ($order->user->client->address == "" && $order->user->client->cap != "") {
                echo $order->user->client->cap . "<br>";
            }
            echo $order->user->client->city . " " . $order->user->client->country->name . "<br>";
            echo $order->user->client->phone;
            ?>
        </td>
    </tr>
</table>

<p style="font-family: 'montserrat'; font-size:14px; padding:0; margin:0;">Gentile
    <strong>{{ ((isset($order->user->client->business_name) && $order->user->client->business_name != "") ? $order->user->client->business_name : $order->user->first_name) }}</strong>,<br/>grazie
    per aver scelto Aditus S.r.l. per i tuoi acquisti. Di seguito il riepilogo dei biglietti acquistati per l'ingresso
    ai poli archeologici e museali in data {{ \Carbon\Carbon::parse($order->created_at)->format("d/m/Y") }} alle
    ore {{ \Carbon\Carbon::parse($order->created_at)->format("H:i:s") }}:</p>

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
        @if ($item->product->service->product_category->name == "ticket" || $item->product->service->is_special_ticket)
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
    @if($order->bollo > 0)
        <tr style="margin-top:5px;">
            <td colspan="4" style="border: 1px solid #fff;">Imposta di bollo</td>
            <td align='right'><strong>{{ number_format($order->bollo,2,",",".") }}&euro;</strong>
            </td>
        </tr>
    @endif
    <tr>
        <td class="text-right" colspan="4"><strong>Totale Ordine</strong></td>
        <td align='right' class="text-right" style="border: 1px solid #fff; background:#8c7d70; color:#fff;"><strong>{{ number_format($order->price,2,",",".") }}&euro;</strong></td>
    </tr>
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
    @if ($item->product->service->product_category->name == "ticket")
        @if ($item->is_cumulative)
            <div style="page-break-after: always;"></div>

            <div style="margin-top:250px;">
                <table style="width: 100%; vertical-align: top; font-size:13px;">
                    <tr style="margin-top:5px;" align="center">
                        <td style="font-family: 'montserrat'; font-size:30px;">
                            <strong>{{ $item->product->service->site->name }}</strong><br/>Biglietto {{ $item->product->name }}
                        </td>
                    </tr>
                    <tr style="margin:50px 0px 50px 0px;" align="center">
                        <td>
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($item->printable_qr_code)) !!}">
                        </td>
                    </tr>
                    <tr style="margin:5px;" align="center">
                        <td style="font-family: 'montserrat'; font-size:16px;">{{ $item->printable_matrix }}</td>
                    <tr style="margin-top:5px;" align="left">
                        <td style="font-family: 'montserrat'; font-size:16px;">Stampa il tuo biglietto per accedere
                            direttamente al controllo accessi del {{ $item->product->service->site->name }}, senza far code
                            alla cassa
                        </td>
                    </tr>
                    <tr style="margin-top:5px;" align="left">
                        <td style="font-family: 'montserrat'; font-size:16px;">
                            Il seguente biglietto<br/>
                            - ha un codice univoco che sarà rilevato direttamente al controllo accessi<br/>
                            - è valido per <strong>{{ $item->qty }} persone</strong> a partire
                            dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>
                            - consente <strong>1 solo accesso</strong> per ciascuna delle persone per cui è valido il
                            codice, fino all'orario di chiusura del {{ $item->product->service->site->name }}<br/>
                            - non è rimborsabile<br/>
                            - in caso di biglietto ridotto o gratuito, al controllo accessi
                            del {{ $item->product->service->site->name }} verrà richiesta la titolarità della riduzione o
                            della gratuità che dovrà essere dimostrata esibendo il documento relativo.
                        </td>
                    </tr>
                </table>
            </div>
        @else
            @if($item->scans)

                @foreach($item->scans as $scan)
                    <div style="page-break-after: always;"></div>

                    <div style="margin-top:250px;">
                        <table style="width: 100%; vertical-align: top; font-size:13px;">
                            <tr style="margin-top:5px;" align="center">
                                <td style="font-family: 'montserrat'; font-size:30px;">
                                    <strong>{{ $item->product->service->site->name }}</strong><br/>Biglietto {{ $item->product->name }}
                                </td>
                            </tr>
                            <tr style="margin:50px 0px 50px 0px;" align="center">
                                <td>
                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($scan->qr_code)) !!}">
                                </td>
                            </tr>
                            <tr style="margin:5px;" align="center">
                                <td style="font-family: 'montserrat'; font-size:16px;">{{ $scan->virtual_store_matrix->code.".".($scan->virtual_store_matrix->progressive*1).".".$scan->virtual_store_matrix->year }}</td>
                            <tr style="margin-top:5px;" align="left">
                                <td style="font-family: 'montserrat'; font-size:16px;">Stampa il tuo biglietto per
                                    accedere
                                    direttamente al controllo accessi del {{ $item->product->service->site->name }}, senza
                                    far
                                    code alla cassa
                                </td>
                            </tr>
                            <tr style="margin-top:5px;" align="left">
                                <td style="font-family: 'montserrat'; font-size:16px;">
                                    Il seguente biglietto<br/>
                                    - ha un codice univoco che sarà rilevato direttamente al controllo accessi<br/>
                                    - è valido per <strong>1 persona</strong> a partire
                                    dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>
                                    - consente 1 singolo accesso, fino all'orario di chiusura
                                    del {{ $item->product->service->site->name }}, nello stesso giorno in cui è stato
                                    validato
                                    dal controllo accessi<br/>
                                    - non è rimborsabile<br/>
                                    - in caso di biglietto ridotto o gratuito, al controllo accessi
                                    del {{ $item->product->service->site->name }} verrà richiesta la titolarità della
                                    riduzione
                                    o della gratuità che dovrà essere dimostrata esibendo il documento relativo.
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @else
                NO SCANS {{$item->id}}
            @endif
        @endif
    @endif
@endforeach
@if($order->special_ticket_item->count() > 0)
    @include('online.tickets._partials.special_ticket_intro')
    @foreach($order->special_ticket_item as $item)
        @if ($item->product->code == 'SERV0015/1' )
            @include('online.tickets._partials.saltafila')
        @else
            @include('online.tickets._partials.special_ticket')
        @endif
    @endforeach
@endif
</body>
</html>
