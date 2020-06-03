<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
                class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('bank') }}'><i class='nav-icon la la-bank'></i> Ngân Hàng</a>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('customer') }}'><i class='nav-icon la la-user'></i> Khách
        Hàng</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('card') }}'><i class='nav-icon la la-id-card'></i>Thẻ ATM
        </a>
</li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('machine') }}'><i class='nav-icon la la-car'></i>
        Máy POS</a></li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('record') }}'><i class='nav-icon la la-record-vinyl'></i>
        Giao dịch</a></li>