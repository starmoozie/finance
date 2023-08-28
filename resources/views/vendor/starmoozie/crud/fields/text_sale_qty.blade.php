<!-- text input -->

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div> @endif
        <input
            data-init-function="bpFieldInitText"
            type="text"
            name="{{ $field['name'] }}"
            value="{{ old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '' }}"
            @include('crud::fields.inc.attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div> @endif
    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

@push('crud_fields_scripts')
    @loadOnce('bpFieldInitText')
    @loadOnce('packages/masking/jquery.mask.js')
        <script>
            function bpFieldInitText(element) {
                const indexNumber  = element.attr('data-row-number') - 1;
                const format       = "#.##0";

                $(`input[name='details[${indexNumber}][qty]']`)
                .on('input', function(e) {
                    let subTotal = e.target.value.replace(/\./g, '');
                    let price    = $(`input[name='details[${indexNumber}][price]']`).val();
                    price = price.replace(/\./g, '');

                    // Set subTotal current field indexNumber
                    $(`input[name='details[${indexNumber}][sub_total]']`).val(formatRupiah(price * subTotal));
                });

                // Set masked input value
                $(`[name='details[${indexNumber}][qty]']`).mask(format, {reverse: true});
            }
        </script>
    @endLoadOnce
@endpush