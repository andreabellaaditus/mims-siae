@extends('online.emails.layout')

@section('content')
    <p>
        Gentile cliente,<br/>
        la ringraziamo per aver ordinato con Aditus S.r.l.<br>
        <br/>
        Di seguito il dettaglio dell'ordine n. <strong>{{ $order->order_number }}</strong> eseguito con successo in
        data {{ \Carbon\Carbon::parse($order->created_at)->format("d/m/Y") }} alle
        ore {{ \Carbon\Carbon::parse($order->created_at)->format("H:i:s") }}

    </p>

    <table style="width: 100%; vertical-align: top;" cellspacing='0' cellpadding='5'>
        <tr style="margin-top:5px;">
            <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:25%"><strong>Sito Archeologico/Polo
                    Museale/Evento</strong></td>
            <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:20%;text-align: center"><strong>Tipologia</strong>
            </td>
            <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:15%;text-align: center"><strong>Prezzo
                    Unitario</strong></td>
            <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:10%;text-align: center">
                <strong>Qty</strong></td>
            <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:15%;text-align: center">
                <strong>Stato</strong></td>
            <td style="border: 1px solid #fff; background:#8c7d70; color:#fff;width:15%;" align='right'>
                <strong>Totale</strong></td>
        </tr>
        @php $total = 0; @endphp
        @php $fee = 0; @endphp
        @php $index = 0; @endphp
        @php $total_tickets = $order->bollo; @endphp
        @php $arr_poles = array(); @endphp
        @php $total_pole["SR1"] = 0; @endphp
        @php $total_pole["ME3"] = 0; @endphp
        @php $total_pole["GE"] = 0; @endphp
        @php $total_pole["AR1"] = 0; @endphp
        @php $total_pole["AR2"] = 0; @endphp
        @php $total_pole["AR3"] = 0; @endphp
        @foreach($order->items as $item)
            @php
                if (!in_array($item->product->site->site->pole->code,$arr_poles)){
                    $arr_poles[] = $item->product->site->site->pole->code;
                }
            @endphp
            @php $total += $item->price; @endphp
            @php
                if ($item->product->site_id > 0){
                    $total_pole[$item->product->site->site->pole->code] += $item->price;
                }
            @endphp
            @php $fee += $item->credit_card_fees; @endphp
            @php $bgColor = $index%2 == 1 ? '#B0A49B': '#ffffff'; @endphp
            @php $index++; @endphp
            <tr style="margin-top:5px;">
                <td style="border: 1px solid #fff;background: {{$bgColor}};width:25%;font-size: 80%">{!! $item->product->service->simple_name !!}</td>
                <td style="border: 1px solid #fff;background: {{$bgColor}};width:20%;font-size: 80%;text-align: center">{!! $item->product->name !!}</td>
                <td style="border: 1px solid #fff;background: {{$bgColor}};width:15%;font-size: 80%;text-align: center">
                    @if ($item->product->product_category->name == "event")
                    {{ number_format($item->product->price_web,2,",",".") }}&euro;
                    @else
                    {{ number_format($item->product->price_sale,2,",",".") }}&euro;
                    @endif
                </td>
                <td style="border: 1px solid #fff;background: {{$bgColor}};width:10%;font-size: 80%; text-align: center">{{ $item->qty }}</td>
                <td style="border: 1px solid #fff;background: {{$bgColor}};width:15%;font-size: 80%; text-align: center">{{ $item->order_item_status->name }}</td>
                <td style="border: 1px solid #fff;background: {{$bgColor}};width:15%;font-size: 80%" align="right">
                    @if ($item->product->product_category->name == "event")
                    {{ number_format($item->qty*$item->product->price_web,2,",",".") }}&euro;
                    @else
                    {{ number_format($item->qty*$item->product->price_sale,2,",",".") }}&euro;
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td style="background: #ffffff;font-size: 2px" colspan='6'>&nbsp;</td>
        </tr>
        <tr>
            <td style="background: #8c7d70;font-size: 1px;padding: 0px" colspan='6'>&nbsp;</td>
        </tr>
        <tr>
            <td style="background: #ffffff;font-size: 2px" colspan='6'>&nbsp;</td>
        </tr>
        @if ($fee > 0)
            <tr>
                <td style="border: 1px solid #fff;width:10%;font-size: 80%" class='bordered' colspan='5' align='right'>
                    <strong>Subtotale</strong></td>
                <td style="border: 1px solid #fff;width:10%;font-size: 80%" align="right"><strong>{{ number_format($total,2,",",".") }}&euro;</strong>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #fff;width:10%;font-size: 80%" class='bordered' colspan='5' align='right'>
                    <strong>Commissioni di servizio</strong></td>
                <td style="border: 1px solid #fff;width:10%;font-size: 80%" align="right"><strong>{{ number_format($fee,2,",",".") }}&euro;</strong>
                </td>
            </tr>
        @endif
        @php $dutyStamp = 0; @endphp
        @if($order->bollo > 0)
            @php $dutyStamp = $order->bollo @endphp
            <tr>
                <td style="border: 1px solid #fff;width:10%;font-size: 80%" class='bordered' colspan='5' align='right'>
                    <strong>* Imposta di bollo</strong></td>
                <td style="border: 1px solid #fff;width:10%;font-size: 80%" align="right"><strong>{{ number_format($order->bollo,2,",",".") }}&euro;</strong>
                </td>
            </tr>
        @endif
        <tr>
            <td style="border: 1px solid #fff;width:10%;font-size: 80%" class='bordered' colspan='5' align='right'>
                <strong>Totale</strong></td>
            <td style="border: 1px solid #fff;width:10%;font-size: 80%" align="right"><strong>{{ number_format($total+$fee+$dutyStamp,2,",",".") }}&euro;</strong>
            </td>
        </tr>
    </table>

    <p><strong>Attenzione!!! L'ordine è in stato PENDING</strong>, in quanto la modalità scelta per il pagamento
        è BONIFICO BANCARIO.<br/>Per completare l'ordine è necessario procedere al pagamento come segue:<br/>
        @if (count($arr_poles) == 1 && $arr_poles[0] == "ME3")
            - Bonifico Bancario di <strong>{{ number_format($total+$fee+$dutyStamp,2,",",".") }}&euro;</strong> a favore
            di Aditus S.r.l. presso Unicredit, IBAN IT08D0200801105000105491663, indicando nella causale il
            numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
        @endif
        @if (count($arr_poles) == 1 && $arr_poles[0] == "SR1")
            - Bonifico Bancario di <strong>{{ number_format($total+$fee+$dutyStamp,2,",",".") }}&euro;</strong> a favore
            di Aditus S.r.l. presso Banca Intesa Sanpaolo, IBAN IT28S0306901000100000047507, indicando nella
            causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
        @endif
        @if (count($arr_poles) == 1 && $arr_poles[0] == "GE")
            - Bonifico Bancario di <strong>{{ number_format($total+$fee+$dutyStamp,2,",",".") }}&euro;</strong> a favore
            di Genova Cultura s.c.a.r.l. presso Banca INTESA SANPAOLO, IBAN IT13P0306901000100000136607, indicando nella causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
        @endif
        @if (count($arr_poles) == 1 && ($arr_poles[0] == "AR1" || $arr_poles[0] == "AR2" || $arr_poles[0] == "AR3"))
            - Bonifico Bancario di <strong>{{ number_format($total+$fee+$dutyStamp,2,",",".") }}&euro;</strong> a favore di Aditus S.r.l. presso Banca INTESA SANPAOLO, IBAN IT64W0306901000100000047535, indicando nella causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
        @endif
        @if (count($arr_poles) > 1)
            @if (in_array("ME3",$arr_poles))
                - Bonifico Bancario di <strong>{{ number_format($total_pole["ME3"],2,",",".") }}&euro;</strong> a favore di Aditus S.r.l. presso Unicredit, IBAN IT08D0200801105000105491663, indicando nella causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
            @endif
            @if (in_array("SR1",$arr_poles))
                - Bonifico Bancario di <strong>{{ number_format($total_pole["SR1"],2,",",".") }}&euro;</strong> a favore di Aditus S.r.l. presso Banca Intesa Sanpaolo, IBAN  IT28S0306901000100000047507, indicando nella causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
            @endif
            @if (in_array("GE",$arr_poles))
                - Bonifico Bancario di <strong>{{ number_format($total_pole["GE"],2,",",".") }}&euro;</strong> a favore di Genova Cultura s.c.a.r.l. presso Banca INTESA SANPAOLO, IBAN IT13P0306901000100000136607, indicando nella causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
            @endif
            @if (in_array("AR1",$arr_poles) || in_array("AR2",$arr_poles) || in_array("AR3",$arr_poles))
                - Bonifico Bancario di <strong>{{ number_format($total_pole["AR1"] + $total_pole["AR2"] + $total_pole["AR3"],2,",",".") }}&euro;</strong> a favore di Aditus S.r.l. presso Banca INTESA SANPAOLO, IBAN IT64W0306901000100000047535, indicando nella causale il numero d'ordine di riferimento: <strong>{{ $order->order_number }}</strong><br/>
            @endif
        @endif
        Al momento della ricezione del bonifico bancario, verrà inviata un'email di conferma ordine con la
        seguente documentazione:<br/>
        - Biglietti d'ingresso ai poli museali ed archeologici, con Codice QR da mostrare direttamente al
        controllo accessi, se non è stata selezionata l'opzione <u>ritiro in biglietteria</u> durante la fase
        d'acquisto.<br/>

        NB: Per visualizzare i documenti, è necessario installare Adobe Acrobat Reader. Per informazioni visita
        http://get.adobe.com/it/reader/</p>
