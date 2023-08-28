<!-- select2 from ajax -->
@php
    $old_value = old_empty_or_null($field['name'], false) ??  $field['value'] ?? $field['default'] ?? false;
    $connected_entity = new $field['model'];
    $connected_entity_key_name = $connected_entity->getKeyName();

    // by default set ajax query delay to 500ms
    // this is the time we wait before send the query to the search endpoint, after the user as stopped typing.
    $field['delay'] = $field['delay'] ?? 500;
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
    $field['placeholder'] = $field['placeholder'] ?? trans('starmoozie::crud.select_entry');
    $field['attribute'] = $field['attribute'] ?? $connected_entity->identifiableAttribute();
    $field['minimum_input_length'] = $field['minimum_input_length'] ?? 2;
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <select
        name="{{ $field['name'] }}"
        style="width: 100%"
        data-init-function="bpFieldInitSelect2FromAjaxElement"
        data-field-is-inline="{{var_export($inlineCreate ?? false)}}"
        data-column-nullable="{{ var_export($field['allows_null']) }}"
        data-dependencies="{{ isset($field['dependencies'])?json_encode(Arr::wrap($field['dependencies'])): json_encode([]) }}"
        data-placeholder="{{ $field['placeholder'] }}"
        data-minimum-input-length="{{ $field['minimum_input_length'] }}"
        data-data-source="{{ $field['data_source'] }}"
        data-method="{{ $field['method'] ?? 'GET' }}"
        data-field-attribute="{{ $field['attribute'] }}"
        data-connected-entity-key-name="{{ $connected_entity_key_name }}"
        data-include-all-form-fields="{{ isset($field['include_all_form_fields']) ? ($field['include_all_form_fields'] ? 'true' : 'false') : 'false' }}"
        data-ajax-delay="{{ $field['delay'] }}"
        data-language="{{ str_replace('_', '-', app()->getLocale()) }}"
        @include('crud::fields.inc.attributes', ['default_class' =>  'form-control'])
        >

        @if ($old_value)
            @php
                $old_value = explode('~', $old_value)[0];
                if(!is_object($old_value)) {
                    $item = $connected_entity->find($old_value);
                }else{
                    $item = $old_value;
                }

            @endphp
            @if ($item)
            {{-- allow clear --}}
            @if ($field['allows_null']))
            <option value="" selected>
                {{ $field['placeholder'] }}
            </option>
            @endif

            <option value="{{ $item->getKey() }}" selected>
                {{ $item->{$field['attribute']} }}
            </option>
            @endif
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
@push('crud_fields_styles')
    <!-- include select2 css-->
    @loadOnce('packages/select2/dist/css/select2.min.css')
    @loadOnce('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css')
    {{-- allow clear --}}
    @if($field['allows_null'])
        @loadOnce('select2_from_ajax_custom_css')
        <style type="text/css">
            .select2-selection__clear::after {
                content: ' {{ trans('starmoozie::crud.clear') }}';
            }
        </style>
        @endLoadOnce
    @endif
@endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <!-- include select2 js-->
    @loadOnce('packages/select2/dist/js/select2.full.min.js')
    @if (app()->getLocale() !== 'en')
        @loadOnce('packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js')
    @endif
@endpush

