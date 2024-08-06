<html>
<head>
    <style>
        @page {
            margin: 1px 1px 1px 1px !important;
            font-family: Arial !important;
            background-color: #fff !important;
        }

        body {
            background-color: #fff !important;
            font-family: Arial !important;
        }
    </style>
</head>
<body>


@foreach ($order->items as $item)
    @if (($item->product->service->product_category->slug != 'tickets' &&
    $item->product->service->product_category->slug != 'site-events') ||
    $item->is_cumulative)
        @if($item->printable_qr_code != "0" )
            @include('onsite.ticket-layout._partials.layout',[ 'ticketInfo' => \App\Http\Helpers\Functions::collectTicketLayoutInfo($order, $item)])
            @if (count($order->items) > 1 && !$loop->last)
                <div style="page-break-after: always;"></div>
            @endif
        @endif
    @else
        @php $i=0; @endphp
        @foreach($item->scans as $scan)
            @include('onsite.ticket-layout._partials.layout',[ 'ticketInfo' => \App\Http\Helpers\Functions::collectTicketLayoutInfo($order, $item, $scan)])

            @if ($i!=($item->qty-1))
                <div style="page-break-after: always;"></div>
            @endif
            @php $i++; @endphp
        @endforeach
    @endif
@endforeach

@if($order->voucher)
    @include('onsite.ticket-layout._partials.agencyRecap')
@endif

</body>


</html>
