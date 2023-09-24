<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

    <div class="btn-group group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-outline-info btn-sm dropdown-toggle shadow-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-history" aria-hidden="true"></i> {{ __('starmoozie::title.history') }}
        </button>
        <div class="dropdown-menu shadow" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/purchase') }}">{{ __('starmoozie::title.purchase') }}</a>
            <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/sale') }}">{{ __('starmoozie::title.sale') }}</a>
        </div>
    </div>
</div>

@push('after_scripts')
    <script>
        $('.group').mouseover(function () {
            $(this).addClass('show').attr('aria-expanded', 'true');
            $(this).find('.dropdown-menu').addClass('show');
        }).mouseout(function () {
            $(this).removeClass('show').attr('aria-expanded', 'false');
            $(this).find('.dropdown-menu').removeClass('show');
        });
    </script>
@endpush
