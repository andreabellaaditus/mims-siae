<div style="page-break-after: always;"></div>

<div style="margin-top:150px;">
    <table style="width: 100%; vertical-align: top; font-size:13px;">
        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:30px;">
                <strong>{{ $item->product->service->name }}</strong><br/> {{ $item->product->name }}
            </td>
        </tr>
        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;">{!! $item->product->service->coupon_text !!}
            </td>
        </tr>
        @if($item->product->service->coupon_image)
        <tr style="margin:50px 0px 50px 0px;" align="center">
            <td>
                <img src="{{public_path().$item->product->service->coupon_image}}" width="650px">
            </td>
        </tr>
        @endif
        <tr style="margin:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;"></td>
        </tr>
    </table>
</div>