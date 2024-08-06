<html>
<body style="font-family: 'montserrat'; font-size:12px; padding:0; margin:0;">
<div style="position: fixed; top: 10px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tr style="margin-top:5px;">
            <td colspan="2" align="center">
                <img src="{{ $company->detailAbout->logo }}" alt="{{ $company->name }}" height="50"/>
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

            if (isset($order->user->client) && $order->user->client->address != "" && $order->user->client->cap != "") {
                echo $order->user->client->address . " " . $order->user->client->cap . "<br>";
            }
            if (isset($order->user->client) && $order->user->client->address != "" && $order->user->client->cap == "") {
                echo $order->user->client->address . "<br>";
            }
            if (isset($order->user->client) && $order->user->client->address == "" && $order->user->client->cap != "") {
                echo $order->user->client->cap . "<br>";
            }
            if(isset($order->user->client)) {
                echo $order->user->client->city . " " . $order->user->client->country->name . "<br>";
                echo $order->user->client->phone;
            }
            ?>
        </td>
    </tr>
</table>

<p style="font-family: 'montserrat'; font-size:14px; padding:0; margin:0;">Gentile
    <strong>{{ ((isset($order->user->client->business_name) && $order->user->client->business_name != "") ? $order->user->client->business_name : $order->user->first_name) }}</strong>,<br/>grazie
    per aver scelto {{ $company->name }} per i tuoi acquisti. Di seguito il riepilogo dei biglietti acquistati per l'ingresso
    ai poli archeologici e museali in data {{ \Carbon\Carbon::parse($order->created_at)->format("d/m/Y") }} alle
    ore {{ \Carbon\Carbon::parse($order->created_at)->format("H:i:s") }}</p>

<div style="min-height: 200px; margin-top:40px;">&nbsp;</div>

<table style="width: 100%; vertical-align: top;" cellspacing='0' cellpadding='5'>
    <tr style="margin-top:5px;">
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:50%">
            <strong>Sito Archeologico/Polo Museale/Evento</strong>
        </td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:20%;">
            <strong>Tipologia</strong>
        </td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:10%;text-align: center">
            <strong>Prezzo Unitario</strong>
        </td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:10%;text-align: center">
            <strong>Qty</strong>
        </td>
        <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:10%;" align='right'>
            <strong>Totale</strong>
        </td>
    </tr>
    @php $fees = 0; @endphp
    @foreach(\App\Http\Helpers\Ecommerce::orderRecap($order) as $item)
        @php $fees += $item->fees; @endphp
        <tr style="margin-top:5px;">
            <td style="border: 1px solid #fff;width:50%;">{!! $item->product->service->simple_name !!}</td>
            <td style="border: 1px solid #fff;width:20%;">{!! $item->product->name !!}</td>
            <td style="border: 1px solid #fff;width:10%;text-align: center">
                @if ($item->product->service->product_category->name == "event")
                {{ number_format($item->product->price_web,2,",",".") }}&euro;
                @else
                {{ number_format($item->product->price_sale,2,",",".") }}&euro;
                @endif
            </td>
            <td style="border: 1px solid #fff;width:10%;text-align: center">{{ $item->qty }}</td>
            <td style="border: 1px solid #fff;width:10%;" align="right">
                @if ($item->product->service->product_category->name == "event")
                {{ number_format($item->qty*$item->product->price_web,2,",",".") }}&euro;
                @else
                {{ number_format($item->qty*$item->product->price_sale,2,",",".") }}&euro;
                @endif
            </td>
        </tr>
    @endforeach

    @if($fees > 0)
        <tr style="margin-top:5px;">
            <td colspan="4" style="border: 1px solid #fff;">Commissioni di servizio</td>
            <td align='right'><strong>{{ number_format($fees,2,",",".") }}&euro;</strong>
            </td>
        </tr>
    @endif

    @if($order->bollo > 0)
        <tr style="margin-top:5px;">
            <td colspan="4" style="border: 1px solid #fff;">Imposta di bollo</td>
            <td align='right'><strong>{{ number_format($order->bollo,2,",",".") }}&euro;</strong>
            </td>
        </tr>
    @endif
    <tr>
        <td class="text-right" colspan="4"><strong>Totale Ordine</strong></td>
        <td align='right' class="text-right" style="border: 1px solid #fff; background:#8c7d70; color:#fff;"><strong>{{ number_format($order->price + $order->bollo,2,",",".") }}&euro;</strong>
        </td>
    </tr>
