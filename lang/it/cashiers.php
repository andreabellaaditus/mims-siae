<?php

return [
    'model-label' => 'Cassiere',
    'plural-model-label' => 'Cassieri',
    'navigation-label' => 'Cassieri',
    'navigation-group' => 'Utenti',
    'fieldsets' => [
        'basis_information' => 'Informazioni Base',
        'user_personal_data' => 'Dati Personali',
        'user_site' => 'Siti associati',
        'user_medical_visits' => 'Visite Mediche',
        'user_courses' => 'Corsi',
        'user_equipments' => 'Dotazioni',
        'user_contracts' => 'Contratti',
    ],
    'form' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'E-Mail',
        'email_verified_at' => 'Data Verifica',
        'password' => 'Password',
        'password_expired_at' => 'Scadenza Password',
        'first_login_at' => 'Primo Accesso',
        'active' => 'Attivo',
        'anonymized' => 'Anonimizzato',
        'anonymized_at' => 'Data Anonimizzazione',
        'deleted_at' => 'Data Cancellazione',
        'roles' => 'Ruoli',
        'created_at' => 'Data Creazione',
        'user_medical_visits' => [
            'visit_date' => 'Data Visita',
            'visit_expiry' => 'Scadenza Visita',
            'visit_description' => 'Descrizione Visita',
            'visit_duration' => 'Copertura (anni)',
            'add_user_medical_visits' => 'Aggiungi Visita Medica',
        ],
        'user_courses' => [
            'course_date' => 'Data Corso',
            'course_description' => 'Descrizione Corso',
            'course_duration' => 'Durata (h))',
            'course_validity' => 'Validità (anni)',
            'course_expiry' => 'Scadenza Corso',
            'course_effectiveness_description' => 'Efficacia corso',
            'course_effectiveness_evaulation' => 'Valutazione efficacia corso',
            'course_effectiveness_date' => 'Data verifica efficacia',
            'add_user_courses' => 'Aggiungi Corso',
        ],
        'user_equipments' => [
            'assignment_equipment_date' => 'Data assegnazione bene',
            'restitution_equipment_date' => 'Data restituzione bene',
            'equipment_size' => 'Taglia',
            'equipment_registration_number' => 'Matricola bene',
            'equipment_description' => 'Descrizione bene',
            'add_user_equipments' => 'Aggiungi Dotazione',
        ],
        'user_contracts' => [
            'contract_start_date' => 'Data inizio contratto',
            'contract_end_date' => 'Data scadenza contratto',
            'contract_name' => 'Contratto',
            'add_user_contract' => 'Aggiungi Contratto',
        ],
        'user_personal_details' => [
            'contract_start_date' => 'Data inizio contratto',
            'contract_end_date' => 'Data scadenza contratto',
            'contract_name' => 'Contratto',
            'add_user_contract' => 'Aggiungi Contratto',
        ],
        'user_personal_data' => [
            'date_of_birth' => 'Data di nascita',
            'mobile_number' => 'Telefono Cellulare',
            'tax_code' => 'Codice Fiscale',
            'city' => 'Città',
            'address' => 'Indirizzo',
            'post_code' => 'CAP',
            'city_alt' => 'Città alternativa',
            'tax_code_alt' => 'Codice Fiscale alternativo',
            'address_alt' => 'Indirizzo alternativo',
            'post_code_alt' => 'CAP alternativo',
            'qualification_name' => 'Qualifica assunzione',
            'size' => 'Taglia',
            'classification_level' => 'Livello Inquadramento',
            'engagement_date' => 'Data assunzione',
            'termination_date' => 'Data cessazione rapporto',
            'subsidiary_id' => 'Codice filiale',
            'geobadge_id' => 'Codice Geobadge',
        ],
        'user_site' => [
            'sites' => 'Siti',
        ],
    ],
    'tabs' => [
        'registry' => 'Anagrafica',
        'medical_visits' => 'Visite Mediche',
        'courses' => 'Corsi',
        'equipments' => 'Dotazioni',
        'contracts' => 'Contratto',
        'personal_data' => 'Dati Personali',
        'user_site' => 'Siti associati',
    ],
    'table' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'E-Mail',
        'email_verified_at' => 'Data Verifica',
        'password' => 'Password',
        'password_expired_at' => 'Scadenza Password',
        'first_login_at' => 'Primo Accesso',
        'active' => 'Attivo',
        'anonymized' => 'Anonimizzato',
        'anonymized_at' => 'Data Anonimizzazione',
        'deleted_at' => 'Data Cancellazione',
        'roles' => 'Ruoli',
        'created_at' => 'Data Creazione'
    ]
];
