@if ($item->is_cumulative)
    <div style="page-break-after: always;"></div>
    <div style="margin-top:80px;">
        <table style="width: 100%; vertical-align: top; font-size:13px;">
            <tr style="margin-top:5px;" align="center">
                <td style="font-family: 'montserrat'; font-size:30px;">
                    <strong>{{ $item->product->service->name }}</strong><br/>{{ $item->product->name }}
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
                <td style="font-family: 'montserrat'; font-size:16px;">{{ \App\Http\Helpers\Functions::replacePlaceHolder($item->product->coupon_text,$item) }}</td>
            </tr>

            @if($item->product->service->site_id && $item->product->service->site->has_brochure)
                <tr>
                    <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                        a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                        https://aditusculture.com/esperienze/{{ strtolower($item->product->site->site->city) }}/musei-parchi-archeologici/{{ $item->product->site->site->canonical_name }}?show=brochure
                    </td>
                </tr>
            @endif
        </table>
    </div>
@elseif($item->product->bundle)

    <div style="page-break-after: always;"></div>

    <div style="margin-top:80px;">
        <table style="width: 100%; vertical-align: top; font-size:13px;">
            <tr style="margin-top:5px;" align="center">
                <td style="font-family: 'montserrat'; font-size:30px;">
                    <strong>{{ $item->product->service->name }}</strong><br>
                    {{ $item->product->name }}
                </td>
            </tr>
            <tr style="margin:50px 0px 50px 0px;" align="center">
                <td>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($item->printable_qr_code)) !!}">
                </td>
            </tr>
            <tr style="margin-top:5px;" align="left">
                <td style="font-family: 'montserrat'; font-size:16px;">{!! \App\Http\Helpers\Functions::replacePlaceHolder($item->product->coupon_text,$item) !!}</td>
            </tr>

            @if(count($item->bundle_items) > 0)
                <tr style="margin-top:5px;" align="center">
                    <td style="font-family: 'montserrat'; font-size:20px;">INFO AGGIUNTIVE SUI SERVIZI ACQUISTATI</td>
                </tr>
                @foreach($item->bundle_items as $bundleItem)
                    @php
                        if($bundleItem->date_service && $bundleItem->hour_service)
                          $bundleSlot = Carbon\Carbon::parse($bundleItem->date_service." ".$bundleItem->hour_service);
                    @endphp
                    @if(isset($bundleSlot))
                        <tr>
                            <td>
                                <b>{{ $bundleItem->deliverable->name }}: </b>{{$bundleSlot->format('d/m/Y')}}
                                alle {{$bundleSlot->format('H:i')}}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif


            @if($item->product->service->site_id && $item->product->service->site->has_brochure)
                <tr>
                    <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                        a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                        https://aditusculture.com/esperienze/{{ strtolower($item->product->site->site->city) }}/musei-parchi-archeologici/{{ $item->product->site->site->canonical_name }}?show=brochure
                    </td>
                </tr>
            @endif
        </table>
    </div>
@elseif(count($item->scans) > 0)

    @foreach($item->scans as $scan)
        <div style="page-break-after: always;"></div>

        <div style="margin-top:200px;">
            <table style="width: 100%; vertical-align: top; font-size:13px;">
                <tr style="margin-top:5px;" align="center">
                    <td style="font-family: 'montserrat'; font-size:30px;">
                        <strong>{{ $item->product->service->name }}</strong><br/>Biglietto {{ $item->product->name }}
                    </td>
                </tr>
                <tr style="margin:50px 0px 50px 0px;" align="center">
                    <td>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($scan->qr_code)) !!}">
                    </td>
                </tr>
                <tr style="margin-top:5px;" align="left">
                    <td style="font-family: 'montserrat'; font-size:16px;">{!! \App\Http\Helpers\Functions::replacePlaceHolder($item->product->coupon_text,$scan) !!}</td>
                </tr>

                @if($item->product->service->site_id && $item->product->service->site->has_brochure)
                    <tr>
                        <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                            a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                            https://aditusculture.com/esperienze/{{ strtolower($item->product->site->site->city) }}/musei-parchi-archeologici/{{ $item->product->site->site->canonical_name }}?show=brochure
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    @endforeach
@elseif($item->product->printable)
    <div style="page-break-after: always;"></div>
    <div style="margin-top:80px;">
        <table style="width: 100%; vertical-align: top; font-size:13px;">
            <tr style="margin-top:5px;" align="center">
                <td style="font-family: 'montserrat'; font-size:30px;">
                    <strong>{{ $item->product->service->name }}</strong><br/>{{ $item->product->name }}
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
                <td style="font-family: 'montserrat'; font-size:16px;">{!! \App\Http\Helpers\Functions::replacePlaceHolder($item->product->coupon_text,$item) !!}</td>
            </tr>

            @if($item->product->service->site && $item->product->service->site->has_brochure)
                <tr>
                    <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                        a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                        https://aditusculture.com/esperienze/{{ strtolower($item->product->service->site->city) }}/musei-parchi-archeologici/{{ $item->product->service->site->canonical_name }}?show=brochure
                    </td>
                </tr>
            @endif
        </table>
    </div>
    <div style="position: fixed; bottom: 300px; left: 0px; right: 0px;">
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
@endif
