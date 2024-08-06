<html>
<head>
    <style>

        * {
            font-family: 'Montserrat', Verdana,  serif;
            font-size: 15px;
        }

        body, html {
            margin: 0;
            padding: 2%;
            border: 0;
            font-family: 'Montserrat', Verdana, serif;
            font-size: 15px;
        }

    </style>
</head>
<body>
<table border="0" cellspacing="0" cellpadding="0"
       style="width: 100%; height: 100%; border:0;margin:0; padding:0;">
    <tr>
        <td valign="top">
            <table border="0" cellspacing="0" cellpadding="0"
                   style="width: 100%; height: 70%;border:0; margin:0; padding:0;">
                <tr>
                    <td style="border:0; margin:0; padding:0;" valign="top">

                        <table style="width: 100%; font-size:13px;">
                            <tr style="margin-top:5px;">
                                <td width="40%" align="left" style='width:40%; vertical-align: top;'>
                                    <strong>{{ $company->companyName }}</strong><br/>
                                    {{ $company->address }}<br>
                                    {{ $company->cap }} {{ $company->city }} ({{ $company->province }}) - {{ $company->nameCountry }}<br>
                                    CF/P.IVA {{ $company->tax_code }}<br><br>
                                        Sito web: <a href="{{ url($company->link_web) }}">{{ $company->link_web_description }}</a>

                                </td>
                                <td width="60%" align="right" valign="top">
                                    @if ($company->logo)
                                    <img src="{{ $company->logo }}" alt="Aditus" height="50" />
                                    @else
                                    <strong>{{ $company->companyName }}</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 100%;height: 50px">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="width:40%; background:#8c7d70; color:#fff;padding:10px 5px">
                                    <strong>FATTURA</strong></td>
                                <td style="width:60%; color:#8c7d70; background:#fff;text-align: right"><strong>DESTINATARIO</strong>
                                </td>
                            </tr>
                            <tr style="margin-top:50px;">
                                <td style='width:40%; padding-top:10px; vertical-align: top; text-align: left'>
                                    NUMERO:<strong>{{ $invoice->number }}</strong><br/>
                                    DATA:
                                    <strong>{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</strong><br/>
                                    VALUTA: <strong>EUR</strong><br/>
                                </td>
                                <td style='width:60%; padding-top:10px; vertical-align: top; text-align: right'>

                                    <strong>
                                        @if(isset($invoice->user->client->business_name) && $invoice->user->client->business_name != "")
                                            {{ $invoice->user->client->business_name }}
                                        @else
                                            {{ $invoice->user->first_name }} {{ $invoice->user->last_name }}
                                        @endif
                                    </strong><br>


                                    @if($invoice->user->client->address)
                                        {{ $invoice->user->client->address }}<br>
                                    @endif
                                    {{ $invoice->user->client->cap }} {{$invoice->user->client->city }}

                                    @if($invoice->user->client->province)

                                        ( {{ strlen($invoice->user->client->province) == 2 ? strtoupper($invoice->user->client->province) : $invoice->user->client->province }}
                                        )

                                    @endif


                                    {{ $invoice->user->client->country->code  }}
                                    <br>
                                    {{$invoice->user->client->phone }}


                                    <br>
                                    @if(isset($invoice->user->client->vat) && $invoice->user->client->vat != "")
                                        P.IVA: {{ $invoice->user->client->vat }}<br>
                                    @endif


                                    @if(isset($invoice->user->client->tax_code) && $invoice->user->client->tax_code != "")
                                        C.F.: {{ $invoice->user->client->tax_code }}<br>
                                    @endif
                                </td>
                            </tr>

                        </table>

                        <div style="min-height: 200px; margin-top:40px;">&nbsp;</div>

                        <table style="width: 100%; vertical-align: top;" cellspacing='0' cellpadding='5'>
                            <tr style="margin-top:5px;">
                                <td style="border:1px solid; background:#8c7d70; color:#fff;width:35%"><strong>Descrizione</strong>
                                </td>
                                <td style="border:1px solid; background:#8c7d70; color:#fff;width:20%;"><strong>Tipologia</strong>
                                </td>
                                <td style="border:1px solid; background:#8c7d70; color:#fff;width:10%;text-align: center">
                                    <strong>Prezzo
                                        Unitario</strong></td>
                                <td style="border:1px solid; background:#8c7d70; color:#fff;width:10%;text-align: center">
                                    <strong>Qty</strong></td>
                                <td style="border:1px solid; background:#8c7d70; color:#fff;width:10%;text-align: center">
                                    <strong>Aliquota IVA</strong></td>
                                <td style="border:1px solid; background:#8c7d70; color:#fff;width:15%;" align='right'>
                                    <strong>Totale</strong></td>
                            </tr>
                            @php $fees = 0; @endphp
                            @php $taxable = 0; @endphp
                            @php $tax = 0; @endphp
                            @foreach($invoice->itemsGroupedByProduct as $orderItem)
                                    @php
                                        //$orderItem = $item->orderItem;
                                        $priceItem = $orderItem->product->service->product_category->name == "event" ? $orderItem->product->price_web : $orderItem->product->price_sale;
                                        $totalItem = $orderItem->qty*$priceItem;

                                        $taxable += $totalItem/(1+($orderItem->product->vat/100));
                                        $tax += $totalItem - $totalItem/(1+($orderItem->product->vat/100));

                                        $fees += $orderItem->fees;

                                        $taxable += $orderItem->fees/(1.22);
                                        $tax += $orderItem->fees - $orderItem->fees/(1.22);
                                    @endphp
                                    <tr style="margin-top:5px;">
                                        <td style="width:35%;">{!! $orderItem->product->service->simple_name !!}</td>
                                        <td style="width:20%;">{!! $orderItem->product->name !!}</td>
                                        <td style="width:10%;text-align: center">
                                            {{ number_format($priceItem,2,",",".") }} &euro;
                                        </td>
                                        <td style="width:10%;text-align: center">{{ $orderItem->qty }}</td>
                                        <td style="width:10%;text-align: center">{{ $orderItem->product->vat }}%</td>
                                        <td style="width:15%;" align="right">
                                            {{ number_format($totalItem,2,",",".") }} &euro;
                                        </td>
                                    </tr>
                            @endforeach

                            @if($fees > 0)
                                <tr style="margin-top:5px;">
                                    <td style="width:35%;">Commissioni di servizio</td>
                                    <td style="width:20%;"></td>
                                    <td style="width:10%;text-align: center">{{ number_format($fees,2,",",".") }} &euro;
                                    </td>
                                    <td style="width:10%;text-align: center">1</td>
                                    <td style="width:10%;text-align: center">22%</td>
                                    <td style="width:15%;" align="right">
                                        {{ number_format($fees,2,",",".") }} &euro;
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0"
                   style="width: 100%; height: 30%; border:0; margin:0; padding:0;">
                <tr>
                    <td style="vertical-align:bottom; border:0; margin:0; padding:0;">
                        <table style="width: 100%;" cellspacing='0' cellpadding='5' border="0">
                            <tr>
                                <td style="width:50%;padding:10px; vertical-align: bottom;">
                                    <b>Modalità di pagamento:</b><br>
                                    {{ trans('ecommerce.payment.methods.'.$invoice->StringInvoiceType) }}

                                </td>
                                <td style="width:50%;">
                                    <table style="width: 100%;" cellspacing='0' cellpadding='5' border="0">
                                        <tr style="margin-top:5px;">
                                            <td style="text-align:right;width:40%;">Imponibile:</td>
                                            <td style="width:5%;"></td>
                                            <td style="text-align:right;width:15%;">
                                                <nobr>{{ number_format($taxable,2,",",".") }} &euro;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="margin-top:5px;">
                                            <td style="text-align:right;width:40%;">Bolli:</td>
                                            <td style="width:5%;"></td>
                                            <td style="text-align:right;width:15%;">
                                                <nobr>{{ number_format($invoice->duty_stamp,2,",",".") }} &euro;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="margin-top:5px;">
                                            <td style="text-align:right;width:40%;">Totale IVA:</td>
                                            <td style="width:5%;"></td>
                                            <td style="text-align:right;width:15%;">
                                                <nobr>{{ number_format($tax,2,",",".") }} &euro;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="margin-top:5px;">
                                            <td style="text-align:right;width:40%;">Totale documento:</td>
                                            <td style="width:5%;"></td>
                                            <td style="text-align:right;width:15%;">
                                                <nobr>{{ number_format($invoice->amount,2,",",".") }} &euro;</nobr>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:10px">&nbsp;</td>
                            </tr>
                            <tr style="background:#8c7d70; color:#fff;font-size:18px !important; padding: 10px">
                                <td style="padding:10px"><strong>Importo dovuto</strong></td>
                                <td style="padding:10px; text-align: right"><strong>{{ number_format($invoice->amount,2,",",".") }} &euro;</strong>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="padding:10px"><i>
                                        Documento non valido ai fini fiscali, fattura emessa in formato elettronico<br>
                                        Copia della fattura il cui originale è depositato nell'area web "fatture e
                                        corrispettivi"
                                        dell'Agenzia delle Entrate. </i></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
