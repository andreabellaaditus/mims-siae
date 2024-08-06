
<html>
    <body>
        <table>
            <thead>
                <tr>
                    <th width="20"><b>{{__('global.date')}}</b></th>
                    <th width="20"><b>{{__('global.hour')}}</b></th>
                    <th width="20"><b>{{__('global.username')}}</b></th>
                    <th width="20"><b>{{__('global.cashier')}}</b></th>
                    <th width="20"><b>{{__('global.product')}}</b></th>
                    <th width="20"><b>{{__('reductions.navigation-label')}}</b></th>
                    <th width="20"><b>{{__('global.qty')}}</b></th>
                    <th width="20"><b>{{__('orders.form.payment-type')}}</b></th>
                    <th width="20"><b>{{__('orders.company')}}</b></th>
                    <th width="20"><b>{{__('orders.unit-price')}}</b></th>
                    <th width="20"><b>Status</b></th>
                    <th width="20"><b>{{__('global.notes')}}</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td data-format="dd/mm/yyyy">{{date('d/m/Y', strtotime($item->created_at))}}</td>
                    <td>{{date('H:i', strtotime($item->created_at))}}</td>
                    <td>{{$item->order->user->last_name}}</td>
                    <td>{{$item->order->cashier->name}}</td>
                    <td>{{$item->product->name}}</td>
                    <td>
                        {{$names = '' }}
                        @foreach ($item->product->reductions as $reduction)
                            {{$names .= $reduction->name . ', '}}
                        @endforeach
                        {{rtrim($names, ', ')}}</td>
                    <td>{{$item->qty}}</td>

                    <td>{{$item->order->payment->payment_type->name}}</td>
                    <td>{{$item->order->company->name}}</td>
                    <td data-format="#,##0.00 €">{{$item->price}}</td>
                    <td>{{$item->order_item_status->name}}</td>
                    <td>{{$item->notes}}</td>
                </tr>
                @endforeach

                <tr></tr>
                <tr></tr>
                <tr>

                    <td><b>{{__('global.product')}}</b></td>
                    <td><b>{{__('global.qty')}}</b></td>
                    <td><b>{{__('orders.total_price')}}</b></td>

                </tr>
                @foreach($total_by_product as $product)
                <tr>
                    <td>{{$product['name']}}</td>
                    <td>{{$product['tot_qty']}}</td>
                    <td data-format="#,##0.00 €">{{$product['total_price']}}</td>
                </tr>

                @endforeach

                <tr></tr>
                <tr></tr>
                <tr>
                    <td><b>{{__('orders.form.payment-type')}}</b></td>
                    <td><b>{{__('global.qty')}}</b></td>
                    <td><b>{{__('orders.total_price')}}</b></td>
                </tr>

                @foreach($total_by_paymenttype as $payment_type)

                <tr>
                    <td>{{$payment_type['name']}}</td>
                    <td>{{$payment_type['tot_qty']}}</td>
                    <td data-format="#,##0.00 €">{{$payment_type['total_price']}}</td>
                </tr>

                @endforeach

            </tbody>
        </table>
    </body>
</html>
