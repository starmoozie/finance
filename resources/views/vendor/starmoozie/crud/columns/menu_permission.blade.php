@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    @foreach($entry->{$column['name']} as $parent)
        <li style="list-style: none;"><b>{{ $parent['name'] }}</b></li>
            @if(count($parent['children']))
                <ul>
                    @foreach($parent['children'] as $child)
                        <li><b>{{ $child['name'] }}</b></li>
                        <ul style="columns: 4;">
                            @foreach(collect($child['permission'])->sortBy('name_translation') as $permission)
                                <li>{{ $permission['name_translation'] }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </ul>
                @else
                    <ul style="columns: 4;">
                        @foreach(collect($parent['permission'])->sortBy('name_translation') as $permission)
                            <li style='list-style-type: circle;'><span class="text-dark">{{ $permission['name_translation'] }}</span></li>
                        @endforeach
                    </ul>
                @endif
    @endforeach
    <style>
        @media (min-width: 768px)
        {
            ul { grid-template-columns: auto auto; }
        }

        @media (min-width: 1024px)
        {
            ul { grid-template-columns: auto auto auto auto; }
        }
    </style>
@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')