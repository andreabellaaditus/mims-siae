<html>
<body style="font-family: 'montserrat'; font-size:12px; padding:0; margin:0;">
<div style="position: fixed; top: 10px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tr style="margin-top:5px;">
            @if (isset($currentDomain) && $currentDomain == "galata")
                <td width="30%" align="left">
                    <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/muma/logo-muma-esteso.jpg" height="50" />
                </td>
                <td width="30%" align="center">
                    <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/muma/logo-galata-img.png" height="80" />
                </td>
                <td width="30%" align="right">
                    <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/muma/logo-comune-di-genova.png" height="50" />
                    <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/muma/logo-musei-di-genova.png" height="40">
                </td>
            @else
                <td colspan="2">
                    <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/images/logo/logo_aditus_black_white.jpg" alt="Aditus" height="50"/>
                </td>
            @endif
        </tr>
    </table>
</div>
@if (isset($currentDomain) && $currentDomain == "galata")
<div style="position: fixed; bottom: 70px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tr style="margin-top:5px;">
            <td width="25%" align="center">
                <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/muma/logo-cns.png" alt="CNS" height="50"/>
            </td>
            <td width="25%" align="center">
                <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/images/logo/logo_aditus_orizzontale_bianco.png" alt="Aditus" height="50"/>
            </td>
            <td width="25%" align="center">
                <img src="https://storage.googleapis.com/thekey-ticketing.appspot.com/muma/logo-socioculturale.png" alt="SocioCulturale" height="50"/>
            </td>
            <td width="25%" align="right">
                <strong>GALATA MUSEO DEL MARE</strong><br/>
                Calata De Mari, 1 16126 Genova<br />
                www.galatamuseodelmare.it
            </td>
        </tr>
    </table>
