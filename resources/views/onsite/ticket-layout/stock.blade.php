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
@php $num_tickets = $stock->stockMatrices->count(); @endphp

@php $i=1; @endphp
@foreach ($stock->stockMatrices as $stockMatrix)

    @include('onsite.ticket-layout._partials.layout',[ 'ticketInfo' => \App\Http\Helpers\Functions::collectStockLayoutInfo($stock, $stockMatrix)])

    @if ($i<($num_tickets-1))
        <div style="page-break-after: always;"></div>
    @endif
    @php $i++; @endphp

@endforeach

</body>
</html>