<!-- include field specific select2 js-->
@push('crud_fields_scripts')
@loadOnce('bpFieldInitSelect2FromAjaxElement')
<script>
    function bpFieldInitSelect2FromAjaxElement(element) {
        let form = element.closest('form');
        let $placeholder = element.attr('data-placeholder');
        let $minimumInputLength = element.attr('data-minimum-input-length');
        let $dataSource = element.attr('data-data-source');
        let $method = element.attr('data-method');
        let $fieldAttribute = element.attr('data-field-attribute');
        let $connectedEntityKeyName = element.attr('data-connected-entity-key-name');
        let $includeAllFormFields = element.attr('data-include-all-form-fields')=='false' ? false : true;
        let $allowClear = element.attr('data-column-nullable') == 'true' ? true : false;
        let $dependencies = JSON.parse(element.attr('data-dependencies'));
        let $ajaxDelay = element.attr('data-ajax-delay');
        let $isFieldInline = element.data('field-is-inline');

        // do not initialise select2s that have already been initialised
        if ($(element).hasClass("select2-hidden-accessible"))
        {
            return;
        }
        //init the element
        $(element).select2({
            theme: 'bootstrap',
            multiple: false,
            placeholder: $placeholder,
            minimumInputLength: $minimumInputLength,
            allowClear: $allowClear,
            dropdownParent: $isFieldInline ? $('#inline-create-dialog .modal-content') : document.body,
            ajax: {
                url: $dataSource,
                type: $method,
                dataType: 'json',
                delay: $ajaxDelay,
                data: function (params) {
                    if ($includeAllFormFields) {
                        let formSerializeArray = mapDependencies(element, $dependencies, form);

                        return {
                            q: params.term, // search term
                            page: params.page, // pagination
                            form: formSerializeArray
                            // form: form.serializeArray() // all other form inputs
                        };
                    } else {
                        return {
                            q: params.term, // search term
                            page: params.page, // pagination
                        };
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    let result = {
                        results: $.map(data.data, function (item) {
                            textField = $fieldAttribute;

                            return {
                                text: item[textField],
                                id: `${item[$connectedEntityKeyName]}~${item.price}~${item.stock}`
                            }
                        }),
                        pagination: {
                                more: data.current_page < data.last_page
                        }
                    };

                    return result;
                },
                cache: true
            },
        })
        .on("select2:select", function (e) {
            const indexNumber = element.attr('data-row-number') - 1;
            let name          = element.attr('name');
            let value         = e.target.value;
            let splitValue    = value.split('~');

            let qty           = $(`input[name='details[${indexNumber}][qty]']`).val();
            qty = qty.replace(/\./g, '');

            // Set id current field indexNumber
            // $(`.form-control[name='details[${indexNumber}][product_id]`).val('asd').change();
            // set price current field indexNumber
            $(`input[name='details[${indexNumber}][price]']`).val(formatRupiah(splitValue[1]));
            // // Set stock current field indexNumber
            $(`input[name='details[${indexNumber}][stock]']`).val(formatRupiah(splitValue[2]));
            // // Set subTotal current field indexNumber
            $(`input[name='details[${indexNumber}][sub_total]']`).val(formatRupiah(splitValue[1] * qty));
        });

        mapDependencies(element, $dependencies, form)
    }

    const formatRupiah = (number) => number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // if any dependencies have been declared
    // when one of those dependencies changes value
    // reset the select2 value
    const mapDependencies = (element, $dependencies, form) => {
        let formSerializeArray = form.serializeArray();

        let rowNumber = element.attr('data-row-number');
        let selector = element.attr('data-custom-selector');

        // if any dependencies have been declared inside repeatable field
        // then send those dependencies value with ajax fetch request
        for (let i=0; i < $dependencies.length; i++) {
            let $dependency = $dependencies[i];
            //if element does not have a custom-selector attribute we use the name attribute
            if(typeof element.attr('data-custom-selector') != 'undefined') {
                // we get the row number and custom selector from where element is called
                let rowNumber = element.attr('data-row-number');
                let selector = element.attr('data-custom-selector');

                // replace in the custom selector string the corresponding row and dependency name to match
                selector = selector
                    .replaceAll('%DEPENDENCY%', $dependency)
                    .replaceAll('%ROW%', rowNumber);

                // push current rowNumber & dependency name
                formSerializeArray.push({name: '_row_number', value: rowNumber - 1}, {name: '_dependency', value: $dependency});

                $(selector).change(function (el) {
                    $(element.find('option:not([value=""])')).remove();
                    element.val(null).trigger("change");
                });
            }
        }

        return formSerializeArray
    }
    </script>
    @endLoadOnce
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
