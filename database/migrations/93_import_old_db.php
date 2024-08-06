<?php

use App\Models\OrderItemReduction;
use App\Models\SiteHour;
use Illuminate\Support\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Slot;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        DB::statement('INSERT INTO services (
                id, product_category_id, site_id, code, name, slug, active, is_purchasable,
                is_date, is_hour, is_language, is_pickup, is_min_pax, min_pax, is_max_pax,
                max_pax, is_duration, is_pending, online_reservation_delay, closing_reservation,
                is_archived, archived_at, archived_by, created_at, updated_at
            )
            SELECT
                id, product_category_id, site_id, code, name, COALESCE(slug, ""), active,
                is_purchasable, is_date, is_hour, is_language, is_pickup, is_pax AS is_min_pax,
                min_pax, is_pax AS is_max_pax, min_pax AS max_pax, is_duration, is_pending,
                reservation_delay AS online_reservation_delay, closing_reservation, archived AS is_archived,
                archived_at, archived_by, created_at, updated_at
            FROM thekey.services
            WHERE NOT EXISTS (SELECT 1 FROM services WHERE services.id = thekey.services.id)
        ');
        DB::statement('INSERT INTO products (
            id, service_id, has_supplier, supplier_id, product_subcategory_id, active, code,
            article, name, slug, price_sale, price_purchase, price_web, vat, price_per_pax,
            num_pax, check_document, printable, deliverable, billable, is_date, is_hour,
            is_name, is_card, is_link, product_link, matrix_generation_type,
            validity_from_issue_unit, validity_from_issue_value, validity_from_burn_unit,
            validity_from_burn_value, max_scans, has_additional_code, qr_code,
            online_reservation_delay, notes, revenue_account, sale_matrix, created_at, updated_at
        )
        SELECT
        products.id, service_id, has_supplier, supplier_id, product_subcategory_id, products.active, products.code,
        sku, CASE WHEN services.product_category_id = 5 THEN simple_name ELSE products.name END as name,
        CASE WHEN products.slug = "" THEN LOWER(REPLACE(products.simple_name, " ", "-"))
        ELSE products.slug
        END as slug,
        price_sale, price_purchase, price_web, vat,
        price_per_pax, num_pax, check_document, printable, deliverable, billable,
        products.is_date, products.is_hour, is_name, is_card, is_link, product_link,
        matrix_generation_type, validity_from_issue_unit, validity_from_issue_value,
        validity_from_burn_unit, validity_from_burn_value, COALESCE(max_scans, 1) AS max_scans,
        COALESCE(has_additional_code, 0) AS has_additional_code, qr_code,
        reservation_delay AS online_reservation_delay, notes, revenue_account,
        JSON_OBJECT(
            "schools", JSON_OBJECT(
                "crm", MAX(CASE WHEN type_user = "school" AND type_channel = "crm" THEN matrix_value END) = 1,
                "tvm", MAX(CASE WHEN type_user = "school" AND type_channel = "tvm" THEN matrix_value END) = 1,
                "online", MAX(CASE WHEN type_user = "school" AND type_channel = "online" THEN matrix_value END) = 1,
                "onsite", MAX(CASE WHEN type_user = "school" AND type_channel = "onsite" THEN matrix_value END) = 1
            ),
            "agencies", JSON_OBJECT(
                "crm", MAX(CASE WHEN type_user = "agency" AND type_channel = "crm" THEN matrix_value END) = 1,
                "tvm", MAX(CASE WHEN type_user = "agency" AND type_channel = "tvm" THEN matrix_value END) = 1,
                "online", MAX(CASE WHEN type_user = "agency" AND type_channel = "online" THEN matrix_value END) = 1,
                "onsite", MAX(CASE WHEN type_user = "agency" AND type_channel = "onsite" THEN matrix_value END) = 1
            ),
            "customers", JSON_OBJECT(
                "crm", MAX(CASE WHEN type_user = "customer" AND type_channel = "crm" THEN matrix_value END) = 1,
                "tvm", MAX(CASE WHEN type_user = "customer" AND type_channel = "tvm" THEN matrix_value END) = 1,
                "online", MAX(CASE WHEN type_user = "customer" AND type_channel = "online" THEN matrix_value END) = 1,
                "onsite", MAX(CASE WHEN type_user = "customer" AND type_channel = "onsite" THEN matrix_value END) = 1
            )
        ) AS sale_matrix,
        products.created_at, products.updated_at
        FROM thekey.products
        LEFT JOIN thekey.product_sale_matrix ON thekey.products.id = thekey.product_sale_matrix.product_id
        LEFT JOIN services ON services.id = products.service_id
        WHERE NOT EXISTS (
        SELECT 1 FROM products WHERE products.id = thekey.products.id
        )
        GROUP BY thekey.products.id
        ');


        DB::statement('INSERT INTO sites (
            id, pole_id, company_id, unlock_matrix_pole_id, slug, name, canonical_name, address, city,
            region, lat, lng, is_comingsoon, is_closed, in_concession, matrix_suffix, access_control_enabled,
            poll_enabled, cashier_fee_enabled, tvm, onsite_auto_scan, created_at, updated_at
        ) SELECT
            id, pole_id, company_id, unlock_matrix_pole_id, slug, name, canonical_name, address, city,
            region, lat, lng, is_comingsoon, is_closed, in_concession, matrix_suffix, access_control_enabled,
            poll_enabled, cashier_fee_enabled, tvm, onsite_auto_scan, created_at, updated_at
        FROM thekey.sites
        WHERE NOT EXISTS (SELECT 1 FROM sites WHERE sites.id = thekey.sites.id)');

        DB::statement('INSERT INTO cashiers (
            id, site_id, code, name, active, has_shifts, cashfund, created_at, updated_at
        ) SELECT
            id, site_id, code, name, active, is_shift AS has_shifts, COALESCE(cashfund, 0), created_at, updated_at
        FROM thekey.cashiers
        WHERE NOT EXISTS (SELECT 1 FROM cashiers WHERE cashiers.id = thekey.cashiers.id)');

        DB::statement('INSERT INTO cashier_register_closures SELECT * FROM thekey.cash_register_closures
        WHERE NOT EXISTS (SELECT 1 FROM cashier_register_closures WHERE cashier_register_closures.id = thekey.cash_register_closures.id)');

        DB::statement('INSERT INTO product_cumulatives (
            product_id, site_id
        ) SELECT
        cumulative_product_id, site_id
        FROM thekey.cumulative_sites WHERE EXISTS (
        SELECT 1 FROM products WHERE id = cumulative_product_id)
        AND NOT EXISTS (SELECT 1 FROM product_cumulatives
        WHERE product_cumulatives.product_id = thekey.cumulative_sites.cumulative_product_id AND product_cumulatives.site_id = thekey.cumulative_sites.site_id )');

        DB::statement('UPDATE products
            SET is_cumulative = 1
            WHERE id IN (SELECT cumulative_product_id FROM thekey.cumulative_sites)');

        DB::statement('INSERT INTO product_validities (
            product_id, start_validity, end_validity, created_at, updated_at
        ) SELECT
            product_id, start_validity, COALESCE(end_validity, "2099-12-31"), created_at, updated_at
         FROM thekey.product_validities
        WHERE NOT EXISTS (SELECT 1 FROM product_validities WHERE product_validities.id = thekey.product_validities.id)');

        DB::statement('INSERT INTO virtual_store_orders SELECT * FROM thekey.virtual_store_orders
        WHERE NOT EXISTS (SELECT 1 FROM virtual_store_orders WHERE virtual_store_orders.id = thekey.virtual_store_orders.id)');


         DB::statement('INSERT INTO payments ( id, code, total, fee, payment_type_id, created_at, updated_at )
            SELECT p.id, p.code, p.total, p.fee, COALESCE(pt.id, 0) AS payment_type_id, p.created_at, p.updated_at
            FROM thekey.payments p
            LEFT JOIN thekey.payment_types pt ON p.gateway = pt.code
            WHERE NOT EXISTS (SELECT 1 FROM payments WHERE payments.id = thekey.p.id)
        ');

        DB::statement('INSERT INTO orders (
            id, order_number, prefix, progressive, year, price, duty_stamp, user_id, order_type_id,
            order_status_id, payment_id, cashier_id, company_id, email_to, email_sent, can_modify, print_at_home,
            printed_at, completed_at, notes, created_at, updated_at, printed_counter
        )
         SELECT
            id, order_number, prefix, progressive, year, price, bollo AS duty_stamp, 1 AS user_id, type_id AS order_type_id,
            status_id AS order_status_id, payment_id, cashier_id, COALESCE(company_id, 1), email_to, email_sent, can_modify, print_at_home,
            printed_at, completed_at, notes, created_at, updated_at, printed_counter
         FROM thekey.orders
        WHERE NOT EXISTS (SELECT 1 FROM orders WHERE orders.id = thekey.orders.id)');

        DB::statement('INSERT INTO order_items (
            id, order_id, product_id, promo_id, order_item_status_id, order_item_delete_flag, qty, price, validity,
            is_cumulative, printable_qr_code, printable_qr_link, date_service, hour_service, language_service,
            num_pax_service, pickup_service, duration_service, reduction_id, reduction_notes, notes,
            created_at, updated_at, discount, payment_id
        ) SELECT
            id, order_id, product_id, promo_id, order_item_status_id, order_item_delete_flag, qty, price, validity,
            is_cumulative, printable_qr_code, printable_qr_link, date_service, hour_service, language_service,
            num_pax_service, pickup_service, duration_service, reduction_id, reduction_notes, notes,
            created_at, updated_at, discount, payment_id
            FROM thekey.order_items
        WHERE NOT EXISTS (SELECT 1 FROM order_items WHERE order_items.id = thekey.order_items.id)');

        $query = DB::query()
        ->selectRaw('
            id,
            LOWER(REPLACE(short_reduction, " ", "-")) AS slug,
            reduction AS name,
            short_reduction AS short_name,
            1 AS active,
            product_id,
            CASE
                WHEN code = "reduction" THEN "reduced"
                WHEN code = "hidden" THEN "free"
                ELSE code
            END AS reduction_type,
            created_at,
            updated_at FROM thekey.reductions')
        ->whereRaw('deleted_at IS NULL')->get();

        foreach($query AS $row){

            $check = DB::query()
            ->selectRaw('id FROM reductions')
            ->where('name', $row->name)->first();
            if(!$check){
                DB::statement('
                INSERT INTO reductions (id, slug, name, short_name, active, reduction_type, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                $row->id, $row->slug, $row->name, $row->short_name, $row->active, $row->reduction_type, $row->created_at, $row->updated_at
            ]);
                $reduction_id = $row->id;
            }else{
                $reduction_id = $check->id;
            }
            DB::statement('
                INSERT INTO product_reductions (product_id, reduction_id)
                SELECT '.$row->product_id.', '.$reduction_id.'
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM product_reductions
                    WHERE product_id = '.$row->product_id.' AND reduction_id = '.$reduction_id.'
                )
            ');

            DB::statement('
                INSERT IGNORE INTO product_reduction_fields (product_id, reduction_field_id) VALUES
                ('.$row->product_id.', 1),
                ('.$row->product_id.', 2),
                ('.$row->product_id.', 3),
                ('.$row->product_id.', 4),
                ('.$row->product_id.', 5),
                ('.$row->product_id.', 6),
                ('.$row->product_id.', 7)
            ');
        }

        DB::statement('INSERT INTO product_holders (
            id, order_item_id, product_id, first_name, last_name, expired_at, created_at, updated_at)
            SELECT id, order_item_id, product_id, first_name, last_name, expired_at, created_at, updated_at FROM thekey.product_holders
            WHERE NOT EXISTS (SELECT 1 FROM product_holders WHERE product_holders.id = thekey.product_holders.id)');

        DB::statement('INSERT INTO scans (id, virtual_store_matrix_id, operator_id,
            order_item_id, is_scanned, verification_needed, qr_code, date_scanned, date_expiration, created_at, updated_at)
            SELECT id, virtual_store_matrix_id, operator_id,
            order_item_id, is_scanned, verification_needed, qr_code, date_scanned, date_expiration, created_at, updated_at
            FROM thekey.scans
            WHERE NOT EXISTS (SELECT 1 FROM scans WHERE scans.id = thekey.scans.id)');

        DB::statement('INSERT INTO scan_logs SELECT * FROM thekey.scans_log
            WHERE NOT EXISTS (SELECT 1 FROM scan_logs WHERE scan_logs.id = thekey.scans_log.id)');

        DB::statement('INSERT INTO virtual_store_lots SELECT * FROM thekey.virtual_store_lots
            WHERE NOT EXISTS (SELECT 1 FROM virtual_store_lots WHERE virtual_store_lots.id = thekey.virtual_store_lots.id)');

        DB::statement('INSERT INTO virtual_store_matrices SELECT * FROM thekey.virtual_store_matrices
            WHERE NOT EXISTS (SELECT 1 FROM virtual_store_matrices WHERE virtual_store_matrices.id = thekey.virtual_store_matrices.id)');

        $slot_days = ["tue", "mon", "wed", "thu", "fri", "sat", "sun", "hol"];
        //slot servizi
        $query = DB::query()
        ->selectRaw("ss.id, ss.hour_type, ss.hour_type_detail, ss.hour_duration, ss.max_availability, se.availability_tollerance
                FROM thekey.services AS ss")
        ->leftJoin('thekey.sites AS se', 'se.id', 'ss.site_id')
        ->whereRaw("hour_type IN ('slot_fixed', 'free') AND NOT EXISTS
                (SELECT 1 FROM `mims-2024`.slots where slots.service_id = ss.id)")->get();
        foreach($query AS $row){
            if($row->hour_type == 'free'){
                $arr_slot = [
                    'duration' => ($row->hour_duration == null) ? 90 : $row->hour_duration,
                    'service_id' => $row->id,
                    'slot_type' => 'repeated',
                    'advance_tolerance' => 60,
                    'delay_tolerance' => ($row->availability_tollerance == null) ? 90 : $row->availability_tollerance,
                    'availability' => $row->max_availability,
                    'slot_days' => $slot_days
                ];
                Slot::create($arr_slot);
            }elseif($row->hour_type == 'slot_fixed'){
                $array_slots = json_decode($row->hour_type_detail, true);
                $data_slot = array();

                foreach ($array_slots as $day => $slot) {
                    if($slot['enabled'] == 1){
                        $slots_key = implode(',', $slot['slots']);
                        if (!isset($data_slot[$slots_key])) {
                            $data_slot[$slots_key] = array();
                        }
                        $data_slot[$slots_key][] = $day;
                    }
                }

                foreach ($data_slot as $hours => $days) {
                    $arr_slot = [
                        'duration' => ($row->hour_duration == null) ? 90 : $row->hour_duration,
                        'service_id' => $row->id,
                        'slot_type' => 'free',
                        'advance_tolerance' => 60,
                        'delay_tolerance' => ($row->availability_tollerance == null) ? 90 : $row->availability_tollerance,
                        'availability' => $row->max_availability,
                        'slot_days' => $days,
                        'hours' => explode(",", $hours)
                    ];
                    Slot::create($arr_slot);
                }
            }
        }

        //slot prodotti
        $query = DB::query()
        ->selectRaw("p.id, p.hour_type, p.hour_type_detail, p.hour_duration, p.max_availability, se.availability_tollerance
                FROM thekey.products AS p")
        ->leftJoin('thekey.services AS ss', 'ss.id', 'p.service_id')
        ->leftJoin('thekey.sites AS se', 'se.id', 'ss.site_id')
        ->whereRaw("p.hour_type IN ('slot_fixed', 'free') AND NOT EXISTS
                (SELECT 1 FROM `mims-2024`.slots where slots.product_id = p.id)")->get();
        foreach($query AS $row){
            if($row->hour_type == 'free'){
                $arr_slot = [
                    'duration' => ($row->hour_duration == null) ? 90 : $row->hour_duration,
                    'product_id' => $row->id,
                    'slot_type' => 'repeated',
                    'advance_tolerance' => 60,
                    'delay_tolerance' => ($row->availability_tollerance == null) ? 90 : $row->availability_tollerance,
                    'availability' => $row->max_availability,
                    'slot_days' => $slot_days
                ];
                Slot::create($arr_slot);
            }elseif($row->hour_type == 'slot_fixed'){
                $array_slots = json_decode($row->hour_type_detail, true);
                $data_slot = array();

                foreach ($array_slots as $day => $slot) {
                    if($slot['enabled'] == 1){
                        $slots_key = implode(',', $slot['slots']);
                        if (!isset($data_slot[$slots_key])) {
                            $data_slot[$slots_key] = array();
                        }
                        $data_slot[$slots_key][] = $day;
                    }
                }

                foreach ($data_slot as $hours => $days) {
                    $arr_slot = [
                        'duration' => ($row->hour_duration == null) ? 90 : $row->hour_duration,
                        'product_id' => $row->id,
                        'slot_type' => 'free',
                        'advance_tolerance' => 60,
                        'delay_tolerance' => ($row->availability_tollerance == null) ? 90 : $row->availability_tollerance,
                        'availability' => $row->max_availability,
                        'slot_days' => $days,
                        'hours' => explode(",", $hours)
                    ];
                    Slot::create($arr_slot);
                }
            }
        }

        $query = DB::table('thekey.order_item_reductions')->take('1000')->get();
        foreach($query AS $item){
            if($item->order_item_id != null){
                if($item->last_name != '' && $item->last_name != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 1, 'value' => $item->last_name
                    ];
                }
                if($item->first_name != '' && $item->first_name != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 2, 'value' => $item->first_name
                    ];
                }
                if($item->document_type_id != '' && $item->document_type_id != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 3, 'value' => $item->document_type_id
                    ];
                }
                if($item->document_url != '' && $item->document_url != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 4, 'value' => $item->document_url
                    ];
                }
                if($item->document_id != '' && $item->document_id != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 5, 'value' => $item->document_id
                    ];
                }
                if($item->document_expire_at != '' && $item->document_expire_at != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 6, 'value' => $item->document_expire_at
                    ];
                }
                if($item->document_issued_by != '' && $item->document_issued_by != null){
                    $order_item_reduction_data[] = [
                        'reduction_id' => $item->reduction_id, 'order_item_id' => $item->order_item_id,'reduction_field_id' => 7, 'value' => $item->document_issued_by
                    ];
                }

                foreach ($order_item_reduction_data as $value) {
                    $sql = "INSERT IGNORE INTO order_item_reductions (reduction_id, order_item_id, reduction_field_id, value) VALUES ({$value['reduction_id']}, {$value['order_item_id']}, {$value['reduction_field_id']}, '".addslashes($value['value'])."')";
                    DB::insert($sql);
                }
            }
        }

        DB::statement('INSERT IGNORE INTO suppliers SELECT * FROM thekey.suppliers');

        DB::statement('INSERT IGNORE INTO document_types SELECT * FROM thekey.document_types');


        $query = DB::table('thekey.site_full_hours')
        ->join('thekey.site_workstations', 'site_workstations.id', 'site_full_hours.workstation_id' )->get();
        $openings = array();
        foreach($query AS $hour){
            // le pause le si aggiungono a mano, ci sono solo 3 record

            if($hour->mon_start != '00:00:00' && $hour->mon_end != '00:00:00'){
                $slotKey = $hour->mon_start.",".$hour->mon_end.",".$hour->mon_break_start.",".$hour->mon_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'mon';
            }
            if($hour->tue_start != '00:00:00' && $hour->tue_end != '00:00:00'){
                $slotKey = $hour->tue_start.",".$hour->tue_end.",".$hour->tue_break_start.",".$hour->tue_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'tue';
            }
            if($hour->wed_start != '00:00:00' && $hour->wed_end != '00:00:00'){
                $slotKey = $hour->wed_start.",".$hour->wed_end.",".$hour->wed_break_start.",".$hour->wed_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'wed';
            }
            if($hour->thu_start != '00:00:00' && $hour->thu_end != '00:00:00'){
                $slotKey = $hour->thu_start.",".$hour->thu_end.",".$hour->thu_break_start.",".$hour->thu_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'thu';
            }
            if($hour->fri_start != '00:00:00' && $hour->fri_end != '00:00:00'){
                $slotKey = $hour->fri_start.",".$hour->fri_end.",".$hour->fri_break_start.",".$hour->fri_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'fri';
            }
            if($hour->sat_start != '00:00:00' && $hour->sat_end != '00:00:00'){
                $slotKey = $hour->sat_start.",".$hour->sat_end.",".$hour->sat_break_start.",".$hour->sat_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'sat';
            }
            if($hour->sun_start != '00:00:00' && $hour->sun_end != '00:00:00'){
                $slotKey = $hour->sun_start.",".$hour->sun_end.",".$hour->sun_break_start.",".$hour->sun_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'sun';
            }
            if($hour->hol_start != '00:00:00' && $hour->hol_end != '00:00:00'){
                $slotKey = $hour->hol_start.",".$hour->hol_end.",".$hour->hol_break_start.",".$hour->hol_break_end;
                $openings[$hour->site_id][$hour->month][$slotKey][] = 'hol';
            }
        }

        foreach($openings as $site_id => $sites){
            foreach($sites as $month => $hours){
                foreach($hours as $hour => $days){
                    $hour = explode(",", $hour);
                    $start = $hour[0];
                    $end = $hour[1];
                    $break_start = ($hour[2] == "") ? null : $hour[2];
                    $break_end = ($hour[3] == "") ? null : $hour[3];
                    $startOfMonth = Carbon::create(null, $month, 1)->startOfMonth()->format('Y-m-d');
                    $endOfMonth = Carbon::create(null, $month, 1)->endOfMonth()->format('Y-m-d');
                    $existingRecord = SiteHour::where('site_id', $site_id)
                                              ->whereJsonContains('day', array_unique($days))
                                              ->where('start_validity', $startOfMonth)
                                              ->first();
                    if (!$existingRecord) {
                        SiteHour::create([
                            'site_id' => $site_id,
                            'day' => array_unique($days),
                            'opening' => $start,
                            'closing_ticket_office' => $end,
                            'closing' => $end,
                            'break_start' => $break_start,
                            'break_end' => $break_end,
                            'start_validity' => $startOfMonth,
                            'end_validity' => $endOfMonth,
                        ]);
                    }
                }
            }
        }

        // Esempio: DB::statement('INSERT INTO nuovo_database.other_table SELECT * FROM vecchio_database.other_table');
    }
/*

*/
    // appunti: campo USER_ID su ordine??? Mancano utenti
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
