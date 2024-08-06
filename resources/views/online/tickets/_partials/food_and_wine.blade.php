<div style="page-break-after: always;"></div>

<div style="margin-top:200px;">
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

        @if($item->product->service->site_id && $item->product->service->site->has_brochure)
            <tr>
                <td><br><br><b>BROCHURE</b><br>Per scaricare la brochure relativa
                    a {{ $item->product->service->site->name }} collegati al seguente link:<br>
                    https://aditusculture.com/esperienze/{{ strtolower($item->product->service->site->city) }}/musei-parchi-archeologici/{{ $item->product->service->site->canonical_name }}?show=brochure
                </td>
            </tr>
        @endif
    </table>
</div>
