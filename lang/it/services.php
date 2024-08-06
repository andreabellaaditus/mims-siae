<?php

    return [
        'navigation-group' => 'Catalogo',
        'slot-error' => 'Non è possibile inserire più slot ripetuti nello stesso giorno.',
        'tabs' => [
            'service' => 'Servizio',
            'notifications' => 'Notifiche',
            'slots' => 'Slots',
        ],
        'fieldsets' => [
            'basis_information' => 'Informazioni Base',
            'reservations' => 'Prenotazioni',
            'archive' => 'Archivio',
        ],
        'form' => [
            'product_category_id' => 'Categoria Prodotto',
            'site_id' => 'Sito Museale',
            'code' => 'Codice',
            'name' => 'Nome',
            'slug' => 'Slug',
            'negozio_id' => 'Id Negozio (Siae)',
            'active' => 'Status',
            'is_purchasable' => 'In Vendita',
            'is_date' => 'È necessario prenotare in una data specifica?',
            'is_hour' => 'È necessario indicare un orario?',
            'is_language' => 'È necessario indicare una lingua?',
            'is_pickup' => 'È necessario indicare un punto di raccolta?',
            'is_duration' => 'È necessario indicare una durata specifica?',
            'is_pending' => 'È soggetto ad approvazione da backend?',
            'is_min_pax' => 'È necessario indicare un numero min di pax?',
            'min_pax' => 'Numero minimo partecipanti',
            'is_max_pax' => 'È necessario indicare un numero max di pax?',
            'max_pax' => 'Numero massimo partecipanti',
            'online_reservation_delay' => 'Dopo quanti giorni è possibile prenotare?',
            'closing_reservation' => 'Quante ore prima chiudere le prenotazioni?',
            'is_archived' => 'L\'elemento è archiviato?',
            'archived_at' => 'Data Archiviazione',
            'archived_by' => 'Archiviato da',
            'service_notifications' => [
                'recipients' => 'Destinatario',
                'notification_frequency_id' => 'Frequenza Notifiche',
                'add_notification_service' => 'Aggiungi Destinatario Notifiche',
            ],
            'slots' => [
                'slot_day_id' => 'Giorno',
                'slot_type' => 'Tipologia Slot',
                'duration' => 'Durata Slot',
                'availability' => 'Pax',
                'hours' => 'Orari Slot',
                'add_slot' => 'Aggiungi Slot',
                'advance_tolerance' => 'Tolleranza anticipo (minuti)',
                'delay_tolerance' => 'Tolleranza ritardo (minuti)'
            ]
        ],
        'table' => [
            'product_category' => [
                'name' => 'Categoria Prodotto'
            ],
            'site' => [
                'name' => 'Sito Museale'
            ],
            'code' => 'Codice',
            'name' => 'Nome',
            'slug' => 'Slug',
            'active' => 'Status',
            'is_purchasable' => 'In Vendita',
            'is_archived' => 'Archiviato'
        ],
        'filters' => [
            'active' => 'Status',
            'is_archived' => 'Non mostrare archiviati',
            'site_id' => 'Sito Museale'
        ],
        'actions' => [
            'products' => 'Prodotti'
        ]
    ];
