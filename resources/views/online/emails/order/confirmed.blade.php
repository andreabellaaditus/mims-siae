@extends('online.emails.new_layout')

@section('content')
    @if ($lang == "en")
        @if($days > 0)
        <p style="margin: 25px 0; font-size: 20px;">Only <b>{{ round($days) }} days</b> separate you from your visit at <b>{{ $siteName }}</b>!</p>
        @elseif($hours > 0)
            <p style="margin: 25px 0; font-size: 20px;">Only <b>{{ $hours }} hours</b> separate you from your visit at <b>{{ $siteName }}</b>!</p>
        @elseif($minutes > 0)
            <p style="margin: 25px 0; font-size: 20px;">Only <b>{{ $minutes }} minutes</b> separate you from your visit at <b>{{ $siteName }}</b>!</p>
        @endif
        <p style="margin: 25px 0; font-size: 20px;">Attached you will find <b>your tickets</b>, print and take them with you, so you will avoid the long queues at the ticket offices and you can go straight to the entrance!</p>
        <p style="margin: 25px 0; font-size: 20px;">It will be a fantastic experience, you will see!</p>
    @else
        @if($days > 0)
            <p style="margin: 25px 0; font-size: 20px;">Solo <b>{{ round($days) }} giorni</b> ti separano dalla tua visita presso <b>{{ $siteName }}</b>!</p>
        @elseif($hours > 0)
            <p style="margin: 25px 0; font-size: 20px;">Solo <b>{{ $hours }} ore</b> ti separano dalla tua visita presso <b>{{ $siteName }}</b>!</p>
        @elseif($minutes > 0)
            <p style="margin: 25px 0; font-size: 20px;">Solo <b>{{ $minutes }} minuti</b> ti separano dalla tua visita presso <b>{{ $siteName }}</b>!</p>
        @endif
        <p style="margin: 25px 0; font-size: 20px;">In allegato trovi <b>i tuoi biglietti</b>, stampali e portali con te, così eviterai le lunghe code alle biglietterie e potrai recarti subito all’ingresso!</p>
        <p style="margin: 25px 0; font-size: 20px;">Sarà un’esperienza fantastica, vedrai!</p>
    @endif
@endsection
