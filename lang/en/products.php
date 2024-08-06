<?php

    return [
        'model-label' => 'Product',
        'plural-model-label' => 'Products',
        'navigation-label' => 'Products',
        'navigation-group' => 'Catalog',
        'slot-error' => 'You cannot insert multiple repeated slots on the same day.',
        'sections' => [
            'required' => '(*) Required',
            'basis_information' => 'Basic Information',
            'matrices' => 'Matrix Generation at Purchase Phase',
            'prices' => 'Prices & VAT',
            'seats_and_scans' => 'Bookings & Slot Information',
            'document_check' => 'Reductions',
            'supplier' => 'Supplier',
            'validities' => 'Validity Periods',
            'cumulatives' => 'Cumulative',
            'sales_matrix' => 'Sales Channels',
            'notes' => 'Notes',
            'slots' => 'Slots',
            'related_products' => 'Related products'
        ],
        'tabs' => [
            'basis_information' => 'Basic Info',
            'matrices' => 'Matrices',
            'prices' => 'Prices',
            'seats_and_scans' => 'Bookings',
            'document_check' => 'Reductions',
            'supplier' => 'Supplier',
            'validities' => 'Validity',
            'cumulatives' => 'Cumulative',
            'sales_matrix' => 'Sales Channels',
            'notes' => 'Notes',
            'slots' => 'Slots',
            'related_products' => 'Related products'
        ],
        'form' => [
            'code' => 'Code',
            'article' => 'Article',
            'name' => 'Name',
            'slug' => 'Slug',
            'active' => 'Status',
            'deliverable' => 'Deliverable',
            'printable' => 'Printable',
            'billable' => 'Billable',
            'matrix_generation_type' => 'Matrix Generation Type',
            'matrix_prefix' => 'Matrix Prefix',
            'matrix' => 'Matrix',
            'ticket_type' => 'Ticket Type',
            'price_sale' => 'Sale Amount',
            'price_purchase' => 'Purchase Amount',
            'price_web' => 'Web Amount',
            'vat' => 'VAT',
            'price_per_pax' => 'Price per Pax',
            'num_pax' => 'Number of Pax the Amount refers to',
            'is_date' => 'Is booking date specific?',
            'is_hour' => 'Is time specified?',
            'is_name' => 'Is name required?',
            'is_card' => 'Is it a Card/Subscription?',
            'has_additional_code' => 'Has Additional Code',
            'is_link' => 'Is it a link?',
            'product_link' => 'Product Link',
            'max_scans' => 'Max Number of Scans',
            'qr_code' => 'Substitute QR Code',
            'online_reservation_delay' => 'After how many days can it be booked?',
            'check_document' => 'Document Check',
            'reductions' => 'Associated Reductions',
            'reduction_fields' => 'Fields to Specify',
            'has_supplier' => 'Requires Supplier',
            'supplier_id' => 'Supplier',
            'validity_from_issue_unit' => 'Validity Unit from issue',
            'validity_from_issue_value' => 'Validity Value from issue',
            'validity_from_burn_unit' => 'Validity Unit from first use',
            'validity_from_burn_value' => 'Validity Value from first use',
            'product_validities' => 'Validity Dates/Times',
            'start_validity' => 'Start Validity',
            'end_validity' => 'End Validity',
            'add_validity' => 'Add Validity Period',
            'is_cumulative' => 'Is it Cumulative?',
            'is-siae' => 'Is it a SIAE product?',
            'exclude-slotcount' => 'Exclude from available spots count',
            'product_cumulatives' => [
                'name' => 'Which Museum Sites does it include?',
                'max_scans' => 'Maximum number of scans',
            ],
            'related_products' => 'Associate products to sell together',
            'slots' => [
                'slot_day_id' => 'Day',
                'slot_type' => 'Slot Type',
                'duration' => 'Slot Duration',
                'availability' => 'Pax',
                'hours' => 'Slot Hours',
                'add_slot' => 'Add Slot',
                'advance_tolerance' => 'Advance tolerance (minutes)',
                'delay_tolerance' => 'Delay tolerance (minutes)'
            ],
            'customer' => [
                'online' => 'Customer/Online',
                'onsite' => 'Customer/OnSite',
                'tvm' => 'Customer/TVM'
            ],
            'agency' => [
                'online' => 'Agency/Online',
                'onsite' => 'Agency/OnSite',
                'tvm' => 'Agency/TVM'
            ],
            'school' => [
                'online' => 'School/Online',
                'onsite' => 'School/OnSite',
                'tvm' => 'School/TVM'
            ],
            'notes' => 'Notes'
        ],
        'table' => [
            'service' => [
                'product_category' => [
                    'name' => 'Category'
                ],
            ],
            'service' => [
                'name' => 'Service'
            ],
            'site' => [
                'name' => 'Museum Site'
            ],
            'code' => 'Code',
            'name' => 'Name',
            'article' => 'Article',
            'active' => 'Status',
            'price_sale' => 'Sale Amount',
            'price_purchase' => 'Purchase Amount'
        ],
        'filters' => [
            'active' => 'Status',
            'site_id' => 'Museum Site'
        ],
        'actions' => [
            'products' => 'Products'
        ]
    ];

