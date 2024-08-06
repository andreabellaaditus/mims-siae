<div class="fi-section">

    <div class="grid grid-cols-2 text-sm">

        <div class="col-span-1  p-1">
            <b>{{ __('global.cashier') }}:</b>
            {{$record->order->user->last_name}}
        </div>

        <div class="col-span-1  p-1">
            <b>{{ __('global.date-creation') }}:</b>
            {{date("d/m/Y H:i:s", strtotime($record->created_at))}}
        </div>
        <div class="col-span-1 p-1">
            <b>{{ __('orders.location') }}:</b>
            {{$record->order->cashier->name}}
        </div>

        <div class="col-span-1 p-1">
            <b>{{ __('orders.form.payment-type') }}:</b>&nbsp;
            <select wire:change="changePaymentType({{$record->payment_id}}, $event.target.value)" class="pl-3 pr-10 py-1 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                @foreach($payment_types as $payment_type)
                    <option value="{{ $payment_type->id }}" @if($payment_type->id == $record->payment->payment_type_id) selected @endif>{{ $payment_type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="overflow-x-auto mt-10">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('global.qty') }}</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('global.product') }}</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('orders.unit-price') }}</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('orders.scans') }}</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('global.total') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-2 whitespace-nowrap">{{($record->qty) ? $record->qty: '0'}}</td>
                    <td class="px-6 py-2 whitespace-nowrap">{{($record->product->name) ? $record->product->name: ''}}</td>
                    <td class="px-6 py-2 whitespace-nowrap">{{number_format($record->price, 2, ',')}} €</td>
                    <td class="px-6 py-2 whitespace-nowrap">{{$record->scanned_tickets->count()}} / {{($record->qty) ? $record->qty: '0'}}</td>
                    <td class="px-6 py-2 whitespace-nowrap">{{number_format($record->price * $record->qty, 2, ",")}} €</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
