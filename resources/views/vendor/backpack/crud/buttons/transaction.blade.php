@if (\App\Helpers::checkCanCreateTransactionCard($entry))

<a  href="{{ url($crud->route.'/'.$entry->getKey().'/transaction') }}" class="btn btn-xs btn-default">
    <i class="la la-cart-plus"></i>Tạo giao dịch
</a>

@endif
