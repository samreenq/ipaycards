
<div class="dashboardLeftBar col-md-12 col-lg-3 col-xl-2">
    <aside>
        <ul class="sidebar__inner">
            <li class="@if(Request::route()->getName() == 'account_detail') active @endif"><a href="{{ route('account_detail') }}">Your Account</a></li>
        <!--<li class=""><a href="{{ route('payment') }}">Payment</a></li>-->
            <li class="@if(Request::route()->getName() == 'order_history') active @endif"><a href="{{ route('order_history') }}">Order History</a></li>
            {{--<li class=""><a href="{{ route('address_book') }}">Address Book</a></li>--}}
            <li class="@if(Request::route()->getName() == 'customer_wallet') active @endif"><a href="{{ route('customer_wallet') }}">Gift Card Settings</a></li>
            <li class="@if(Request::route()->getName() == 'gift_card') active @endif"><a href="{{ route('gift_card') }}">Add Gift Card</a></li>
            <?php
            if (isset($_SESSION['fbUserProfile']) )
            {
            ?>

            <li ><a href="<?php echo $_SESSION['logoutURL']; ?>">Sign Out</a></li>

            <?php
            }
            if (Session::has('users')  )
            {

            ?>

            <li ><a href="javascript:void(0)" onclick="signout()" id="signout">Sign Out</a></li>

            <?php
            }
            ?>
        </ul>
    </aside>
</div>