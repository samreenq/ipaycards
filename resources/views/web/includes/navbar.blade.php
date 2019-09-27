@section('navbar')
    <!-- Static navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-faded">
        <div class="container">

            <a class="navbar-brand" href="{{ route('main') }}">
                {{-- <h4 style="font-family: 'Roboto', sans-serif;font-weight: 400;line-height: 1.5;color: #212529;margin-right:10px;">CubixCommerce</h4>--}}
                <img class="logoIcon" width="74" src="<?php echo url('/').'/public/web/img/logo.png'; ?>" />
            <!-- <img class="logoWoIcon" src="<?php //echo url('/').'/public/web/img/logo-text.png'; ?>" width="140"/> -->
            </a>
            <div class="search-with-cart">
                <!-- mobile search button start -->
                <button class="search-toggler" type="button" data-toggle="collapse"  data-target="#searchCollapse" aria-controls="searchCollapse" aria-expanded="false" aria-label="Toggle search">
                    <span class="icon-tt-search-icon"></span>
                </button>
                <!-- mobile search button end -->

               {{-- <!-- navbar toggle button start -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- navbar toggle button end -->--}}
            <!-- navbar toggle button start -->
                <button class="hamburger hamburger--slider js-hamburger" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </div>
                </button>
                <!-- navbar toggle button end -->
            </div>

            <!-- mobile search start -->
            <div class="collapse search-collapse" id="searchCollapse">
                <div class="col-12 bg-search">
                    <div class="toolbar-search mobile-search">
                        <input class="search-bar" name="search" placeholder="Search healthy food and more" type="search" value="">
                        <button class="search-btn" name="button" type="submit"><span class="icon-tt-right-arrow"></span></button>
                    </div>
                </div>
            </div>
            <!-- mobile search end -->

            <!-- navbar toggle menu start -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                <!--<li><a href="#" data-toggle="modal" data-target=".aboutUsmodal" id="how-work">@lang('web.navbar_menu_name_1')</a></li>
						<li><a href="#" data-toggle="modal" data-target=".aboutUsmodal" id="delivery-info-model">@lang('web.navbar_menu_name_2')</a></li> -->


                <?php

                /*if (isset($_SESSION['fbUserProfile']) )
                {
            */?><!--
									<li><a href="#" data-toggle="modal" data-target=".referfriendmodal" >@lang('web.navbar_menu_name_3')</a></li>

						<?php
                /*								}

                                                if (Session::has('users')  )
                                                {

                                        */?>
                        <li><a href="#" data-toggle="modal" data-target=".referfriendmodal" >@lang('web.navbar_menu_name_3')</a></li>


						<?php /*
								}
								if (!Session::has('users') && !isset($_SESSION['fbUserProfile']) )
								{

						*/?>

                        <li><a href="#" data-toggle="modal" data-target=".siginmodal" class="tooltip1" >@lang('web.navbar_menu_name_3')<span class="tooltiptext">Please Sign-in before Referring to a Friend! </span></a></li>

						--><?php /*
								}*/


                ?>


                <!--<li><a href="{{route('faq')}}">@lang('web.navbar_menu_name_4')</a></li>-->


                </ul>



                <?php

                if (isset($_SESSION['fbUserProfile']) )
                {
                ?>
                <ul class="nav navbar-nav navbar-right header-cart">
                    <li><a href="{{ route('account_detail') }}" >@lang('web.navbar_menu_account')</a></li>
                <!--	<li><a href="<?php echo $_SESSION['logoutURL']; ?>" >@lang('web.navbar_menu_sign_Out')</a></li>
								-->	<li><a href="{{ route('signout') }}" >@lang('web.navbar_menu_sign_Out')</a></li>

                </ul>

                <?php
                }
                //print_r(session()::get('users'));
                if (Session::has('users')  )
                {

                ?>
                <ul class="nav navbar-nav navbar-right header-cart">
{{--                    <li class="dropdown">--}}
{{--                        <a class="dropdown-toggle p-0" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            Recharge--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                            <a class="dropdown-item" href="{!! url('/').'/topup/du' !!}">Du</a>--}}
{{--                            <a class="dropdown-item" href="{!! url('/').'/topup/etisalat' !!}">Etisalat</a>--}}
{{--                            <a class="dropdown-item" href="{!! url('/').'/fly_dubai' !!}">Fly Dubai</a>--}}
{{--                            <a class="dropdown-item" href="{!! url('/').'/addc' !!}">Addc</a>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                    <li><a href="{{ route('account_detail') }}" >@lang('web.navbar_menu_account')</a></li>
                    <li><a href="javascript:void(0)" id="signout" >@lang('web.navbar_menu_sign_Out')</a></li>
                </ul>

                <?php
                }
                if (!Session::has('users') && !isset($_SESSION['fbUserProfile']) )
                {

                ?>
                <ul class="nav navbar-nav navbar-right header-cart">
                   {{-- <li class="dropdown">
                        <a class="dropdown-toggle p-0" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Recharge
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{!! url('/').'/topup/du' !!}">Du</a>
                            <a class="dropdown-item" href="{!! url('/').'/topup/etisalat' !!}">Etisalat</a>
                            <a class="dropdown-item" href="{!! url('/').'/fly_dubai' !!}">Fly Dubai</a>
                            <a class="dropdown-item" href="{!! url('/').'/addc' !!}">Addc</a>
                        </div>
                    </li>--}}
                    <li><a href="javascript:void(0)" class="signinbtn" data-toggle="modal" data-target=".siginmodal">@lang('web.navbar_menu_sign_in')</a></li>
                    <li><a href="javascript:void(0)" class="signupbtn"  data-toggle="modal" data-target=".signupmodal">@lang('web.navbar_menu_sign_up')</a></li>
                </ul>
                <?php
                }


                ?>
            </div>
            <!-- navbar toggle menu end -->

            <div class="headerRight">
                <a href="javascript:void(0)" id="cartList"><span class="icon-tt-cart-Icon"></span><span class="orderNotification" style="display:none"></span></a></li>
            </div>
        </div>
    </nav>
@show