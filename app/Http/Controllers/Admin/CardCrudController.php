<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Controllers\Admin\Operations\TransactionOperation;
use App\Http\Requests\CardRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


/**
 * Class CardCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CardCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use TransactionOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Card');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/card');
        $this->crud->setEntityNameStrings('Thẻ', 'Thẻ');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'code',
                'label' => 'Mã Thẻ',
                'type' => 'text'
            ],
            [
                'label' => 'Ngân hàng',
                'type' => 'select',
                'name' => 'bank_id',
                'entity' => 'bank',
                'attribute' => 'name',
                'model' => "App\Models\Bank",
                'searchLogic' => false,
            ],
            [
                'label' => 'Khách hàng',
                'type' => 'select',
                'name' => 'customer_id',
                'entity' => 'customer',
                'attribute' => 'name',
                'model' => "App\Models\Customer",
                'searchLogic' => false,
            ],
            [
                'name' => 'revert_date',
                'type' => 'select_from_array',
                'label' => 'Ngày đáo thẻ',
                'options' => Helpers::getRevertedDates()
            ],
            [
                'name' => 'trans_fee_percent',
                'type' => 'number',
                'label' => 'Phí giao dịch (%)'
            ]
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CardRequest::class);

        $this->crud->addFields([
            [
                'name' => 'code',
                'label' => 'Mã Thẻ',
                'type' => 'text'
            ],
            [
                'label' => 'Ngân hàng',
                'type' => 'select',
                'name' => 'bank_id',
                'entity' => 'bank',
                'attribute' => 'name',
                'model' => "App\Models\Bank",
                'searchLogic' => false,
            ],
            [
                'label' => 'Khách hàng',
                'type' => 'select',
                'name' => 'customer_id',
                'entity' => 'customer',
                'attribute' => 'name',
                'model' => "App\Models\Customer",
                'searchLogic' => false,
            ],
            [
                'name' => 'revert_date',
                'type' => 'select_from_array',
                'label' => 'Ngày đáo thẻ',
                'options' => Helpers::getRevertedDates()
            ],
            [
                'name' => 'trans_fee_percent',
                'type' => 'number',
                'label' => 'Phí giao dịch (%)'
            ]
        ]);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }



}