@endsection
@section('link')
    @if(isset($linkLabel) && isset($linkUrl))
        <div align="center" class="button-container"
             style="padding-top:15px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
            <!--[if mso]>
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
            <tr>
                <td style="padding-top: 15px; padding-right: 10px; padding-bottom: 0px; padding-left: 10px"
                    align="center">
                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                 xmlns:w="urn:schemas-microsoft-com:office:word" href=""
                                 style="height:46.5pt;width:176.25pt;v-text-anchor:middle;"
                                 arcsize="97%" stroke="false" fillcolor="#8b7e70">
                        <w:anchorlock/>
                        <v:textbox inset="0,0,0,0">
                            <center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px">
            <![endif]-->
            <div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#8b7e70;border-radius:60px;-webkit-border-radius:60px;-moz-border-radius:60px;width:auto; width:auto;;border-top:1px solid #8b7e70;border-right:1px solid #8b7e70;border-bottom:1px solid #8b7e70;border-left:1px solid #8b7e70;padding-top:15px;padding-bottom:15px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;"><span
                        style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:undefined;"><span
                            style="font-size: 16px; margin: 0; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><strong>
                                                    <a href="{{$linkUrl}}">{{$linkLabel}}</a>
                                                    </strong></span></span></div>
            <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table>
            <![endif]-->
        </div>
    @endif
@endsection