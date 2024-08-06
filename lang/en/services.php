<?php
return [
    'navigation-group' => 'Catalogue',
    'slot-error' => 'You cannot insert multiple repeated slots on the same day.',
    'tabs' => [
        'service' => 'Servizio',
        'notifications' => 'Notifiche',
        'slots' => 'Slots',
    ],
        'fieldsets' => [
            'basis_information' => 'Basis Info',
            'reservations' => 'Reservations',
            'archive' => 'Archive',
        ],
        'tabs' => [
            'service' => 'Service',
            'notifications' => 'Notifications',
            'slots' => 'Slots',
        ],
    'form' => [
        'product_category_id' => 'Product Category',
        'site_id' => 'Site',
        'code' => 'Code',
        'name' => 'Name',
        'slug' => 'Slug',
        'active' => 'Status',
        'negozio_id' => 'Store Id (Siae)',
        'is_purchasable' => 'Is Purchasable',
        'is_date' => 'Is it necessary to book on a specific date?',
        'is_hour' => 'Is it necessary to indicate a time?',
        'is_language' => 's it necessary to indicate a language?',
        'is_pickup' => 'Is it necessary to indicate a pickup point?',
        'is_duration' => 'Is it necessary to indicate a specific duration?',
        'is_pending' => 'Is it subject to backend approval?',
        'is_min_pax' => 'Is it necessary to indicate a minimum number of pax',
        'min_pax' => 'Minimum number of pax',
        'is_max_pax' => 'It is necessary to indicate a maximum number of pax?',
        'max_pax' => 'Maximum number of pax',
        'online_reservation_delay' => 'After how many days is it possible to book?',
        'closing_reservation' => 'How many hours in advance to close reservations?',
        'is_archived' => 'Is the item archived?',
        'archived_at' => 'Archived at',
        'archived_by' => 'Archived by',
        'service_notifications' => [
            'recipients' => 'Recipient',
            'notification_frequency_id' => 'Notification Frequency',
            'add_notification_service' => 'Add Recipient Notifications',
        ],
        'slots' => [
            'slot_day_id' => 'Day',
            'slot_type' => 'Slot Type',
            'duration' => 'Slot Duration',
            'availability' => 'Pax',
            'hours' => 'Slot Hours',
            'add_slot' => 'Add Slot',
            'advance_tolerance' => 'Advance tolerance (minutes)',
            'delay_tolerance' => 'Delay tolerance (minutes)'
        ]
    ],
    'table' => [
        'product_category' => [
            'name' => 'Product Category'
        ],
        'site' => [
            'name' => 'Site'
        ],
        'code' => 'Code',
        'name' => 'Name',
        'slug' => 'Slug',
        'active' => 'Status',
        'is_purchasable' => 'Is Purchasable',
        'is_archived' => 'Is Archived'
    ],
    'filters' => [
        'active' => 'Status',
        'is_archived' => 'Don\'t show archived',
        'site_id' => 'Sites'
    ],
    'actions' => [
        'products' => 'Products'
    ]
];

?>
