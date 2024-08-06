<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $access_control_device_id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\AccessControlDevice|null $access_control_device
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange whereAccessControlDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlChange whereUpdatedAt($value)
 */
	class AccessControlChange extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string|null $area
 * @property string|null $name
 * @property string $type
 * @property int $site_id
 * @property int $active
 * @property string|null $status
 * @property int|null $logging_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $entrance_enabled
 * @property int $exit_enabled
 * @property string|null $last_message
 * @property string|null $ip
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereEntranceEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereExitEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereLastMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereLoggingEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDevice whereUpdatedAt($value)
 */
	class AccessControlDevice extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $access_control_device_id
 * @property string|null $status
 * @property string|null $message
 * @property string|null $request
 * @property string|null $response
 * @property string|null $qr_code
 * @property string|null $qr_code_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AccessControlDevice|null $access_control_device
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereAccessControlDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereQrCodeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlDeviceDebug whereUpdatedAt($value)
 */
	class AccessControlDeviceDebug extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property \ArrayObject|null $enabled_sites
 * @property string|null $qr_code
 * @property string $first_name
 * @property string $last_name
 * @property string $expire_at
 * @property int $issued_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $enabled_sites_ids
 * @property-read mixed $enabled_sites_labels
 * @property-read mixed $expire_date
 * @property-read mixed $issued_at
 * @property-read \App\Models\User|null $issuedBy
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereEnabledSites($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlPass whereUpdatedAt($value)
 */
	class AccessControlPass extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $device_id
 * @property string|null $qr_code
 * @property string|null $direction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AccessControlDevice|null $access_control_device
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessControlQrcodeLog whereUpdatedAt($value)
 */
	class AccessControlQrcodeLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartProduct> $cart_products
 * @property-read int|null $cart_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $cart_id
 * @property int|null $product_id
 * @property string|null $date_service
 * @property string|null $hour_service
 * @property int $open_ticket
 * @property int $is_cumulative
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $holder_first_name
 * @property string|null $holder_last_name
 * @property-read \App\Models\Cart $cart
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereDateService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereHolderFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereHolderLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereHourService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereIsCumulative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereOpenTicket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereUpdatedAt($value)
 */
	class CartProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $site_id
 * @property string|null $cashier_type
 * @property string|null $code
 * @property string|null $name
 * @property int $active
 * @property int $has_shifts
 * @property int $cashfund
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $siae_terminal_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\SiaeOrder|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContract> $user_contracts
 * @property-read int|null $user_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserCourse> $user_courses
 * @property-read int|null $user_courses_count
 * @property-read \App\Models\UserDetail|null $user_detail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserEquipment> $user_equipments
 * @property-read int|null $user_equipments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserMedicalVisit> $user_medical_visits
 * @property-read int|null $user_medical_visits_count
 * @property-read \App\Models\UserPersonalData|null $user_personal_data
 * @property-read \App\Models\UserSite|null $user_site
 * @method static \Illuminate\Database\Eloquent\Builder|User cashier()
 * @method static \Illuminate\Database\Eloquent\Builder|User commercial()
 * @method static \Illuminate\Database\Eloquent\Builder|User external()
 * @method static \Illuminate\Database\Eloquent\Builder|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User internal()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User school()
 * @method static \Illuminate\Database\Eloquent\Builder|User staff()
 * @method static \Illuminate\Database\Eloquent\Builder|User travelAgency()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereCashfund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereCashierType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereHasShifts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereSiaeTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashier withoutTrashed()
 */
	class Cashier extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $cashier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierActive whereUserId($value)
 */
	class CashierActive extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $cashier_id
 * @property string|null $cashier_detail
 * @property string $date
 * @property float $opening_cash_amount_last_closure
 * @property float $opening_cash_amount_registered
 * @property int|null $opening_stock_check_passed
 * @property string|null $opening_stock_check_values
 * @property string $opened_at
 * @property string|null $opening_notes
 * @property float|null $closure_cash_amount_calculated
 * @property float|null $closure_paid_amount_calculated
 * @property float|null $closure_pos_amount_calculated
 * @property float|null $closure_voucher_amount_calculated
 * @property float|null $closure_cash_amount_registered
 * @property float|null $closure_paid_amount_registered
 * @property float|null $closure_pos_amount_registered
 * @property float|null $closure_voucher_amount_registered
 * @property float|null $closure_hand_amount_registered
 * @property string|null $closure_paid_amount_receipt
 * @property string|null $closure_pos_amount_receipt
 * @property string|null $closure_hand_amount_receipt
 * @property int|null $closure_hand_amount_to
 * @property string|null $closed_at
 * @property string|null $closure_notes
 * @property int|null $verified
 * @property string|null $verified_at
 * @property int|null $verified_by
 * @property float|null $closure_cash_amount_accounted
 * @property float|null $closure_paid_amount_accounted
 * @property float|null $closure_pos_amount_accounted
 * @property float|null $closure_voucher_amount_accounted
 * @property float|null $closure_hand_amount_accounted
 * @property float|null $closure_stripe_amount_calculated
 * @property float|null $closure_stripe_amount_accounted
 * @property float|null $closure_bank_amount_calculated
 * @property float|null $closure_bank_amount_accounted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $closure_stock_check_passed
 * @property string|null $closure_stock_check_values
 * @property int|null $cash_deposit_id
 * @property int|null $safe_id
 * @property-read \App\Models\Cashier|null $cashier
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereCashDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereCashierDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureBankAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureBankAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureCashAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureCashAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureCashAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureHandAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureHandAmountReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureHandAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureHandAmountTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePaidAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePaidAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePaidAmountReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePaidAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePosAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePosAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePosAmountReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosurePosAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureStockCheckPassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureStockCheckValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureStripeAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureStripeAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureVoucherAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureVoucherAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereClosureVoucherAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereOpenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereOpeningCashAmountLastClosure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereOpeningCashAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereOpeningNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereOpeningStockCheckPassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereOpeningStockCheckValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierRegisterClosure whereVerifiedBy($value)
 */
	class CashierRegisterClosure extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string|null $address
 * @property string|null $post_code
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $phone
 * @property string|null $vat
 * @property string|null $tax_code
 * @property string|null $iban
 * @property string|null $certified_email
 * @property string|null $unique_code
 * @property string|null $idTransmitter
 * @property string|null $idTransferorLender
 * @property string|null $taxRegime
 * @property string|null $reaOffice
 * @property string|null $reaNum
 * @property string|null $reaStatus
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCertifiedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIdTransferorLender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIdTransmitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereReaNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereReaOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereReaStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTaxRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUniqueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereVat($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Concession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Concession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Concession query()
 * @method static \Illuminate\Database\Eloquent\Builder|Concession whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concession whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concession whereUpdatedAt($value)
 */
	class Concession extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Country> $countries
 * @property-read int|null $countries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Continent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Continent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Continent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Continent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Continent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Continent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Continent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Continent whereUpdatedAt($value)
 */
	class Continent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification active()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractQualification whereUpdatedAt($value)
 */
	class ContractQualification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $slug
 * @property string $name
 * @property int $active
 * @property int $contract_hours
 * @property int $monthly_hours
 * @property int $weekly_hours_ls
 * @property int $weekly_hours_hs
 * @property int $daily_hours
 * @property float $holiday_per_month
 * @property float $whr_per_month
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType active()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereContractHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereDailyHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereHolidayPerMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereMonthlyHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereWeeklyHoursHs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereWeeklyHoursLs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereWhrPerMonth($value)
 */
	class ContractType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int|null $continent_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Continent|null $continent
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country ordered($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereContinentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_id
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $qr_code
 * @property int|null $scans
 * @property-read \App\Models\ProductCumulative|null $cumulative_product
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan query()
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereScans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CumulativeScan whereUpdatedAt($value)
 */
	class CumulativeScan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $label
 * @property string|null $label_en
 * @property int|null $active
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereLabelEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereUpdatedAt($value)
 */
	class DocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $icon
 * @property \ArrayObject|null $roles
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationGroup whereUpdatedAt($value)
 */
	class NavigationGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $navigation_group_id
 * @property string $slug
 * @property string $navigation_sort
 * @property \ArrayObject|null $roles
 * @property int $groupException
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\NavigationGroup|null $navigation_group
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereGroupException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereNavigationGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereNavigationSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereUpdatedAt($value)
 */
	class NavigationItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency active()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationFrequency whereUpdatedAt($value)
 */
	class NotificationFrequency extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $order_number
 * @property string $prefix
 * @property int $progressive
 * @property int $year
 * @property float $price
 * @property float $fee
 * @property float|null $duty_stamp
 * @property int $user_id
 * @property int $order_type_id
 * @property int $order_status_id
 * @property int|null $payment_id
 * @property int|null $cashier_id
 * @property int|null $company_id
 * @property string|null $email_to
 * @property int|null $email_sent
 * @property int $can_modify
 * @property int $print_at_home
 * @property string|null $printed_at
 * @property string|null $completed_at
 * @property string|null $deleted_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $printed_counter
 * @property-read \App\Models\Cashier|null $cashier
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\PaymentType|null $payment_type
 * @property-read \App\Models\Slot|null $slot
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCanModify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDutyStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmailTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrintAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrintedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrintedCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereYear($value)
 * @mixin \Eloquent
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $color
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemStatus whereUpdatedAt($value)
 */
	class OrderItemStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereUpdatedAt($value)
 */
	class OrderStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $prefix
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderType whereUpdatedAt($value)
 */
	class OrderType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $payment_type_id
 * @property string $code
 * @property float $total
 * @property float $fee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $gateway
 * @property-read \App\Models\PaymentType $payment_type
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $payment_type_id
 * @property string $slug
 * @property string $name
 * @property float $fee_percentage
 * @property float $fee_value
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PaymentType $payment_type
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereFeePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereFeeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSubtype whereUpdatedAt($value)
 */
	class PaymentSubtype extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereUpdatedAt($value)
 */
	class PaymentType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pole query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pole whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pole whereUpdatedAt($value)
 */
	class Pole extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property int $has_supplier
 * @property int|null $supplier_id
 * @property int|null $product_subcategory_id
 * @property int $active
 * @property string $code
 * @property string|null $article
 * @property string $name
 * @property string $slug
 * @property float $price_sale
 * @property float $price_purchase
 * @property float $price_web
 * @property float $vat
 * @property int $price_per_pax
 * @property int $num_pax
 * @property int $check_document
 * @property int $printable
 * @property int $deliverable
 * @property int $billable
 * @property int $is_date
 * @property int $is_hour
 * @property int $is_name
 * @property int $is_card
 * @property int $is_link
 * @property int|null $is_cumulative
 * @property string|null $product_link
 * @property \App\Enums\MatrixGenerationType|null $matrix_generation_type
 * @property \App\Enums\ValidityPeriod|null $validity_from_issue_unit
 * @property int|null $validity_from_issue_value
 * @property \App\Enums\ValidityPeriod|null $validity_from_burn_unit
 * @property int|null $validity_from_burn_value
 * @property int $max_scans
 * @property int $has_additional_code
 * @property string|null $qr_code
 * @property int $online_reservation_delay
 * @property string|null $notes
 * @property \ArrayObject|null $sale_matrix
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $exclude_slotcount
 * @property string|null $revenue_account
 * @property int $is_siae
 * @property string|null $cod_ordine_posto
 * @property string|null $cod_riduzione_siae
 * @property string|null $date_event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductCumulative> $product_cumulatives
 * @property-read int|null $product_cumulatives_count
 * @property-read \App\Models\ProductSubcategory|null $product_subcategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductValidity> $product_validities
 * @property-read int|null $product_validities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReductionField> $reduction_fields
 * @property-read int|null $reduction_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reduction> $reductions
 * @property-read int|null $reductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $related_products
 * @property-read int|null $related_products_count
 * @property-read \App\Models\Service|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Site> $sites
 * @property-read int|null $sites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slot> $slots
 * @property-read int|null $slots_count
 * @property-read \App\Models\User|null $supplier
 * @property-read \App\Models\VirtualStoreSetting|null $virtual_store_settings
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCheckDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodOrdinePosto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodRiduzioneSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDateEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeliverable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExcludeSlotcount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasAdditionalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsCumulative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMatrixGenerationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMaxScans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNumPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnlineReservationDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePricePerPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePricePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceWeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrintable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRevenueAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSaleMatrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereValidityFromBurnUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereValidityFromBurnValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereValidityFromIssueUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereValidityFromIssueValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVat($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property int $crm
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCrm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereUpdatedAt($value)
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $product_id
 * @property int $site_id
 * @property int $id
 * @property int $max_scans
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative whereMaxScans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCumulative whereUpdatedAt($value)
 */
	class ProductCumulative extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $product_id
 * @property int $reduction_id
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReduction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReduction whereReductionId($value)
 */
	class ProductReduction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $product_id
 * @property int $reduction_field_id
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReductionField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReductionField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReductionField query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReductionField whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReductionField whereReductionFieldId($value)
 */
	class ProductReductionField extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleMatrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleMatrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleMatrix query()
 */
	class ProductSaleMatrix extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_category_id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\ProductCategory|null $product_category
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSubcategory whereUpdatedAt($value)
 */
	class ProductSubcategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property string $start_validity
 * @property string $end_validity
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity whereEndValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity whereStartValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductValidity whereUpdatedAt($value)
 */
	class ProductValidity extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $short_name
 * @property int $active
 * @property string $reduction_type
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereReductionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reduction whereUpdatedAt($value)
 */
	class Reduction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReductionField whereUpdatedAt($value)
 */
	class ReductionField extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $main_product_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct whereMainProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelatedProduct whereUpdatedAt($value)
 */
	class RelatedProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $site_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SafeOperation> $safe_operations
 * @property-read int|null $safe_operations_count
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|Safe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Safe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Safe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereUpdatedAt($value)
 */
	class Safe extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property float $amount
 * @property int $safe_id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $company
 * @property string $operation_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereOperationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SafeOperation whereUserId($value)
 */
	class SafeOperation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree query()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolDegree whereUpdatedAt($value)
 */
	class SchoolDegree extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_category_id
 * @property int|null $school_degree_id
 * @property int|null $site_id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property int $active
 * @property int $is_purchasable
 * @property int $is_date
 * @property int $is_hour
 * @property int $is_language
 * @property int $is_pickup
 * @property int $is_min_pax
 * @property int|null $min_pax
 * @property int $is_max_pax
 * @property int|null $max_pax
 * @property int $is_duration
 * @property int $is_pending
 * @property int|null $online_reservation_delay
 * @property int|null $closing_reservation
 * @property int $is_archived
 * @property string|null $archived_at
 * @property int|null $archived_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $description
 * @property int $is_siae
 * @property int|null $negozio_id
 * @property-read \App\Models\ProductCategory|null $product_category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\SchoolDegree|null $school_degree
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServiceNotification> $service_notifications
 * @property-read int|null $service_notifications_count
 * @property-read \App\Models\Site|null $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slot> $slots
 * @property-read int|null $slots_count
 * @property-read \App\Models\User|null $user_archived
 * @method static \Illuminate\Database\Eloquent\Builder|Service isPurchasable()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service notArchived()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service tickets()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereArchivedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereClosingReservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsMaxPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsMinPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsPending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsPickup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsPurchasable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereMaxPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereMinPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereNegozioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereOnlineReservationDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSchoolDegreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property \ArrayObject|null $notification_frequency
 * @property string|null $recipients
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Service|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification whereNotificationFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification whereRecipients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNotification whereUpdatedAt($value)
 */
	class ServiceNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @OA\Schema (
 *     schema="Order",
 *     type="object",
 * )
 * @property int $id
 * @property string $order_number
 * @property string $prefix
 * @property int $progressive
 * @property int $year
 * @property float $price
 * @property float $fee
 * @property float|null $duty_stamp
 * @property int $user_id
 * @property int $order_type_id
 * @property int $order_status_id
 * @property int|null $payment_id
 * @property int|null $cashier_id
 * @property int|null $company_id
 * @property int $can_modify
 * @property int $print_at_home
 * @property int $email_sent
 * @property string|null $email_to
 * @property int $printed_counter
 * @property string|null $printed_at
 * @property string|null $completed_at
 * @property string|null $deleted_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cashier|null $cashier
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiaeOrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\PaymentType|null $payment_type
 * @property-read \App\Models\Slot|null $slot
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereCanModify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereDutyStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereEmailTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereOrderTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder wherePrintAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder wherePrintedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder wherePrintedCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrder whereYear($value)
 */
	class SiaeOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $siae_order_id
 * @property int $product_id
 * @property int|null $promo_id
 * @property int $order_item_status_id
 * @property int|null $order_item_delete_flag
 * @property int $qty
 * @property float $price
 * @property string $validity
 * @property int $is_cumulative
 * @property string $printable_qr_code
 * @property string|null $printable_qr_link
 * @property string|null $date_service
 * @property string|null $hour_service
 * @property string|null $language_service
 * @property int|null $num_pax_service
 * @property string|null $pickup_service
 * @property int|null $duration_service
 * @property int|null $reduction_id
 * @property string|null $reduction_notes
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property float|null $discount
 * @property int|null $payment_id
 * @property float|null $credit_card_fees
 * @property int|null $scans_counter
 * @property int|null $delivered
 * @property string|null $delivered_at
 * @property float|null $transfer_amount
 * @property string|null $transferred_at
 * @property string|null $transferred_to
 * @property string|null $transfer_id
 * @property string|null $transfer_error
 * @property int|null $payment_transfer_id
 * @property int|null $product_place_order_id
 * @property int|null $supplier_id
 * @property int|null $to_be_delete
 * @property string|null $deleted_at
 * @property string|null $supplier_percentage
 * @property string|null $additional_code
 * @property-read \App\Models\SiaeOrder|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiaeOrderItemReduction> $order_item_reductions
 * @property-read int|null $order_item_reductions_count
 * @property-read \App\Models\OrderItemStatus|null $order_item_status
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\PaymentType|null $payment_type
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\SiaeProductHolder|null $product_holder
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiaeProductHolder> $product_holders
 * @property-read int|null $product_holders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiaeScan> $scanned_tickets
 * @property-read int|null $scanned_tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiaeScan> $scans
 * @property-read int|null $scans_count
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereAdditionalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereCreditCardFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereDateService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereDurationService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereHourService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereIsCumulative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereLanguageService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereNumPaxService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereOrderItemDeleteFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereOrderItemStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePaymentTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePickupService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePrintableQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePrintableQrLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereProductPlaceOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem wherePromoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereReductionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereReductionNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereScansCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereSiaeOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereSupplierPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereToBeDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereTransferAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereTransferError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereTransferredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereTransferredTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItem whereValidity($value)
 */
	class SiaeOrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $siae_order_item_id
 * @property int $reduction_id
 * @property int $reduction_field_id
 * @property string|null $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereReductionFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereReductionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereSiaeOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderItemReduction whereValue($value)
 */
	class SiaeOrderItemReduction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $siae_order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint whereSiaeOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeOrderReprint whereUserId($value)
 */
	class SiaeOrderReprint extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $siae_order_item_id
 * @property int $product_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $expired_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereSiaeOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeProductHolder whereUpdatedAt($value)
 */
	class SiaeProductHolder extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $virtual_store_matrix_id
 * @property int|null $operator_id
 * @property int|null $siae_order_item_id
 * @property int $is_scanned
 * @property int $verification_needed
 * @property string $qr_code
 * @property string $date_scanned
 * @property string|null $date_expiration
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $scan_area
 * @property-read \App\Models\SiaeOrderItem|null $order_item
 * @property-read \App\Models\VirtualStoreMatrix|null $virtual_store_matrix
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereDateExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereDateScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereIsScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereScanArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereSiaeOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereVerificationNeeded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScan whereVirtualStoreMatrixId($value)
 */
	class SiaeScan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $qr_code
 * @property string|null $type
 * @property int|null $site_id
 * @property string|null $status
 * @property string|null $response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiaeScanLog whereUpdatedAt($value)
 */
	class SiaeScanLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pole_id
 * @property int $company_id
 * @property int|null $concession_id
 * @property int|null $unlock_matrix_pole_id
 * @property string $slug
 * @property string $name
 * @property string $canonical_name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $region
 * @property string $lat
 * @property string $lng
 * @property int $is_comingsoon
 * @property int $is_closed
 * @property int $in_concession
 * @property string|null $matrix_suffix
 * @property int $access_control_enabled
 * @property int $poll_enabled
 * @property int $cashier_fee_enabled
 * @property int $tvm
 * @property int $onsite_auto_scan
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $cod_location_siae
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cashier> $cashiers
 * @property-read int|null $cashiers_count
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Concession|null $concession
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiteHour> $hours
 * @property-read int|null $hours_count
 * @property-read \App\Models\Pole|null $pole
 * @property-read \App\Models\Pole|null $unlock_pole
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site open()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAccessControlEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCanonicalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCashierFeeEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCodLocationSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereConcessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereInConcession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereIsComingsoon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereMatrixSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereOnsiteAutoScan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePollEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereTvm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUnlockMatrixPoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 */
	class Site extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $site_id
 * @property \ArrayObject $day
 * @property string $opening
 * @property string|null $break_start
 * @property string|null $break_end
 * @property string $closing
 * @property string $closing_ticket_office
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $start_validity
 * @property string|null $end_validity
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereBreakEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereBreakStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereClosing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereClosingTicketOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereEndValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereOpening($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereStartValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteHour whereUpdatedAt($value)
 */
	class SiteHour extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $service_id
 * @property int|null $product_id
 * @property \ArrayObject|null $slot_days
 * @property string|null $slot_type
 * @property \ArrayObject|null $hours
 * @property int|null $duration
 * @property int|null $availability
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $advance_tolerance
 * @property int $delay_tolerance
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Service|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereAdvanceTolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereDelayTolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereSlotDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereSlotType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereUpdatedAt($value)
 */
	class Slot extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotDay whereUpdatedAt($value)
 */
	class SlotDay extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContract> $user_contracts
 * @property-read int|null $user_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserCourse> $user_courses
 * @property-read int|null $user_courses_count
 * @property-read \App\Models\UserDetail|null $user_detail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserEquipment> $user_equipments
 * @property-read int|null $user_equipments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserMedicalVisit> $user_medical_visits
 * @property-read int|null $user_medical_visits_count
 * @property-read \App\Models\UserPersonalData|null $user_personal_data
 * @property-read \App\Models\UserSite|null $user_site
 * @method static \Illuminate\Database\Eloquent\Builder|User cashier()
 * @method static \Illuminate\Database\Eloquent\Builder|User commercial()
 * @method static \Illuminate\Database\Eloquent\Builder|User external()
 * @method static \Illuminate\Database\Eloquent\Builder|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User internal()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User school()
 * @method static \Illuminate\Database\Eloquent\Builder|User staff()
 * @method static \Illuminate\Database\Eloquent\Builder|User travelAgency()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff withoutTrashed()
 */
	class Staff extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereUpdatedAt($value)
 */
	class TicketType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property Carbon|null $password_expired_at
 * @property Carbon|null $first_login_at
 * @property int $active
 * @property int $anonymized
 * @property Carbon|null $anonymized_at
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $last_login_at
 * @property int|null $siae_operator_id
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContract> $user_contracts
 * @property-read int|null $user_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UserCourse> $user_courses
 * @property-read int|null $user_courses_count
 * @property-read \App\Models\UserDetail|null $user_detail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserEquipment> $user_equipments
 * @property-read int|null $user_equipments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UserMedicalVisit> $user_medical_visits
 * @property-read int|null $user_medical_visits_count
 * @property-read UserPersonalData|null $user_personal_data
 * @property-read \App\Models\UserSite|null $user_site
 * @method static \Illuminate\Database\Eloquent\Builder|User cashier()
 * @method static \Illuminate\Database\Eloquent\Builder|User external()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User internal()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User school()
 * @method static \Illuminate\Database\Eloquent\Builder|User staff()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonymized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonymizedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSiaeOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User commercial()
 * @method static \Illuminate\Database\Eloquent\Builder|User travelAgency()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasName, \Tymon\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $contract_type_id
 * @property string|null $contract_start_date
 * @property string|null $contract_end_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\ContractType|null $contract_type
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereContractStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContract whereUserId($value)
 */
	class UserContract extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $course_date
 * @property string|null $course_description
 * @property int|null $course_duration
 * @property int|null $course_validity
 * @property string|null $course_expiry
 * @property string|null $course_effectiveness_description
 * @property string|null $course_effectiveness_evaulation
 * @property string|null $course_effectiveness_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseEffectivenessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseEffectivenessDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseEffectivenessEvaulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCourseValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCourse whereUserId($value)
 */
	class UserCourse extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $business_name
 * @property string|null $address
 * @property string|null $post_code
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $phone
 * @property string|null $vat
 * @property string|null $tax_code
 * @property string|null $iban
 * @property string|null $certified_email
 * @property string|null $unique_code
 * @property string|null $cig
 * @property int $is_subcontractor
 * @property int|null $contractor_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int|null $commercial_referent_id
 * @property string|null $invoice_type
 * @property string|null $purchase_type
 * @property-read \App\Models\User|null $contractor
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCertifiedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCommercialReferentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereInvoiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereIsSubcontractor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail wherePurchaseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUniqueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereVat($value)
 */
	class UserDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $assignment_equipment_date
 * @property string|null $restitution_equipment_date
 * @property string|null $equipment_size
 * @property string|null $equipment_registration_number
 * @property string|null $equipment_description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereAssignmentEquipmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereEquipmentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereEquipmentRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereEquipmentSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereRestitutionEquipmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEquipment whereUserId($value)
 */
	class UserEquipment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $visit_date
 * @property string|null $visit_expiry
 * @property string|null $visit_description
 * @property int|null $visit_duration
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereVisitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereVisitDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereVisitDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMedicalVisit whereVisitExpiry($value)
 */
	class UserMedicalVisit extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $contract_qualification_id
 * @property string|null $date_of_birth
 * @property int|null $mobile_number
 * @property string|null $tax_code
 * @property string|null $city
 * @property string|null $address
 * @property int|null $post_code
 * @property string|null $city_alt
 * @property string|null $address_alt
 * @property int|null $post_code_alt
 * @property string|null $size
 * @property string|null $classification_level
 * @property string|null $engagement_date
 * @property string|null $termination_date
 * @property string|null $subsidiary_id
 * @property string|null $geobadge_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\ContractQualification|null $contract_qualification
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereAddressAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereCityAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereClassificationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereContractQualificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereEngagementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereGeobadgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData wherePostCodeAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereSubsidiaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereTerminationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalData whereUserId($value)
 */
	class UserPersonalData extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSite whereUserId($value)
 */
	class UserSite extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property int $user_id
 * @property int $company_id
 * @property int $status_id
 * @property int $qty
 * @property int|null $virtual_store_order_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read mixed $first_matrix
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VirtualStoreMatrix> $matrices
 * @property-read int|null $matrices_count
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\VirtualStoreStatus|null $status
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\VirtualStoreOrder|null $virtual_store_order
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot query()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreLot whereVirtualStoreOrderId($value)
 */
	class VirtualStoreLot extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $lot_id
 * @property string $code
 * @property int $year
 * @property string $progressive
 * @property string $status
 * @property int $product_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int|null $purchase_group
 * @property string|null $purchased_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix query()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix wherePurchaseGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix wherePurchasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreMatrix whereYear($value)
 */
	class VirtualStoreMatrix extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property int $qty
 * @property int $user_id
 * @property string $status
 * @property string $description
 * @property int $email
 * @property string|null $order_file
 * @property int $can_delete
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereOrderFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreOrder whereUserId($value)
 */
	class VirtualStoreOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $value
 * @property string $key
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreSetting whereValue($value)
 */
	class VirtualStoreSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualStoreStatus whereUpdatedAt($value)
 */
	class VirtualStoreStatus extends \Eloquent {}
}