</table>

<div style="min-height: 200px; margin-top:40px;">&nbsp;</div>

<div style="position: fixed; bottom: 80px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tbody>
        <tr style="margin-top:5px;" align="center">
            <td width="100%" align="left">
                <table>
                    <tr>
                        <td width="1"><img src="{{ $company->detailAbout->logo }}"
                                 alt="{{ $company->name }}" height="50"/> </td>
                        <td>
                            {{ $company->name }}<br/>
                            {{ $company->detailAbout->address }}, {{ $company->detailAbout->cap }}, {{ $company->detailAbout->city }}<br/>
                            CF/P.IVA  {{ $company->detailAbout->tax_code }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

@foreach($order->items as $item)
    @if ($item->product->service->product_category->name == "ticket")
        @if ($item->is_cumulative)
            <div style="page-break-after: always;"></div>

            <div style="margin-top:80px;">
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
                        <td style="font-family: 'montserrat'; font-size:16px;">Stampa il tuo biglietto o mostralo in
                            formato digitale per accedere
                            direttamente al controllo accessi del {{ $item->product->service->site->name }}, senza far code
                            alla cassa.

                        </td>
                    </tr>
                    <tr style="margin-top:5px;" align="left">
                        <td style="font-family: 'montserrat'; font-size:16px;">
                            Il seguente biglietto<br/>
                            - ha un codice univoco che sarà rilevato direttamente al controllo accessi<br/>
                            @if($item->product->site->site->availability_enabled && $item->date_service && $item->hour_service)
                                - consente l'accesso a <strong>{{ $item->qty }}</strong> con ingresso alle {{ \Carbon\Carbon::parse($item->hour_service)->format("H:i") }} del {{ \Carbon\Carbon::parse($item->date_service)->format("d/m/Y") }}<br/>
                                - è tollerato un ritardo sull'orario di ingresso di 30 minuti compatibilmente con gli orari di ingresso del sito<br/>
                            @else
                                - è valido <b>{{ $item->validity_from_issue_label }}</b> e consente l'accesso a <strong>{{ $item->qty }} persone</strong> a partire dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>
                                - consente <strong>1 solo accesso</strong> per ciascuna delle persone per cui è valido il codice, fino all'orario di chiusura del {{ $item->product->service->site->name }}<br/>
                            @endif
                            - in caso di biglietto ridotto o gratuito fornire anche il documento che attesti il diritto alla riduzione richiesta<br/>
                            - non è rimborsabile<br/>
                        </td>
                    </tr>

                    @if($item->product->site->site->has_brochure)
                        <tr>
                            <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                                a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                                https://aditusculture.com/esperienze/{{ strtolower($item->product->site->site->city) }}/musei-parchi-archeologici/{{ $item->product->site->site->canonical_name }}?show=brochure
                            </td>
                        </tr>
                    @endif


                    @if(isset($order->user->client->role->code) && $order->user->client->role->code == 'travel-agency' && \App\Http\Helpers\Functions::isAgencySpecialTickets($item->product->id))
                    <tr>
                        <td><br><br>Il presente biglietto è stato stampato per conto dell'agenzia <b>{{$order->user->client->business_name}}</b></td>
                    </tr>
                    @endif
                </table>
            </div>
        @else
            @if($item->scans)
                @php $index = 0; @endphp
                @foreach($item->scans as $scan)
                    <div style="page-break-after: always;"></div>

                    <div style="margin-top:80px;">
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
                                <td style="font-family: 'montserrat'; font-size:16px;">{{ $scan->virtual_store_matrix->code.".".str_pad($scan->virtual_store_matrix->progressive*1,7,0,STR_PAD_LEFT).".".$scan->virtual_store_matrix->year }}</td>
                            <tr style="margin-top:5px;" align="left">
                                <td style="font-family: 'montserrat'; font-size:16px;">Stampa il tuo biglietto o
                                    mostralo in formato digitale per accedere
                                    direttamente al controllo accessi del {{ $item->product->service->site->name }}, senza
                                    far code
                                    alla cassa
                                </td>
                            </tr>
                            <tr style="margin-top:5px;" align="left">
                                <td style="font-family: 'montserrat'; font-size:16px;">
                                    Il seguente biglietto<br/>
                                    - ha un codice univoco che sarà rilevato direttamente al controllo accessi<br/>
                                    @if($item->product->site->site->availability_enabled && $item->date_service && $item->hour_service)
                                        - consente l'accesso {{ $item->product->is_card ? 'illimitato ' : '' }}a <strong>
                                            @if($scan->order_item_reduction)
                                                {{$scan->order_item_reduction->last_name}} {{$scan->order_item_reduction->first_name}}
                                            @else
                                                1 persona
                                            @endif
                                        </strong>
                                        @if ($item->product->is_card)
                                            e ha una durata di {{ $item->product->validity_from_burn_value }} {{ $item->product->validity_from_burn_unit == 'months' ? 'Mesi' : ($item->product->validity_from_burn_unit == 'days' ? 'Giorni' : 'Settimane') }} a partire dal primo accesso<br />
                                        @else
                                            </strong> con ingresso alle
                                            {{ \Carbon\Carbon::parse($item->hour_service)->format("H:i") }}
                                            del {{ \Carbon\Carbon::parse($item->date_service)->format("d/m/Y") }}<br/>
                                            - è tollerato un ritardo sull'orario di ingresso
                                            di {{$item->product->site->site->availability_tollerance}} minuti
                                            compatibilmente con gli orari di ingresso del sito<br/>
                                        @endif
                                    @else
                                        - è valido <b>{{ $item->validity_from_issue_label }}</b> e consente l'accesso a <strong>
                                            @if($scan->order_item_reduction)
                                                {{$scan->order_item_reduction->last_name}} {{$scan->order_item_reduction->first_name}}
                                            @else
                                                1 persona
                                            @endif
                                        </strong> a partire
                                        dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>
                                        - consente 1 singolo accesso, fino all'orario di chiusura
                                        del {{ $item->product->service->site->name }}, nello stesso giorno in cui è stato
                                        validato dal controllo accessi<br/>
                                    @endif

                                    - non è rimborsabile<br/>

                                    @if($item->product->site->site->access_control_enabled)
                                        <b>
                                            - in caso di biglietto ridotto o gratuito rivolgersi al personale di
                                            accoglienza per
                                            la conferma della titolarità della riduzione
                                            o della gratuità che dovrà essere dimostrata esibendo il documento
                                            relativo.</b>
                                    @else
                                        - in caso di biglietto ridotto o gratuito, al controllo accessi
                                        del {{ $item->product->service->site->name }} verrà richiesta la titolarità della
                                        riduzione
                                        o della gratuità che dovrà essere dimostrata esibendo il documento relativo.<br />
                                    @endif


                                    @if (count($item->product_holders))
                                        - Titolare:<br />
                                        @foreach($item->product_holders as $product_holder)
                                            @if ($loop->index == $index)
                                                <b>{{ $product_holder->first_name }} {{ $product_holder->last_name }}</b><br />
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            @if($item->product->site->site->has_brochure)
                                <tr>
                                    <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                                        a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                                        https://aditusculture.com/esperienze/{{ strtolower($item->product->site->site->city) }}/musei-parchi-archeologici/{{ $item->product->site->site->canonical_name }}?show=brochure
                                    </td>
                                </tr>
                            @endif

                            @if(isset($order->user->client->role->code) && $order->user->client->role->code == 'travel-agency' && \App\Http\Helpers\Functions::isAgencySpecialTickets($item->product->id))
                            <tr>
                                <td><br><br>Il presente biglietto è stato stampato per conto dell'agenzia <b>{{$order->user->client->business_name}}</b></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    @php $index++; @endphp
                @endforeach
            @else
                NO SCANS {{$item->id}}
            @endif
        @endif
    @elseif (in_array($item->product->service->product_category->name,["service","city-tour"]))
        @include('online.tickets._partials.service')
    @elseif (in_array($item->product->service->product_category->name,["event","exhibition"]))
        @include('online.tickets._partials.exhibition')
    @elseif ($item->product->service->product_category->name == "food-and-wine")
        @include('online.tickets._partials.food_and_wine')
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

@if($order->event_items->count() > 0)
    @foreach($order->event_scans as $scan)
        @include('online.tickets._partials.event_ticket')
    @endforeach
@endif
</body>
</html>
