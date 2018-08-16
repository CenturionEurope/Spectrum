<!-- Top Bar Start -->
<div class="topbar">
    <!-- Logo -->
    <div class="topbar-left">
        <a href="#" onclick="$('ul.Modules li a[data-module=today]').click();" class="logo"><img src="/Cole/Brand/Cole.png" width="120"/></a>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Page title -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left">
                        <i class="zmdi zmdi-menu"></i>
                    </button>
                </li>
                <li>
                    <h4 class="page-title ModuleName">Today</h4>
                </li>
            </ul>
            <!-- Right(Notification and Searchbox -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <!-- Notification -->
                    <div class="notification-box">
                        <ul class="list-inline m-b-0 StandardControls">
                            <li>                            
                                <a href="javascript:void(0);" class="right-bar-toggle">
                                    <i class="zmdi zmdi-notifications-none"></i>
                                </a>
                                @if($Cole->Notifications->Count!=0)
                                <div class="noti-dot">
                                    <span class="dot"></span>
                                    <span class="pulse"></span>
                                </div>
                                @endif
                            </li>
                            <li>
                                <a id="Logout">
                                    <i class="zmdi zmdi-power"></i>
                                </a>
                            </li>                                       
                        </ul>
                        <ul class="list-inline m-b-0 NoSideControls">
                            <li>
                                <a id="CloseNoSide">
                                    <i class="zmdi zmdi-close-circle"></i>
                                </a>
                            </li>                                       
                        </ul>
                    </div>
                    <!-- End Notification bar -->
                </li>
            </ul>
        </div><!-- end container -->
    </div><!-- end navbar -->
</div>
<!-- Top Bar End -->