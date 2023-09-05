<!-- This file is used to store topbar (right) items -->
{{--
<?php
    $count = isset($data) ? $data->count() : 0;
?>

<li class="nav-item d-md-down-none mt-1">
    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="la la-bell"></i>
        <span class="badge badge-pill badge-danger">{{ $count }}</span>
    </a>
    @if($count)
        <div class="dropdown-menu {{ config('starmoozie.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mt-1 pb-1 pt-1">
            @foreach($data->take(5) as $item)
                <a class="dropdown-item" href="{{ starmoozie_url('item/'.$item->id.'/show') }}"> {{ Str::limit($item->name, 15, '…') }} <span class="badge badge-pill badge-danger">{{ $item->stock }}</span></a>
                <div class="dropdown-divider"></div>
            @endforeach
            <div class="text-center">
                <a class="dropdown-item" style="background-color: #fff; color: #000" href="{{ starmoozie_url('item?min_stock=true') }}">{{ trans('starmoozie::title.view_all') }}</a>
            </div>
        </div>
    @endif
</li>
--}}
