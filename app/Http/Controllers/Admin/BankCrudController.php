<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BankRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BankCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BankCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Bank');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/bank');
        $this->crud->setEntityNameStrings('Ngân Hàng', 'Ngân Hàng');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => 'Tên',
                'type' => 'text'
            ],
            [
                'name' => 'status',
                'label' => 'Trạng thái',
                'type' => 'select_from_array',
                'options' => [
                    1 => 'Active',
                    0 => 'Inactive'
                ]
            ]
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BankRequest::class);
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Tên',
                'type' => 'text'
            ],
            [
                'name' => 'status',
                'label' => 'Trạng thái',
                'type' => 'select_from_array',
                'options' => [
                    1 => 'Active',
                    0 => 'Inactive'
                ]
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
