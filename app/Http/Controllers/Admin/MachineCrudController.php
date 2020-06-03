<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MachineRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MachineCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MachineCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Machine');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/machine');
        $this->crud->setEntityNameStrings('Máy POS', 'Máy POS');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'code',
                'label' => 'Mã máy',
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
                'name' => 'max_amount_per_date',
                'type' => 'number',
                'label' => 'Tổng hạn mức ngày'
            ],
            [
                'name' => 'max_amount_per_trans',
                'type' => 'number',
                'label' => 'Hạn mức 1 giao dịch'
            ],
            [
                'name' => 'fee_percent_per_trans',
                'type' => 'number',
                'label' => 'Phí giao dịch (%)'
            ],
            [
                // n-n relationship (with pivot table)
                'label'     => 'Ngân hàng khả dụng', // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'availableBanks', // the method that defines the relationship in your Model
                'entity'    => 'availableBanks', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => 'App\Models\Bank', // foreign key model
                'searchLogic' => false,
            ],

        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MachineRequest::class);

        $this->crud->addFields([
            [
                'name' => 'code',
                'label' => 'Mã máy',
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
                'name' => 'max_amount_per_date',
                'type' => 'number_currency',
                'label' => 'Tổng hạn mức ngày'
            ],
            [
                'name' => 'max_amount_per_trans',
                'type' => 'number_currency',
                'label' => 'Hạn mức 1 giao dịch'
            ],
            [
                'name' => 'fee_percent_per_trans',
                'type' => 'number',
                'label' => 'Phí giao dịch (%)'
            ],
            [    // Select2Multiple = n-n relationship (with pivot table)
                'label'     => "Ngân hàng khả dụng",
                'type'      => 'select2_multiple',
                'name'      => 'availableBanks', // the method that defines the relationship in your Model
                'entity'    => 'availableBanks', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user

                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
                'select_all' => true, // show Select All and Clear buttons?

                // optional
                'model'     => "App\Models\Bank", // foreign key model
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
