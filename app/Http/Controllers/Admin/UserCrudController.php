<?php

namespace App\Http\Controllers\Admin;

use App\Models\User as Model;
use App\Http\Requests\UserRequest as Request;

class UserCrudController extends BaseCrudController
{
    use Resources\User\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $orders  = [['name' => 'name', 'type' => 'asc']];

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->handleRequest();

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->handleRequest();

        return $this->traitUpdate();
    }

    /**
     * Handle custom request.
     */
    protected function handleRequest(): void
    {
        $request = $this->crud->getRequest();

        $this->handleRelationships($request);

        $this->handleValidation($request);
    }

    /**
     * Handle model relationships.
     */
    protected function handleRelationships($request): void
    {
        $this->addRequest($request, ["group_ids" => $request->groups]);

        $this->removeRequest($request, ["groups"]);
    }

    /**
     * Handle validation fields.
     */
    protected function handleValidation($request): void
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($request));

        $this->crud->unsetValidation();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request): void
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($request->password) {
            $request->request->set('password', \Hash::make($request->password));
        } else {
            $request->request->remove('password');
        }
    }
}
