{{-- @if($item->product->printable)

    <div style="page-break-after: always;"></div>
    <div style="margin-top:80px;">
        <table style="width: 100%; vertical-align: top; font-size:13px;">
            <tr style="margin-top:5px;" align="left">
                <td style="font-family: 'montserrat'; font-size:16px;">{!! \App\Http\Helpers\Functions::replacePlaceHolder($item->product->coupon_text,$item) !!}</td>
            </tr>
        </table>
    </div>
    <div style="position: fixed; bottom: 350px; left: 0px; right: 0px;">
        <table style="width: 100%; vertical-align: top;">
            <tbody>
            @if($item->product->coupon_image)
                <tr align="center">
                    <td>
                        @if (env('APP_ENV') == "production")
                            <img src="{{$item->product->coupon_image}}" width="650">
                        @else
                            <img src="{{public_path().$item->product->coupon_image}}" width="650">
                        @endif
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endif --}}

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
                    - consente l'accesso a <strong>{{ $item->qty }}</strong> con ingresso alle
                    {{ \Carbon\Carbon::parse($item->hour_service)->format("H:i") }}
                    del {{ \Carbon\Carbon::parse($item->date_service)->format("d/m/Y") }}<br/>
                @else
                    - è valido <b>{{ $item->validity_from_issue_label }}</b> e consente l'accesso a <strong>{{ $item->qty }} persone</strong> a
                    partire
                    dal {{ \Carbon\Carbon::now()->format("d/m/Y H:i:s") }}<br/>
                    - consente <strong>1 solo accesso</strong> per ciascuna delle persone per cui è valido
                    il
                    codice, fino all'orario di chiusura del {{ $item->product->service->site->name }}<br/>
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
