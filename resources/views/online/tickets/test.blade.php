<html>   
    <body style="font-family: 'montserrat'; font-size:12px; padding:0; margin:0;">
        <div style="position: fixed; top: 10px; left: 0px; right: 0px;">
            <table style="width: 100%; vertical-align: top;">
                <tr style="margin-top:5px;">
                    <td colspan="2"><p><img src="<?php echo storage_path() ?>/app/public/logo_thekey1.png" width="60"/></p></td>
                </tr>
            </table>
            <hr style="color:#ccc;">
            <table style="width: 100%; vertical-align: top; font-size:13px;">
                <tr style="margin-top:5px;">
                    <td width="50%" align="left" style='vertical-align: top;'>
                        <strong>NUMERO ORDINE: </strong><?php echo $order->order_number ?><br />
                        <strong>DATA: </strong>
                        <?php 
                        $order_date = new Carbon\Carbon($order->created_at);
                        $order_date_formatted = $order_date->format('d/m/Y'); 
                        echo $order_date_formatted;
                        ?>   
                    </td>
                    <td width="50%" align="right">
                        <?php 
                        echo $user->first_name." ".$user->last_name."<br>";
                        if ($user->client->address != "" && $user->client->cap != ""){
                            echo $user->client->address." ".$user->client->cap."<br>";
                        }
                        if ($user->client->address != "" && $user->client->cap == ""){
                            echo $user->client->address."<br>";
                        }
                        if ($user->client->address == "" && $user->client->cap != ""){
                            echo $user->client->cap."<br>";
                        }                    
                        echo $user->client->city." ".$user->client->country->name."<br>";
                        echo $user->client->phone;
                        ?>
                    </td>
                </tr>
            </table>             
        </div>

        <div style="min-height: 200px; margin-top:190px;">&nbsp;</div>
        
        <p style="font-family: 'montserrat'; font-size:14px; padding:0; margin:0;">Gentile <strong>{{ $user->first_name }}</strong>,<br />grazie per aver scelto TheKey per l'acquisto del biglietto online. Di seguito il riepilogo dell'ordine effettuato:</p>
        
        <div style="min-height: 50px; margin-top:40px;">&nbsp;</div>

        <table style="width: 100%; vertical-align: top;" cellspacing='0' cellpadding='5'>
            <tr style="margin-top:5px;">
                <td style="border: 1px solid #444; background:#faf2cc;"><strong>Data/Ora Acquisto</strong></td>
                <td style="border: 1px solid #444; background:#faf2cc;"><strong>Numero Ordine</strong></td>
                <td style="border: 1px solid #444; background:#faf2cc;"><strong>Prezzo Unitario</strong></td>
                <td style="border: 1px solid #444; background:#faf2cc;"><strong>Quantità</strong></td>
                <td style="border: 1px solid #444; background:#faf2cc;"><strong>Biglietto</strong></td>
                <td style="border: 1px solid #444; background:#faf2cc;"><strong>Sito</strong></td>
                <td style="border: 1px solid #444; background:#faf2cc;" align='right'><strong>Totale</strong></td>
            </tr>
            <?php $total = 0; ?>
            @foreach($order->items as $item)
            <?php $total += $item->qty*$item->price; ?>
            <tr style="margin-top:5px;">
                <td style="border: 1px solid #444;"><?php echo $order_date_formatted ?></td>
                <td style="border: 1px solid #444;">{{ $order->order_number }}</td>
                <td style="border: 1px solid #444;">&euro;&nbsp;{{ number_format($item->price,2,",",".") }}</td>
                <td style="border: 1px solid #444;">{{ $item->qty }}</td>
                <td style="border: 1px solid #444;">{{ $item->product->name }}</td>
                <td style="border: 1px solid #444;">{{ $item->product->site->name }}</td>
                <td style="border: 1px solid #444;" align='right'>&euro;&nbsp;{{ number_format($item->qty*$item->price,2,",",".") }}</td>
            </tr>
            @endforeach 
            <tr style="margin-top:5px;">
                <td colspan="6" style="border: 1px solid #444;"></td>
                <td style="border: 1px solid #444;" align='right'><strong>&euro;&nbsp;{{ number_format($total,2,",",".") }}</strong></td>
            </tr>            
        </table>
        
        <div style="min-height: 50px; margin-top:40px;">&nbsp;</div>
        
        <p style="font-family: 'montserrat'; font-size:14px; padding:0; margin:0;">Gentile <strong>{{ $user->first_name }}</strong>,<br />grazie per aver scelto TheKey per l'acquisto del biglietto online. Di seguito il riepilogo dell'ordine effettuato:</p>

        <div style="position: fixed; bottom: 50px; left: 0px; right: 0px;">
            <hr style="color:#d54e4d;">
            <table style="width: 100%; vertical-align: top;">
                <tbody>
                    <tr style="margin-top:5px;" align="center">
                        <td width="100%">
                            <img src="<?php echo storage_path() ?>/app/public/logo_thekey1.png" width="20" style="margin-top:6px;"/>&nbsp;The Key S.r.l.<br />
                            Via Caboto, 35, 10129 Torino<br />
                            CF/P.IVA 09896500015
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @foreach($order->items as $item)
            <div style="page-break-after: always;"></div>

            <div style="margin-top:250px;">
                <table style="width: 100%; vertical-align: top; font-size:13px;">
                    <tr style="margin-top:5px;" align="center">
                        <td style="font-family: 'montserrat'; font-size:30px;"><strong>{{ $item->product->site->name }}</strong><br />Biglietto {{ $item->product->name }}</td>            
                    </tr>                 
                    <tr style="margin:50px 0px 50px 0px;" align="center">
                        <td><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Make me into an QrCode!')) !!}"></td>            
                    </tr>
                    <tr style="margin-top:5px;" align="left">
                        <td style="font-family: 'montserrat'; font-size:16px;">Stampa il tuo biglietto per accedere direttamente al controllo accessi del {{ $item->product->site->name }}, senza far code alla cassa</td>            
                    </tr> 
                    <tr style="margin-top:5px;" align="left">
                        <td style="font-family: 'montserrat'; font-size:16px;">
                            Il seguente biglietto<br />
                            - ha un codice univoco che sarà rilevato direttamente al controllo accessi<br />
                            - è valido per un ingresso a partire dal <?php echo $order_date_formatted ?>
                        </td>            
                    </tr>                
                </table> 
            </div>
        @endforeach
              
    </body>
</html>