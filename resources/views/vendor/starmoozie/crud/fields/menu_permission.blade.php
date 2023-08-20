<!-- checklist -->
@php
    $model = new $field['model'];
    $key_attribute = $model->getKeyName();
    $identifiable_attribute = $field['attribute'];

    // calculate the checklist options
    if (!isset($field['options'])) {
        $field['options'] = $field['model']::all()->pluck($identifiable_attribute, $key_attribute)->toArray();
    } else {
        $field['options'] = call_user_func($field['options'], $field['model']::query());
    }

    // calculate the value of the hidden input
    $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
    if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
        $field['value'] = $field['value']->pluck($key_attribute)->toArray();
    } elseif (is_string($field['value'])){
        $field['value'] = json_decode($field['value']);
    }

    // define the init-function on the wrapper
    $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

        <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}" />

        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    <li>
                        <input type="checkbox" name="check" id="check" />&nbsp;
                        <label for="check">Check All</label>

                        <ul class="list-group">
                            @foreach ($field['options'] as $key => $menu)
                                <li>
                                    @if($menu->children->count())
                                        <input type="checkbox" name="check-{{ $key }}" id="check-{{ $key }}" value="{{ $menu->permissions->pluck('pivot.id')->first() }}" />&nbsp;
                                        <label for="check-{{ $key }}" >{{ $menu->name_translation }}</label>

                                        <ul>
                                            @foreach($menu->children as $key => $menu)
                                                <li style="border: none">
                                                    <input type="checkbox" name="check-{{ $key }}" id="check-{{ $key }}" />&nbsp;
                                                    <label for="check-{{ $key }}">{{ $menu->name_translation }}</label>
                                                    <ul class="list-group">
                                                        @foreach($menu->permissions->sortBy('name_translation') as $k => $permission)
                                                            <li class="list-group-item"  style="border: none">
                                                                <input value="{{ $permission->pivot->{$key_attribute} }}" type="checkbox" name="check-{{ $key }}-{{ $k }}" id="check-{{ $key }}-{{ $k }}" />&nbsp;
                                                                <label class="font-weight-normal" for="check-{{ $key }}-{{ $k }}">{{ $permission->name_translation }}</label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <input type="checkbox" name="check-{{ $key }}" id="check-{{ $key }}"  />&nbsp;
                                        <label for="check-{{ $key }}" >{{ $menu->name_translation }}</label>
                                        <ul class="list-group">
                                            @foreach($menu->permissions->sortBy('name_translation') as $k => $permission)
                                                <li class="list-group-item"  style="border: none">
                                                    <input value="{{ $permission->pivot->{$key_attribute} }}" type="checkbox" name="check-{{ $key }}-{{ $k }}" id="check-{{ $key }}-{{ $k }}" />&nbsp;
                                                    <label class="font-weight-normal" for="check-{{ $key }}-{{ $k }}">{{ $permission->name_translation }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
<style>
    ul {
        list-style: none;
    }
</style>
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function bpFieldInitChecklist(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                var checkboxes = element.find('input[type=checkbox]');

                checkboxes.each(function(key, option) {
                    var id = $(this).val();
                    var checked = selected_options.map(String).includes(id),
                        container = $(this).parent(),
                        siblings = container.siblings();

                    if (checked) {
                        $(this).prop('checked', 'checked');
                    } else {
                        $(this).prop('checked', false);
                    }

                    checkSiblings(container, checked);
                });

                $('input[type="checkbox"]').change(function(e) {
                    var newValue = [];
                    var checked = $(this).prop("checked"),
                        container = $(this).parent(),
                        siblings = container.siblings();

                    container.find('input[type="checkbox"]').prop({
                        indeterminate: false,
                        checked: checked
                    });

                    checkSiblings(container, checked);

                    checkboxes.each(function() {
                        var checked = $(this).is(':checked');
                        var indeterminate = $(this).is(':indeterminate');

                        if (checked || indeterminate) {
                            var id = $(this).val();
                            if (id !== "on") {
                                newValue.push(id);
                            }
                        }

                        hidden_input.val(JSON.stringify(newValue));
                    });
                });
            }

            function checkSiblings(el, checked) {
                var parent = el.parent().parent(),
                    all = true;

                el.siblings().each(function() {
                    let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                    return returnValue;
                });
                if (all && checked) {
                    parent.children('input[type="checkbox"]').prop({
                        indeterminate: false,
                        checked: checked
                    });
                    checkSiblings(parent, checked);
                }
                else if (all && !checked) {
                    parent.children('input[type="checkbox"]').prop("checked", checked);
                    parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                    checkSiblings(parent, checked);
                } 
                else {
                    el.parents("li").children('input[type="checkbox"]').prop({
                        indeterminate: true,
                        checked: false
                    });
                }
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
