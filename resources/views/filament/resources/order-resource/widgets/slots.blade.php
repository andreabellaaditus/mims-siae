<x-filament-widgets::widget>

    @if(count($this->products) > 0)
        <div class="grid grid-cols-1 gap-6 p-0 bg-white shadow-lg rounded-lg">
            <div class="col-span-1">
                <x-filament::section>
                    <x-slot name="heading">
                        <h2 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">Slots</h2>
                    </x-slot>
                    <div x-data="{ hideDateService: {} }">
                        <table class="w-full table-auto divide-black text-sm bg-white">
                            <thead>
                                <tr class="text-center">
                                    <th class="py-2 px-4">{{ __('global.name') }}</th>
                                    <th class="py-2 px-4">{{ __('orders.date-service') }}</th>
                                    <th class="py-2 px-4">{{ __('orders.hour-service') }}</th>
                                    <th class="py-2 px-4">{{ __('orders.open-ticket') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->products as $key => $product)
                                    <tr class="text-sm text-center">
                                        <td class="py-4 px-4 font-medium">{{$product['name']}}</td>
                                        <td class="py-4 px-4">
                                            <input class="w-full text-center py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                min='{{$product['dateStart']}}'
                                                style="@if($product['open_ticket']) visibility:hidden; @endif"
                                                x-show="!hideDateService[{{ $key }}]"
                                                wire:init="updateDateService({{$key}}, '{{ $product['date_service'] ?? now()->format('Y-m-d') }}')"
                                                wire:change="updateDateService({{$key}}, $event.target.value)"
                                                type="date"
                                                value="{{ $product['date_service'] ?? now()->format('Y-m-d') }}" />
                                        </td>

                                        <td class="py-4 px-4">
                                            <select wire:change="updateHourService({{$key}}, $event.target.value)"
                                                    class="w-full text-center py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    style="@if($product['open_ticket']) visibility:hidden; @endif"
                                                    x-show="!hideDateService[{{ $key }}]">
                                                @if(count($product['hours']) > 0)
                                                    <option value="0">{{ __('orders.select-slot') }}</option>
                                                    @foreach($product['hours'] as $slot)
                                                        <option @if($slot['time'].":00" == $product['hour_service']) selected="selected" @endif
                                                            @if(($product['qty'] > $slot['free_spots']) && $product['exclude_slotcount'] == 0) disabled="disabled" @endif
                                                            value="{{$slot['time']}}">@if($product['exclude_slotcount'] == 1) {{$slot['time']}} @else {{$slot['desc']}} @endif
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="0">{{ __('orders.no-slot') }}</option>
                                                @endif
                                            </select>
                                        </td>
                                        <td class="py-4 px-4">
                                            <select class="w-full text-center py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    wire:change="hideOrShowDate({{$key}}, $event.target.value);">
                                                @if(!$product['is_date'] && !$product['is_hour'] )
                                                    <option @if($product['open_ticket']) selected="selected" @endif value="1">{{ __('global.yes') }}</option>
                                                @endif
                                                <option @if(!$product['open_ticket']) selected="selected" @endif value="0">{{ __('global.no') }}</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            </div>
        </div>
    @endif
</x-filament-widgets::widget>
