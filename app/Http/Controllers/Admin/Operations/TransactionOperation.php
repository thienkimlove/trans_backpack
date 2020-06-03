<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

trait TransactionOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupTransactionRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/transaction', [
            'as'        => $routeName.'.getTransaction',
            'uses'      => $controller.'@getTransactionForm',
            'operation' => 'transaction',
        ]);
        Route::post($segment.'/{id}/transaction', [
            'as'        => $routeName.'.postTransaction',
            'uses'      => $controller.'@postTransactionForm',
            'operation' => 'transaction',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupTransactionDefaults()
    {
        //$this->crud->allowAccess('transaction');

        $this->crud->operation('transaction', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            // $this->crud->addButton('top', 'transaction', 'view', 'crud::buttons.transaction');
            $this->crud->addButtonFromView('line', 'transaction', 'transaction', 'beginning');
        });
    }

    public function getTransactionForm($id)
    {
        // $this->crud->hasAccessOrFail('update');
        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);

        $customerCrud = $this->crud;

        $customerCrud->removeAllFields();

        $customerCrud->addFields([
            [
                'name' => 'amount_put',
                'type' => 'number_currency',
                'label' => 'Số tiền Nạp'
            ],
            [
                'name' => 'amount_get',
                'type' => 'number_currency',
                'label' => 'Số tiền Rút'
            ],
        ]);

        $this->data['crud'] = $customerCrud;
        $this->data['crud_id'] = $id;
        $this->data['title'] = 'Tạo mới giao dịch cho thẻ '.$this->data['entry']->code;

        return view('vendor.backpack.crud.transaction', $this->data);
    }

    public function postTransactionForm(Request $request)
    {
        // $this->crud->hasAccessOrFail('update');

        // TODO: do whatever logic you need here
        // ...
        // You can use
        // - $this->crud
        // - $this->crud->getEntry($id)
        // - $request
        // ...

        // show a success message

        Helpers::log($request->all());

        list($status, $message) = Helpers::createTransactionCard($request->all());

        if ($status) {
            Alert::success($message)->flash();
        } else {
            Alert::error($message)->flash();
        }

        return Redirect::to($this->crud->route);
    }
}
