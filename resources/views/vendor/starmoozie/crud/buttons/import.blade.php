@if ($crud->hasAccess('import'))
    <input id="import" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="import" />
    <a href="javascript:void(0)" onclick="importTransaction(this)" class="btn btn-sm btn-outline-success shadow-sm" data-button-type="import">
        <span class="ladda-label"><i class="la la-file-excel"></i> {{ __('starmoozie::title.import') }}</span>
    </a>
@endif

@push('after_styles')
    <style>
        #import {
            display:none
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        if (typeof importTransaction != 'function') {
            $("[data-button-type=import]").unbind('click');

            function importTransaction(button) {
                const submit = $("#import:hidden");

                submit.click();

                submit.change(function() {
                    var route     = "{{ url($crud->route.'/import') }}";
                    let file      = submit.prop("files")[0];
                    var form_data = new FormData();

                    form_data.append("file", file);

                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            new Noty({
                                text: "{{ __('starmoozie::alert.imported') }}",
                                type: "success"
                            }).show();

                            crud.table.ajax.reload();

                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(result) {
                            console.log(result.responseJSON.errors)
                            // Show an alert with the result
                            new Noty({
                                text: result.responseJSON.errors.join(),
                                type: "warning"
                            }).show();
                        }
                    });
                })
            }
        }
    </script>
@endpush