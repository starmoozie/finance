@php
	$column['value'] = $column['value'] ?? data_get($entry, $column['name']);
    $column['columns'] = $column['columns'] ?? ['value' => 'Value'];

    if($column['value'] instanceof \Closure) {
        $column['value'] = $column['value']($entry);
    }

	// if this attribute isn't using attribute casting, decode it
	if (is_string($column['value'])) {
	    $column['value'] = json_decode($column['value']);
    }
@endphp

<span>
    @if ($column['value'] && count($column['columns']))

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')

    <div class="table-responsive">
        <table class="table table-bordered table-condensed table-striped m-b-0">
            @switch(Route::currentRouteName())
                @case('purchase.show')
                    @includeIf('starmoozie::crud.pages.purchase.details')
                    @break

                @case('sale.show')
                    @includeIf('starmoozie::crud.pages.sale.details')
                    @break

                @case('product.show')
                    @if($column['key'] === 'purchases')
                        @includeIf('starmoozie::crud.pages.product.purchase_histories')
                    @else
                        @includeIf('starmoozie::crud.pages.product.sale_histories')
                    @endif
                    @break

                @default
                    @break
            @endswitch
        </table>
    </div>

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
    
    @else
    
    {{ $column['default'] ?? '-' }}

	@endif
</span>
