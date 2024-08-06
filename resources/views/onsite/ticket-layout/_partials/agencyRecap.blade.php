@php
    $orderDate = \Carbon\Carbon::parse($order->created_at)
@endphp
<div style="page-break-after: always;"></div>
<div>
    <table style="width: 93%; border:0px solid #000;">
        <tr>
            <td width="100%" align="center" style="background:#fff; border:0px solid #000;">
                <table style="width: 100%; font-size:10px; border:0px solid #000;">
                    <tr>
                        <td colspan="4" align="center">
                            <br/><b>RIEPILOGO RITIRO BIGLIETTI PER L'AGENZIA</b><br><br>
                            AGENZIA: {{$order->voucher->client->business_name}}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td width="5%" align="center">QTY</td>
                        <td width="45%" align="left">PRODOTTO</td>
                        <td width="10%" align="left">PREZZO</td>
                        <td width="40%" align="left">SLOT</td>
                    </tr>
                    @foreach (\App\Http\Helpers\Ecommerce::orderRecap($order) as $item)
                        @php
                            $slotOrderItemLabel = ' - ';
                                if($item->date_service){
                                    $slotOrderItem = Carbon\Carbon::parse($item->date_service);
                                    $slotOrderItem->startOfDay();
                                    if($item->hour_service){
                                      $slotOrderItem->setTimeFromTimeString($item->hour_service);
                                      $slotOrderItemLabel = $slotOrderItem->format('H:i')." del ".$slotOrderItem->format('d/m/Y');
                                    }
                                    else{
                                        $slotOrderItemLabel = $slotOrderItem->format('d/m/Y');
                                    }

                                }
                        @endphp
                        <tr>
                            <td width="5%" align="center">{{$item->qty}}</td>
                            <td width="45%" align="left">{{$item->product->name}}</td>
                            <td width="10%" align="center">{{$item->price}}€</td>
                            <td width="40%" align="left">{{$slotOrderItemLabel}}</td>
                        </tr>
                    @endforeach

                    @if($order->bollo)
                        <tr>
                            <td width="5%" align="center">1</td>
                            <td width="45%" align="left">Bollo</td>
                            <td width="10%" align="center">{{$order->bollo}}€</td>
                            <td width="40%" align="left"> -</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="5%" align="center"></td>
                        <td width="45%" align="left">TOTALE</td>
                        <td width="10%" align="center">{{$order->price}}€</td>
                        <td width="40%" align="left"> -</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <i style="font-size:9px;">
                                <br>Ritiro effettuato alle {{$orderDate->format('H:i')}}
                                del {{$orderDate->format('d/m/Y')}}
                            </i>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</div>