</div>
@endif
@php $pageCounter = 1; @endphp
@foreach($items as $item)
    @if ($item->product->service->product_category->slug == "tickets")
        @if($pageCounter > 1)
            <div style="page-break-after: always;"></div>
        @endif
        @if ($item->is_cumulative)

            <div style="margin-top:150px;">
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


                            @if($item->product->service->site->availability_enabled && $item->date_service && $item->hour_service)
                                - consente l'accesso a <strong>{{ $item->qty }}</strong> con ingresso alle
                                {{ \Carbon\Carbon::parse($item->hour_service)->format("H:i") }}
                                del {{ \Carbon\Carbon::parse($item->date_service)->format("d/m/Y") }}<br/>
                                - è tollerato un ritardo sull'orario di ingresso
                                di {{$item->product->service->site->availability_tollerance}} minuti compatibilmente con
                                gli orari di ingresso del sito<br/>
                            @else
                                - è valido 6 mesi e consente l'accesso a <strong>{{ $item->qty }} persone</strong> a
                                partire
                                dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>
                                - consente <strong>1 solo accesso</strong> per ciascuna delle persone per cui è valido
                                il
                                codice, fino all'orario di chiusura del {{ $item->product->service->site->name }}<br/>
                            @endif
                            - non è rimborsabile<br/>
                            @if($item->product->service->site->access_control_enabled)
                                - in caso di biglietto ridotto o gratuito rivolgersi al personale di accoglienza per
                                la conferma della titolarità della riduzione
                                o della gratuità che dovrà essere dimostrata esibendo il documento relativo.
                            @else
                                - in caso di biglietto ridotto o gratuito, al controllo accessi
                                del {{ $item->product->service->site->name }} verrà richiesta la titolarità della riduzione
                                o della gratuità che dovrà essere dimostrata esibendo il documento relativo.
                            @endif
                        </td>
                    </tr>

                    @if($item->product->service->site->has_brochure)
                        <tr>
                            <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                                a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                                https://aditusculture.com/esperienze/{{ strtolower($item->product->service->site->city) }}/musei-parchi-archeologici/{{ $item->product->service->site->canonical_name }}?show=brochure
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        @else
            @if($item->scans)

                @php $index = 0; @endphp
                @foreach($item->scans as $scan)
                    @if($index > 0)
                        <div style="page-break-after: always;"></div>
                    @endif
                    <div style="margin-top:150px;">
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
                                <td style="font-family: 'montserrat'; font-size:16px;">Stampa il tuo biglietto o mostralo in formato digitale per accedere direttamente al controllo accessi del {{ $item->product->service->site->name }}, senza far code alla cassa
                                </td>
                            </tr>
                            <tr style="margin-top:5px;" align="left">
                                <td style="font-family: 'montserrat'; font-size:16px;">
                                    Il seguente biglietto<br/>
                                    - ha un codice univoco che sarà rilevato direttamente al controllo accessi<br/>
                                    @if($item->product->service->site->availability_enabled && $item->date_service && $item->hour_service)
                                        - consente l'accesso  {{ $item->product->is_card ? 'illimitato ' : '' }}a <strong>
                                            @if($scan->order_item_reduction)
                                                {{$scan->order_item_reduction->last_name}} {{$scan->order_item_reduction->first_name}}
                                            @else
                                                1 persona
                                            @endif
                                        </strong>
                                        @if ($item->product->is_card)
                                            e ha una durata di {{ $item->product->validity_from_burn_value }} {{ $item->product->validity_from_burn_unit == 'months' ? 'Mesi' : ($item->product->validity_from_burn_unit == 'days' ? 'Giorni' : 'Settimane') }} a partire dal primo accesso<br />
                                        @else
                                            con ingresso alle {{ \Carbon\Carbon::parse($item->hour_service)->format("H:i") }} del {{ \Carbon\Carbon::parse($item->date_service)->format("d/m/Y") }}<br/>

                                            - è tollerato un ritardo sull'orario di ingresso di  {{ $item->product->service->site->availability_tollerance }} minuti compatibilmente con gli orari di ingresso del sito<br/>
                                        @endif
                                    @else
                                        - è valido fino al {{ \Carbon\Carbon::parse($item->validity)->format("d/m/Y") }}  e consente l'accesso a
                                        <strong>
                                            @if($scan->order_item_reduction)
                                                {{ $scan->order_item_reduction->last_name }} {{ $scan->order_item_reduction->first_name }}
                                            @else
                                                1 persona
                                            @endif
                                        <strong>
                                        a partire dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>

                                        - consente 1 singolo accesso, fino all'orario di chiusura del {{ $item->product->service->site->name }}, nello stesso giorno in cui è stato validato dal controllo accessi<br/>
                                    @endif

                                    - non è rimborsabile<br/>

                                    @if($item->product->service->site->access_control_enabled)
                                        <b>- in caso di biglietto ridotto o gratuito rivolgersi al personale di accoglienza per la conferma della titolarità della riduzione o della gratuità che dovrà essere dimostrata esibendo il documento relativo.</b>
                                    @else
                                        - in caso di biglietto ridotto o gratuito, al controllo accessi del {{ $item->product->service->site->name }} verrà richiesta la titolarità della riduzione o della gratuità che dovrà essere dimostrata esibendo il documento relativo.<br />
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
                            @if($item->product->service->site->has_brochure)
                                <tr>
                                    <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                                        a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                                        https://aditusculture.com/esperienze/{{ strtolower($item->product->service->site->city) }}/musei-parchi-archeologici/{{ $item->product->service->site->canonical_name }}?show=brochure
                                    </td>
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
    @elseif (in_array($item->product->service->product_category->name, ["service","city-tour"]))
        @include('online.tickets._partials.service')
    @elseif ($item->product->service->product_category->slug == "exhibitions")
        @include('online.tickets._partials.exhibition')
    @elseif ($item->product->service->product_category->slug == "food-and-wine")
        @include('online.tickets._partials.food_and_wine')
    @elseif ($item->product->service->product_category->slug == "audioguides")
        @include('online.tickets._partials.audioguide')
    @elseif ($item->product->service->product_category->slug == "site-events")
        @include('online.tickets._partials.event_ticket')
    @endif

    @php  $pageCounter++; @endphp
@endforeach

<?php
/*@if($order->special_ticket_item->count() > 0)
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
@endif*/
?>

</body>
</html>
