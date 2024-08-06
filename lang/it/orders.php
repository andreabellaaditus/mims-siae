<?php

    return [
        'model-label' => 'Ordine',
        'plural-model-label' => 'Ordini',
        'navigation-label' => 'Ordini',
        'navigation-group' => 'Vendita On Site',
        'empty-cart' => 'Svuota carrello',
        'select-cashier' => 'Seleziona una postazione',

        'date-service' => 'Data servizio',
        'hour-service' => 'Orario',
        'open-ticket' => 'Aperto',
        'no-slots' => 'Nessuno slot disponibile...',
        'no-products-selected' => 'Non è possibile creare un ordine senza inserire prodotti!',
        'at-least-one' => 'Aggiungi almeno un prodotto',
        'unit-price' => 'Prezzo',
        'scans' => 'Scansioni',
        'location' => 'Postazione',
        'cashier' => 'Cassiere',
        'list' => 'Lista ordini',
        'cart' => 'Carrello prodotti',
        'refresh-orders-table' => 'Aggiorna tabella ordini',
        'no-reduction-fields-filled' => 'Verifica di aver compilato tutti i campi relativi alle riduzioni!',
        'no-name-data-filled' => 'Verifica di aver compilato tutti i nominativi richiesti!',
        'no-hour-filled' => 'Verifica di aver scelto tutti gli slot orari!',
        'no-date-filled' => 'Verifica di aver scelto tutte le date richieste!',
        'select-slot' => 'Seleziona slot...',
        'no-slot' => 'Nessuno slot disponibile',
        'refresh-orders-table' => 'Aggiorna la lista degli ordini',
        'change-user' => 'Cambio utente',
        'slot-error' => 'Non è possibile inserire più slot ripetuti nello stesso giorno.',
        'free-spots' => 'posti disponibili',
        'export-by-products' => 'Esporta totali suddivisi per prodotto',
        'export-by-paymenttype' => 'Esporta totali suddivisi per tipo di pagamento',
        'export-daily-report' => 'Esporta report giornaliero',
        'company' => 'Azienda',
        'total_price' => 'Prezzo totale',

        'scan' => [
            'success-title' => 'Scansione effettuata con successo!',
            'success-desc' => 'Il biglietto è stato annullato.',
            'ticket-expired' => 'Il biglietto è scaduto.',
            'ticket-already-scanned' => 'Il biglietto è già stato scansionato.',
            'code-not-exists' => 'Il QrCode non esiste a sistema',
            'wrong-length' => 'Lunghezza QrCode errata',
            'code-not-valid' => 'QrCode non valido',
            'wrong-site' => 'Il sito associato al prodotto è errato.',
            'max-scans' => 'Superato il numero massimo di scansioni.',
            'wrong-date' => 'La data non corrisponde ad oggi.',
            'wrong-hour' => 'L\'orario non è valido per l\'attuale slot orario.',
        ],

        'form' => [
            'select-products' => 'Clicca su un prodotto per aggiungerlo al carrello',
            'payment-type' => 'Tipo di pagamento',
            'ticket-limits' => 'Limiti di utilizzo prodotto',
            'open-ticket' => 'Biglietto aperto',
            'create' => 'Crea ordine',
        ],

        'cashier' => [
            'check-cash-drawer' => 'Controllo contanti cassetto',
            'check-cash-drawer-desc' => "<h2 class='text-xl font-semibold'> Controllo contanti </h2>

            Ti chiediamo gentilmente di verificare il contante e la scorta presente nel cassetto utilizzando
            i campi sottostanti. Se lo ritieni oppurtuno potrai aggiungere una nota per eventuali segnalazioni da inoltrare alla contabilità.<br><br>
            <div style='background-color:#dd4b39; color:white; padding:2%; text-align: -webkit-center;'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z' /></svg>
            Ricordarsi di includere il fondo cassa nel totale presente nel cassetto.</div>",

            'successful-opening' => 'Apertura cassa completata con successo!',
            'successful-opening-desc' => 'Adesso puoi procedere con l\'emissione dei biglietti, ricordati a fine turno di effettuare la procedura di chiusura cassa.',
            'cashier-already-open' => 'La cassa risulta già essere aperta, aggiorna la pagina',
            'cashier-already-in-use' => 'La cassa risulta già in uso da ',

            'closure-cash-amount-registered' => 'Precedente chiusura cassa',
            'opening-cash-amount-registered' => 'Presente nel cassetto',
            'select-cashier' => 'Seleziona postazione',
            'cashier-opening' => 'Apertura cassa',
            'cashier-closing' => 'Chiusura cassa',
            'close-other' => 'Altra cassa aperta',
            'select-cashier-desc' => 'Seleziona una postazione tra quelle presenti nel seguente elenco:',

            'closure-pos-amount-calculated' => 'Totale registrato a sistema',
            'closure-pos-amount-registered' => 'Totale da terminale POS',
            'closure-voucher-amount-calculated' => 'Totale registrato a sistema',
            'closure-voucher-amount-registered' => 'Importo voucher contabilizzato',
            'closure-paid-amount-registered' => 'Contante versato in cassaforte',
            'closure-cash-amount-partial' => 'Contante previsto nel cassetto',
            'cash-to' => 'Contante consegnato a',
            'closure-hand-amount-registered' => 'Contante consegnato',
            'tot-cash-opening' => 'Totale cassetto apertura',
            'closure-cash-amount-calculated' => 'Contante registrato a sistema',
            'closure-cash-amount-registered' => 'Contante presente nel cassetto',
            'alert-check-cash' => "<div style='background-color:#dd4b39; color:white; padding:2%; text-align: -webkit-center;'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z' /></svg>
            Includere il fondo cassa nel totale presente nel cassetto.</div>",
            'no-cashier-selected' => 'Nessuna postazione selezionata',
            'no-closable' => 'La postazione attualmente attiva non può essere chiusa, prova a ricare la pagina e riprovare',
            'no-open-cashier-for' => 'Nessuna postazione risulta attualmente aperta in carico a ',
            'safe' => 'Cassaforte',

            'successfully-selected' => 'Nuovo cassiere selezionato',
            'proceed' => 'Adesso puoi procedere con l\'emissione dei biglietti',
        ],

        'generic-error' => [
            'title' => 'Attenzione!',
            'message' => 'Si è verificato un errore durante il salvataggio, ti preghiamo di riprovare.',
        ],
        'validation' => [
            'error-title' => 'Attenzione!',
            'error-message' => 'I seguenti campi non sono stati compilati correttamente:<ul>:errors</ul>',
            'errors' => [
                'opening-cash-amount-registered' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-cash-amount-registered' => [
                    'required' => '',
                    'regex' => 'Totale Contante presente nel cassetto non è in un formato corretto',
                ],
                'closure-cash-amount-accounted' => [
                    'required' => '',
                    'regex' => 'Totale contanti chiusura non è in un formato corretto',
                ],
                'closure-pos-amount-registered' => [
                    'required' => '',
                    'regex' => 'Totale transazioni POS non è in un formato corretto',
                ],
                'closure-pos-amount-accounted' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-voucher-amount-registered' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-voucher-amount-accounted' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-paid-amount-registered' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-paid-amount-accounted' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-hand-amount-accounted' => [
                    'required' => '',
                    'regex' => 'Totale contanti apertura non è in un formato corretto',
                ],
                'closure-hand-amount-to' => [
                    'required' => 'Il coordinatore al quale è stato consegnato il contante è obbligatorio',
                ],

            ]
        ],
        'closure-error' => [
            'title' => 'Attenzione!',
            'message' => 'Si è verificato un problema durante il salvataggio della chiusura cassa.',
        ],
        'receipt-error' => [
            'title' => 'Attenzione!',
            'message' => 'Si è verificato un problema durante il salvataggio delle ricevute, gli altri dati sono stati correttamente salvati.',
        ],
        'saved-successfully' => [
            'title' => 'Salvataggio completato!',
            'message' => 'I dati di chiusura cassa sono stati correttamente salvati.<br>Ricordati di confermare la "chiusura cassa" per completare la procedura.',
        ],
        'confirmed-successfully' => [
            'title' => 'Conferma completata!',
            'message' => 'La procedura di "Chiusura cassa" è stata completata.',
        ],
        'cashier-saved-successfully' => [
            'title' => 'Salvataggio completato!',
            'message' => 'La procedura di "Chiusura cassa" è stata completata, attendere il caricamento della pagina',
        ]


    ];

