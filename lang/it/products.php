<?php

    return [
        'model-label' => 'Prodotto',
        'plural-model-label' => 'Prodotti',
        'navigation-label' => 'Prodotti',
        'navigation-group' => 'Catalogo',
        'slot-error' => 'Non è possibile inserire più slot ripetuti nello stesso giorno.',
        'sections' => [
            'required' => '(*) Richiesto',
            'basis_information' => 'Informazioni Base',
            'matrices' => 'Generazione Matrici in fase di Acquisto',
            'prices' => 'Prezzi & IVA',
            'seats_and_scans' => 'Prenotazioni & Informazioni Slots',
            'document_check' => 'Riduzioni',
            'supplier' => 'Fornitore',
            'validities' => 'Periodi di Validità',
            'cumulatives' => 'Cumulativo',
            'sales_matrix' => 'Canali di Vendita',
            'notes' => 'Note',
            'slots' => 'Slots',
            'related_products' => 'Prodotti associati'
        ],
        'tabs' => [
            'basis_information' => 'Info Base',
            'matrices' => 'Matrici',
            'prices' => 'Prezzi',
            'seats_and_scans' => 'Prenotazioni',
            'document_check' => 'Riduzioni',
            'supplier' => 'Fornitore',
            'validities' => 'Validità',
            'cumulatives' => 'Cumulativo',
            'sales_matrix' => 'Canali Vendita',
            'notes' => 'Note',
            'slots' => 'Slots',
            'related_products' => 'Prodotti associati'
        ],
        'form' => [
            'code' => 'Codice',
            'article' => 'Articolo',
            'name' => 'Nome',
            'slug' => 'Slug',
            'active' => 'Status',
            'deliverable' => 'Consegnabile',
            'printable' => 'Stampabile',
            'billable' => 'Fatturabile',
            'matrix_generation_type' => 'Tipo Generazione Matrice',
            'matrix_prefix' => 'Prefisso Matrice',
            'matrix' => 'Matrice',
            'ticket_type' => 'Tipologia Ticket',
            'price_sale' => 'Importo Vendita',
            'price_purchase' => 'Importo Acquisto',
            'price_web' => 'Importo Web',
            'vat' => 'IVA',
            'price_per_pax' => 'Prezzo per Persona',
            'num_pax' => 'Num Pax a cui è riferito l\'Importo',
            'is_date' => 'È necessario prenotare in una data specifica?',
            'is_hour' => 'È necessario indicare un orario?',
            'is_name' => 'È necessario indicare un nominativo?',
            'is_card' => 'È una Card/Abbonamento?',
            'has_additional_code' => 'Possiede un Codice Addizionale',
            'is_link' => 'È un link?',
            'product_link' => 'Link del Prodotto',
            'max_scans' => 'Numero Max di Scansioni',
            'qr_code' => 'QR Code Sostitutivo',
            'online_reservation_delay' => 'Dopo quanti giorni è possibile prenotare?',
            'check_document' => 'Controllo Documento',
            'reductions' => 'Riduzioni Associate',
            'reduction_fields' => 'Campi di riduzione da compilare',
            'has_supplier' => 'Richiede Fornitore',
            'supplier_id' => 'Fornitore',
            'validity_from_issue_unit' => 'Unità di validità dall\'emissione',
            'validity_from_issue_value' => 'Valore di validità dall\'emissione',
            'validity_from_burn_unit' => 'Unità di validità dal primo utilizzo',
            'validity_from_burn_value' => 'Valore di validità dal primo utilizzo',
            'product_validities' => 'Date/Ore di validità',
            'start_validity' => 'Inizio Validità',
            'end_validity' => 'Fine Validità',
            'add_validity' => 'Aggiungi Periodo di Validità',
            'is_cumulative' => 'È un Cumulativo?',
            'exclude-slotcount' => 'Escludi da conteggio posti disponibili',
            'is-siae' => 'È un prodotto SIAE?',
            'product_cumulatives' => [
                'name' => 'Quali Siti Museali comprende?',
                'max_scans' => 'Numero massimo scansioni',

            ],
            'related_products' => 'Associa prodotti da vendere insieme',
            'slots' => [
                'slot_day_id' => 'Giorno',
                'slot_type' => 'Tipologia Slot',
                'duration' => 'Durata Slot',
                'availability' => 'Pax',
                'hours' => 'Orari Slot',
                'add_slot' => 'Aggiungi Slot',
                'advance_tolerance' => 'Tolleranza anticipo (minuti)',
                'delay_tolerance' => 'Tolleranza ritardo (minuti)'
            ],
            'customer' => [
                'online' => 'Cliente/OnLine',
                'onsite' => 'Cliente/OnSite',
                'tvm' => 'Cliente/TVM'
            ],
            'agency' => [
                'online' => 'Agenzia/OnLine',
                'onsite' => 'Agenzia/OnSite',
                'tvm' => 'Agenzia/TVM'
            ],
            'school' => [
                'online' => 'Scuola/OnLine',
                'onsite' => 'Scuola/OnSite',
                'tvm' => 'Scuola/TVM'
            ],
            'notes' => 'Note'
        ],
        'table' => [
            'service' => [
                'product_category' => [
                    'name' => 'Categoria'
                ],
            ],
            'service' => [
                'name' => 'Servizio'
            ],
            'site' => [
                'name' => 'Sito Museale'
            ],
            'code' => 'Codice',
            'name' => 'Nome',
            'article' => 'Articolo',
            'active' => 'Status',
            'price_sale' => 'Importo Vendita',
            'price_purchase' => 'Importo Acquisto'
        ],
        'filters' => [
            'active' => 'Status',
            'site_id' => 'Sito Museale'
        ],
        'actions' => [
            'products' => 'Prodotti'
        ]
    ];
