<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RecordRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RecordCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RecordCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Record');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/record');
        $this->crud->setEntityNameStrings('Giao dịch', 'Giao dịch');
        $this->crud->denyAccess('edit');
        $this->crud->denyAccess('create');
        $this->crud->denyAccess('delete');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'label' => 'Thẻ',
                'type' => 'select',
                'name' => 'card',
                'entity' => 'card',
                'attribute' => 'code',
                'model' => "App\Models\Card",
                'searchLogic' => false,
            ],
            [
                'name' => 'amount',
                'type' => 'number',
                'label' => 'Số tiền'
            ],
            [
                'label' => 'Máy POS',
                'type' => 'select',
                'name' => 'machine',
                'entity' => 'machine',
                'attribute' => 'code',
                'model' => "App\Models\Machine",
                'searchLogic' => false,
            ],
            [
                'name' => 'card_fee_percent',
                'type' => 'number',
                'label' => 'Phí giao dịch Thẻ (%)'
            ],

            [
                'name' => 'machine_fee_percent',
                'type' => 'number',
                'label' => 'Phí giao dịch máy POS (%)'
            ],


        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(RecordRequest::class);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
