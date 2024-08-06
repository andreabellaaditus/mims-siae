<?php

    return [
        'model-label' => 'Order',
        'plural-model-label' => 'Orders',
        'navigation-label' => 'Orders',
        'navigation-group' => 'On Site Sale',
        'empty-cart' => 'Empty cart',
        'select-cashier' => 'Select a location',

        'date-service' => 'Service date',
        'hour-service' => 'Hour',
        'open-ticket' => 'Open',
        'no-slots' => 'No slots available...',
        'no-products-selected' => 'It is not possible to create an order without inserting products!',
        'at-least-one' => 'Add at least one product',
        'unit-price' => 'Unit price',
        'scans' => 'Scans',
        'location' => 'Location',
        'list' => 'Orders list',
        'cart' => 'Cart products',
        'refresh-orders-table' => 'Refresh orders table',
        'no-reduction-fields-filled' =>'Check that you have filled in all the fields relating to the reductions!',
        'no-name-data-filled' => 'Check that you have filled in all the required names!',
        'no-hour-filled' => 'Check that you have filled in all the required slots!',
        'no-date-filled' => 'Check that you have filled in all the required dates!',
        'select-slot' => 'Select a slot...',
        'no-slot' => 'No slot available',
        'refresh-orders-table' => 'Refresh orders table',
        'change-user' => 'Change user',
        'free-spots' => 'spots available',
        'slot-error' => 'You cannot insert multiple repeated slots on the same day.',
        'export-by-products' => 'Export totals broken down by product',
        'export-by-paymenttype' => 'Export totals broken down by payment type',
        'export-daily-report' => 'Export today\'s orders',
        'company' => 'Company',
        'total_price' => 'Total price',
        'safe' => 'Cassaforte',

        'form' => [
            'select-products' => 'Click on a product in order to add it to your cart',
            'payment-type' => 'Payment type',
            'ticket-limits' => 'Product use restrictions',
            'open-ticket' => 'Open ticket',
            'create' => 'Create order',
        ],

        'scan' => [
            'success-title' => 'Scan successfully completed!',
            'success-desc' => 'The ticket has been cancelled.',
            'ticket-expired' => 'The ticket has expired.',
            'ticket-already-scanned' => 'The ticket has already been scanned.',
            'code-not-exists' => 'The QR code does not exist in the system.',
            'wrong-length' => 'Incorrect QR code length.',
            'code-not-valid' => 'Invalid QR code.',
            'wrong-site' => 'The site associated with the product is incorrect.',
            'max-scans' => 'Exceeded the maximum number of scans.',
            'wrong-date' => 'The date does not match today\'s date.',
            'wrong-hour' => 'The time is not valid for the current time slot.',
        ],

        'cashier' => [
        'check-cash-drawer' => 'Cash Drawer Check',
        'check-cash-drawer-desc' => "<h2 class='text-xl font-semibold'> Cash Check </h2>

        Please kindly verify the cash and inventory in the drawer using the fields below. If you deem it appropriate, you can add a note for any reports to be forwarded to accounting.<br><br>
        <div style='background-color:#dd4b39; color:white; padding:2%; text-align: -webkit-center;'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
        <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z' /></svg>
        Remember to include the cash fund in the total in the drawer.</div>",

        'successful-opening' => 'Cash Drawer Successfully Opened!',
        'successful-opening-desc' => 'You can now proceed with ticket issuance; remember to perform the cash drawer closing procedure at the end of your shift.',
        'cashier-already-open' => 'The cash drawer is already open, please refresh the page',
        'cashier-already-in-use' => 'The cash drawer is already in use by ',

        'closure-cash-amount-registered' => 'Previous Cash Drawer Closing',
        'opening-cash-amount-registered' => 'Present in Drawer',
        'select-cashier' => 'Select Cashier',
        'cashier-opening' => 'Cash Drawer Opening',
        'cashier-closing' => 'Cash Drawer Closing',
        'close-other' => 'Another cashier open',
        'select-cashier-desc' => 'Select a cashier from the following list:',

        'closure-pos-amount-calculated' => 'System Registered Total',
        'closure-pos-amount-registered' => 'Total from POS Terminal',
        'closure-voucher-amount-calculated' => 'System Registered Total',
        'closure-voucher-amount-registered' => 'Voucher Amount Accounted For',
        'closure-paid-amount-registered' => 'System Registered Cash',
        'closure-paid-amount-accounted' => 'Cash Deposited in Safe',
        'cash-to' => 'Cash Handed to',
        'closure-hand-amount-registered' => 'Cash Handed Over',
        'tot-cash-opening' => 'Total Drawer Opening',
        'closure-cash-amount-calculated' => 'Expected Cash in Drawer',
        'closure-cash-amount-registered' => 'Cash Present in Drawer',
        'alert-check-cash' => "<div style='background-color:#dd4b39; color:white; padding:2%; text-align: -webkit-center;'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
        <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z' /></svg>
        Include the cash fund in the total in the drawer.</div>",
        'no-cashier-selected' => 'No cashier selected',
        'no-closable' => 'The currently active cashier cannot be closed, please try refreshing the page and try again',
        'no-open-cashier-for' => 'No positions are currently open in charge of ',

        'successfully-selected' => 'New cashier selected successfully',
        'proceed' => 'You can now proceed with issuing tickets',

    ],

    'generic-error' => [
        'title' => 'Attention!',
        'message' => 'An error occurred while saving, please try again.',
    ],
    'validation' => [
        'error-title' => 'Attention!',
        'error-message' => 'The following fields were not filled out correctly:<ul>:errors</ul>',
        'errors' => [
            'opening-cash-amount-registered' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-cash-amount-registered' => [
                'required' => '',
                'regex' => 'Total Cash in Drawer is not in correct format',
            ],
            'closure-cash-amount-accounted' => [
                'required' => '',
                'regex' => 'Closing cash total is not in correct format',
            ],
            'closure-pos-amount-registered' => [
                'required' => '',
                'regex' => 'Total POS transactions is not in correct format',
            ],
            'closure-pos-amount-accounted' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-voucher-amount-registered' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-voucher-amount-accounted' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-paid-amount-registered' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-paid-amount-accounted' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-hand-amount-accounted' => [
                'required' => '',
                'regex' => 'Opening cash total is not in correct format',
            ],
            'closure-hand-amount-to' => [
                'required' => 'The coordinator to whom the cash was handed is mandatory',
            ],

        ]
    ],

    'closure-error' => [
        'title' => 'Attention!',
        'message' => 'There was a problem saving the cash drawer closure.',
    ],
    'receipt-error' => [
        'title' => 'Attention!',
        'message' => 'There was a problem saving the receipts, other data has been saved correctly.',
    ],
    'saved-successfully' => [
        'title' => 'Save Complete!',
        'message' => 'Cash drawer closure data has been successfully saved.<br>Remember to confirm the "cash drawer closure" to complete the procedure.',
    ],
    'confirmed-successfully' => [
        'title' => 'Confirmed Successfully!',
        'message' => 'The "Cash Closure" procedure has been completed.',
    ],
    'cashier-saved-successfully' => [
        'title' => 'Saving Completed!',
        'message' => 'The "Cash Closure" procedure has been completed, please wait for the page to load.',
    ]


];
