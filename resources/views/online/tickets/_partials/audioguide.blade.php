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

            @if($item->product->site->site->has_brochure)
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


            @if($item->product->site->site->has_brochure)
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

                @if($item->product->site->site->has_brochure)
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

    <div style="margin-top:100px;">
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

            @if(isset($item->additional_code))
            <tr>
                @php
                $faHeadphones = "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"
                @endphp
                <td width="50%" align="left">
                    <img src="data:image/png;base64, {!! $faHeadphones !!}" style=" height: 12px; display: block; float: left; margin-top:4px" />
                    <span style=" height: 15px; display: block; float: left">&nbsp;: {{ $item->additional_code }}</span>
                </td>
            </tr>
        @endif

            @if($item->product->service->site && $item->product->service->site->has_brochure)
                <tr>
                    <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                        a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                        https://aditusculture.com/esperienze/{{ strtolower($item->product->site->site->city) }}/musei-parchi-archeologici/{{ $item->product->site->site->canonical_name }}?show=brochure
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
