<?php

namespace App\Http\Controllers\Admin\Resources;

trait GlobalColumns
{
    protected function creatorColumn()
    {
        if (!$this->crud->hasAccess('personal')) {
            $this->crud->column('creator')
                ->label(__('starmoozie::title.creator'))
                ->wrapper([
                    'href' => fn($crud, $column, $entry, $related_key) => starmoozie_url("user/{$related_key}/show")
                ]);
        }
    }
}
