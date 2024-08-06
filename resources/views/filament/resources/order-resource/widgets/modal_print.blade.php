
<x-filament-widgets::widget style="display: none">
</x-filament-widgets::widget>

@if($this->order_id > 0)
@script
<script>
    let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
    width=900,height=600,left=100,top=100`;

    open('/onsite/tickets/print/{{$this->order_id}}', 'Stampa biglietti', params);
</script>
@endscript
@endif

