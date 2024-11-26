<x-filament-widgets::widget>
    @if(count($this->products) > 0)
        <div class="grid grid-cols-2 text-sm">
            <div class="col-span-1 p-3">
                <x-filament::section>
                    <div x-data="{ hideDateService: {} }">
                        <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 dark:divide-white/5 text-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>{{ __('global.name') }}</th>
                                    <th>{{ __('orders.date-service') }}</th>
                                    <th>{{ __('orders.hour-service') }}</th>
                                    <th>{{ __('orders.open-ticket') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->products as $key => $product)
                                    <tr class="text-sm text-center">
                                        <td class="py-2">{{$product['name']}}</td>
                                        <td class="py-2">
                                            <input class="text-sm py-1.5 rounded-lg shadow-input"
                                                min='{{$product['dateStart']}}'
                                                style="width:90%; @if($product['open_ticket']) visibility:hidden; @endif "
                                                x-show="!hideDateService[{{ $key }}]"
                                                wire:change="updateDateService({{$key}}, $event.target.value)"
                                                type="date" value="{{$product['date_service']}}" />
                                        </td>
                                        <td class="py-2">
                                            <select wire:change="updateHourService({{$key}}, $event.target.value)"
                                                    style="width:85%; @if($product['open_ticket']) visibility:hidden; @endif "
                                                    class="text-sm py-1.5 rounded-lg shadow-input"
                                                    x-show="!hideDateService[{{ $key }}]">
                                                @if(count($product['hours']) > 0)
                                                    <option value="0">{{ __('orders.select-slot') }}</option>
                                                    @foreach($product['hours'] as $slot)
                                                        <option @if($slot['time'] == $product['hour_service']) selected="selected" @endif
                                                            @if(($product['qty'] > $slot['free_spots']) && $product['exclude_slotcount'] == 0) disabled="disabled" @endif
                                                            value="{{$slot['time']}}">@if($product['exclude_slotcount'] == 1) {{$slot['time']}} @else {{$slot['desc']}} @endif
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="0">{{ __('orders.no-slot') }}</option>
                                                @endif
                                            </select>
                                        </td>
                                        <td class="py-2">
                                            <select class="text-sm py-1.5 rounded-lg shadow-input"
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
            @if (count($this->products) > 0)
                @php
                $newProducts = [];

                foreach ($this->products as $product) {
                    if (!empty($product['fields'])) {
                        $newProducts[] = $product;
                    }
                }
                @endphp
            @endif
            @if (count($newProducts) > 0)
                <div class="col-span-1 p-2">
                    <x-filament::section>

                        @php
                            $key_rand_prod = array_rand($this->products);
                            $rand_prod = $this->products[$key_rand_prod];
                            $index = 0;
                        @endphp
                        <div x-data="{ activeTab: {{ $index }} }">
                            <div class="flex flex-wrap border-b border-gray-300">
                                @foreach ($this->products as $productIndex => $product)
                                    @if (!empty($product['fields']))
                                        @for ($i = 0; $i < $product['qty']; $i++)
                                            <div class="w-full sm:w-auto">
                                                <li @click="activeTab = {{ $index }}"
                                                    style="list-style-type: none;"
                                                    :class="{ 'border-b-4 border-indigo-500': activeTab === {{ $index }}, 'border-transparent': activeTab !== {{ $index }}, 'bg-white': activeTab === {{ $index }}, 'text-indigo-700': activeTab === {{ $index }}, 'border-l': true, 'border-t': true, 'border-r': true, 'rounded-t': true, 'py-2': true, 'px-4': true, 'font-semibold': true, 'cursor-pointer': true, 'hover:bg-gray-100': true }">
                                                    <a href="#" class="inline-block">{{ $product['name'] }} {{ $i + 1 }}</a>
                                                </li>
                                            </div>
                                            @php $index++ @endphp
                                        @endfor
                                    @endif
                                    @php $index++ @endphp
                                @endforeach
                            </div>

                            <div class="py-4">
                                <form id="form_red_fields">
                                    @php $index = 0; @endphp
                                    @foreach ($this->products as $productIndex => $product)
                                        @if (!empty($product['fields']))
                                            @for ($i = 0; $i < $product['qty']; $i++)
                                                <div x-show="activeTab === {{ $index }}">
                                                    <div style="display:ruby;">
                                                    @foreach ($product['fields'] as $key => $field)

                                                        <div class="mb-3">
                                                            <label class="block text-sm font-medium text-gray-700">{{ $field['name'] }}</label>
                                                            @if($field['reduction_field_id'] != 3)
                                                                <input  type="text" required required="true" id="formData.{{ $index }}.fields.{{ $key }}.product.{{ $productIndex }}.reduction.{{ $field['reduction_id'] }}" wire:model="formData.{{ $index }}.fields.{{ $key }}"
                                                                    class="required mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                            @else
                                                                <select
                                                                class="required mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                required="true" id="formData.{{ $index }}.fields.{{ $key }}.product.{{ $productIndex }}.reduction.{{ $field['reduction_id'] }}" wire:model="formData.{{ $index }}.fields.{{ $key }}"
                                                                >
                                                                @foreach ($this->document_types as $type)
                                                                    <option value="{{$type->id}}">{{$type->label}}</option>
                                                                @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                </div>
                                                @php $index++ @endphp
                                            @endfor
                                        @endif
                                        @php $index++ @endphp
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </x-filament::section>
                </div>
            @endif
        </div>
    @endif
</x-filament-widgets::widget>

@script
<script>

document.addEventListener('input', function(event) {
    var target = event.target;
    var inputTimer;
    var values = {};
    var flag_refresh = 1;

    if (target.tagName === 'INPUT') {
        clearTimeout(inputTimer);
        var form = document.getElementById("form_red_fields");
        var inputs = form.elements;

        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            if (input.type !== "button") {
                values[input.id] = input.value;
            }
            if(input.value === ''){
                flag_refresh = 0;
            }
        }
        if(flag_refresh === 1){
            inputTimer = setTimeout(function() {
                @this.dispatchSelf('inputValueChanged', { values: values });
            }, 2500);
        }
    }
});
/*
let qrcode = '';

document.addEventListener("keydown", function(e) {
    if (e.ctrlKey && e.key === 'v') {
        @this.dispatchSelf('scan', {qr_code: '0abbf5d0b5714bd5'});
        /*navigator.clipboard.readText()
            .then(text => {
                console.log(text);
                qrcode = text;
                if (qrcode.length === 16) {
                    // Aggiorna il codice per il tuo contesto, ad esempio:
                    // @this.dispatchSelf('scan', {qr_code: qrcode});
                    console.log("QR code:", qrcode);
                    qrcode = '';
                }
            })
            .catch(err => {
                console.error('Failed to read clipboard contents: ', err);
            });

    }
}); */



let qrcode = '';
document.addEventListener("keydown", function(e) {

    const textInput = e.key ;
    console.log(textInput);
    console.log(qrcode);
    if (textInput && textInput.length === 1){
        qrcode = qrcode + textInput;
    }else if(textInput === 'Enter' || qrcode.length === 16){
        @this.dispatchSelf('scan', {qr_code: qrcode});
        qrcode = '';
    }else{
        qrcode = '';
    }
});


</script>

@endscript
