<div style="padding-left:15px">
    <table style="width: 93%; border:0px solid #000;">
        <tr>
            <td width="100%" align="center" style="background:#fff; border:0px solid #000;">
                <table cellspacing="0" cellpadding="0" style="width: 100%; font-size:10px; border:0px solid #000; ">
                    <tr>
                        <td colspan="2" align="center" style="font-size:10px;">
                            <br/><b>{{ strtoupper($ticketInfo->siteName) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <b>{!! strtoupper($ticketInfo->productName) !!}</b></td>
                    </tr>
                    <tr>
                        <td width="30%" align="center">
                            <div style="padding:10px 0px 0px 0px">
                                <img src="data:image/png;base64, {!! $ticketInfo->qrCode !!}">{{$ticketInfo->matrix}}
                            </div>
                        </td>
                        <td width="70%" align="left">
                            <div style="padding:0px 5px 3px 5px">
                                <table width="100%" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td width="60%">Ingressi / Quantity:</td>
                                        <td width="40%">{{$ticketInfo->quantity}}</td>
                                    </tr>
                                    <tr>
                                        <td>Prezzo Unit. / Unit Price:</td>
                                        <td>
                                            {{ $ticketInfo->priceSale }}&euro;
                                        </td>
                                    </tr>
                                    @if($ticketInfo->slotHour || $ticketInfo->slotDate)
                                        @if($ticketInfo->slotHour)
                                            <tr>
                                                <td>Ora / Hour:</td>
                                                <td>
                                                    h. {{$ticketInfo->slotHour}}</td>
                                            </tr>
                                        @endif
                                        @if($ticketInfo->slotDate)
                                            <tr>
                                                <td>Giorno / Date:</td>
                                                <td>
                                                    {{$ticketInfo->slotDate}}</td>
                                            </tr>
                                        @endif
                                    @else
                                        @if(isset($ticketInfo->validFromUnit) && isset($ticketInfo->validFromValue))
                                            <tr>
                                                <td>Valido fino / Valid until:</td>
                                                <td>
                                                    {{$ticketInfo->validToDate}}
                                                </td>
                                            </tr>
                                        @endif
                                        @if($ticketInfo->expireAt)
                                            <tr>
                                                <td>Valido fino al /<br>Valid until:</td>
                                                <td>
                                                    h. {{$ticketInfo->expireAt->format("H:i")}} {{$ticketInfo->expireAt->format("d/m/Y")}}</td>
                                            </tr>
                                        @endif
                                    @endif

                                    @if(isset($ticketInfo->stock))
                                        <tr>
                                            <td>Lotto N.:</td>
                                            <td>{{$ticketInfo->stock->lot}}</td>
                                        </tr>
                                        <tr>
                                            <td>Prog.:</td>
                                            <td>{{$ticketInfo->stock->progressive}}</td>
                                        </tr>
                                    @endif

                                    @if(isset($ticketInfo->additional_code))
                                        <tr>
                                            @php
                                            $faHeadphones = "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"
                                            @endphp
                                            <td width="50%" align="left">
                                                <img src="data:image/png;base64, {!! $faHeadphones !!}" style=" height: 12px; display: block; float: left" />
                                                <span style=" height: 15px; display: block; float: left">&nbsp;: {{ $ticketInfo->additional_code }}</span>
                                            </td>
                                        </tr>
                                    @endif

                                </table>

                                <br>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:10px;" colspan="2" align="center"><i style="font-size:9px;">
                                Emesso il / Printed on:
                                {{ $ticketInfo->orderDate->format("d/m/Y H:i:s") }}</i></td>
                    </tr>

                    @if(isset($ticketInfo->holder) && $ticketInfo->holder != '')
                    <tr>
                        <td colspan="2" align="center"><i style="font-size:9px;"> Titolare / Holder: {{ $ticketInfo->holder }} Valido fino al / Valid until: {{ $ticketInfo->holder_expired_at }}</i></td>
                    </tr>
                    @endif
                    @if(isset($ticketInfo->agencyToPrint))
                        <tr>
                            <td colspan="2" align="center"><i style="font-size:9px;">
                                    Agenzia / Agency: {{$ticketInfo->agencyToPrint }}
                                </i></td>
                        </tr>
                    @endif

                    @if($ticketInfo->notFiscal)
                        <tr>
                            <td colspan="2" align="center"><i style="font-size:9px;">Non valido ai fini fiscali, recarsi in biglietteria per il ritiro del biglietto</i></td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</div>
