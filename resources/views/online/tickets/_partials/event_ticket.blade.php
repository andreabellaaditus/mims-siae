
<div style="margin-top:100px;">
    <table style="width: 100%; vertical-align: top; font-size:13px;">
        <tr style="margin-top:5px;" align="center">
            <td style="font-family: 'montserrat'; font-size:16px;">{!! \App\Http\Helpers\Functions::replacePlaceHolder($item->product->coupon_text,$item) !!}
            </td>
        </tr>
    </table>
</div>
@if($item->product->coupon_image)
<div style="position: fixed; bottom: 300px; left: 0px; right: 0px;">
    <table style="width: 100%; vertical-align: top;">
        <tbody>
        
            <tr align="center">
                <td>
                    @if (env('APP_ENV') == "production")
                        <img src="{{ $item->product->coupon_image }}" width="650">
                    @else
                        <img src="{{ public_path().$item->product->coupon_image }}" width="650">
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif