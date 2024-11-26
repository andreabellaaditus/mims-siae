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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange whereAccessControlDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlChange whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereEntranceEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereExitEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereLastMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereLoggingEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDevice whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereAccessControlDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereQrCodeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlDeviceDebug whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereEnabledSites($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlPass whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccessControlQrcodeLog whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereDateService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereHolderFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereHolderLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereHourService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereIsCumulative($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereOpenTicket($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier cashier()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier commercial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier external()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier internal()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier school()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier staff()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier travelAgency()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCashfund($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCashierType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereHasShifts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereSiaeTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierActive whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereCashDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereCashierDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureBankAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureBankAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureCashAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureCashAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureCashAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureHandAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureHandAmountReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureHandAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureHandAmountTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePaidAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePaidAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePaidAmountReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePaidAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePosAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePosAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePosAmountReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosurePosAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureStockCheckPassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureStockCheckValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureStripeAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureStripeAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureVoucherAmountAccounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureVoucherAmountCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereClosureVoucherAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereOpenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereOpeningCashAmountLastClosure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereOpeningCashAmountRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereOpeningNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereOpeningStockCheckPassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereOpeningStockCheckValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierRegisterClosure whereVerifiedBy($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCertifiedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIdTransferorLender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIdTransmitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereReaNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereReaOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereReaStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUniqueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereVat($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Concession whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractQualification whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereContractHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereDailyHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereHolidayPerMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereMonthlyHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereWeeklyHoursHs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereWeeklyHoursLs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereWhrPerMonth($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country ordered($name)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereContinentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereScans($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CumulativeScan whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereLabelEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationGroup whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereGroupException($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereNavigationGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereNavigationSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NavigationItem whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationFrequency whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemStatus whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderType whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereFeePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereFeeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSubtype whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pole whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCheckDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCodOrdinePosto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCodRiduzioneSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDateEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeliverable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereExcludeSlotcount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHasAdditionalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHasSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsCumulative($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMatrixGenerationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMaxScans($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNumPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOnlineReservationDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePricePerPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePricePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceWeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrintable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereRevenueAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSaleMatrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereValidityFromBurnUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereValidityFromBurnValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereValidityFromIssueUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereValidityFromIssueValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVat($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereCrm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative whereMaxScans($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCumulative whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReduction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReduction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReduction whereReductionId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReductionField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReductionField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReductionField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReductionField whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReductionField whereReductionFieldId($value)
 */
	class ProductReductionField extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSaleMatrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSaleMatrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSaleMatrix query()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSubcategory whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity whereEndValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity whereStartValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductValidity whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereReductionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reduction whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReductionField whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct whereMainProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RelatedProduct whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Safe whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereOperationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SafeOperation whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolDegree whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service isPurchasable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service notArchived()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service tickets()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereArchivedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereClosingReservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsMaxPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsMinPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsPending($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsPickup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsPurchasable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereMaxPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereMinPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereNegozioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereOnlineReservationDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereSchoolDegreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification whereNotificationFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification whereRecipients($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceNotification whereUpdatedAt($value)
 */
	class ServiceNotification extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereCanModify($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereDutyStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereEmailTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereOrderTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder wherePrintAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder wherePrintedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder wherePrintedCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrder whereYear($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereAdditionalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereCreditCardFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereDateService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereDurationService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereHourService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereIsCumulative($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereLanguageService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereNumPaxService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereOrderItemDeleteFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereOrderItemStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePaymentTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePickupService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePrintableQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePrintableQrLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereProductPlaceOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem wherePromoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereReductionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereReductionNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereScansCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereSiaeOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereSupplierPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereToBeDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereTransferAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereTransferError($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereTransferredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereTransferredTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItem whereValidity($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereReductionFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereReductionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereSiaeOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderItemReduction whereValue($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint whereSiaeOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeOrderReprint whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereSiaeOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeProductHolder whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereDateExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereDateScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereIsScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereScanArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereSiaeOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereVerificationNeeded($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScan whereVirtualStoreMatrixId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiaeScanLog whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site open()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereAccessControlEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCanonicalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCashierFeeEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCodLocationSiae($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereConcessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereInConcession($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereIsComingsoon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereMatrixSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereOnsiteAutoScan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site wherePoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site wherePollEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereTvm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUnlockMatrixPoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereBreakEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereBreakStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereClosing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereClosingTicketOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereEndValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereOpening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereStartValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteHour whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereAdvanceTolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereDelayTolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereSlotDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereSlotType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlotDay whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff cashier()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff commercial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff external()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff internal()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff school()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff staff()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff travelAgency()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketType whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User commercial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User travelAgency()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereContractStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseEffectivenessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseEffectivenessDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseEffectivenessEvaulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCertifiedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCommercialReferentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereInvoiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereIsSubcontractor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail wherePurchaseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUniqueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereVat($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereAssignmentEquipmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereEquipmentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereEquipmentRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereEquipmentSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereRestitutionEquipmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserEquipment whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereVisitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereVisitDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereVisitDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMedicalVisit whereVisitExpiry($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereAddressAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereCityAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereClassificationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereContractQualificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereEngagementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereGeobadgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData wherePostCodeAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereSubsidiaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereTerminationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPersonalData whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSite whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreLot whereVirtualStoreOrderId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix wherePurchaseGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix wherePurchasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreMatrix whereYear($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereOrderFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreOrder whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreSetting whereValue($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VirtualStoreStatus whereUpdatedAt($value)
 */
	class VirtualStoreStatus extends \Eloquent {}
}

