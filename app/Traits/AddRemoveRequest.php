<?php

namespace App\Traits;

trait AddRemoveRequest
{
    /**
     * Add fields into request.
     */
    protected function addRequest($request, $fields): void
    {
        foreach ($fields as $column => $value) {
            $this->crud->addField(['type' => 'hidden', 'name' => $column]);
            $request->request->add([$column=> $value]);
        }
    }

    /**
     * Remove fields in request.
     */
    protected function removeRequest($request, $columns): void
    {
        foreach ($columns as $column) {
            $request->request->remove($column);
        }
    }
}
