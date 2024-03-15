<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="margin-top: 10px">
                <a href="{{url('/home')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{url('eshago_logo.png')}}" alt="" height="32">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{url('eshago_logo.png')}}" alt="" height="30">
                                </span>
                </a>

                <a href="{{url('/home')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{url('eshago_logo.png')}}" alt="" height="32">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{url('eshago_logo.png')}}" alt="" height="30">
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-backburger"></i>
            </button>

        </div>
        @guest
            <li><a class="nav-link" href="{{ route('login') }}">{{ trans('titles.login') }}</a></li>
            <li><a class="nav-link" href="{{ route('register') }}">{{ trans('titles.register') }}</a></li>
        @else
            <div class="d-flex">

                @if (auth()->user()->utype == 'System')
                <div class="d-inline-block">
                    <button type="button" class="btn header-item waves-effect" aria-expanded="false">
                        <a class="" href="{{asset('/laraview/eShagiManual.pdf')}}" target="_blank">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAAC8klEQVRoge2YT2gUdxTHP++3605W03WXzaJBSlAU4yFSSAwtxZ6tqPTmIQcvNqeeCioUeqsHPXgu0nNL8WAuevTQP7QVQyVpUEFQEcmWdJjdSZbNbnZ/r4ckGwOZ0Yy7DoH5wMCP95vf973vvN/Mzg4kJCQkJLwDEjY5/ejp6ND+0gNVVYUmIosorhEtAx7gCfJC4RmGx8Vc7qGINMM0VTXj+v5HWIYFDio6BBSAgqqUEAbUak6MZATMi/LC2Oixw9NBeumwZMYwCSAiIuAADsIAyNFOQesDC67nL7te5b4iPxTzuZ/Xzahqxq345wW96Hr+OELfxtqNayhrQzGbYl8CgQYCOzA3N9ffTDmvPtxXyoWZDELR6VIhPwaw4FX+EmQ8is7LfxeWGik98PGRI/5W85s6MHh5pnNBb/wpfPVplJSrCDI6de93XRtHF4L+m7+sVAcvz3QC89ePdwRN0KpTw6G7673yeUgtgQYOFwOnusb3M8Jntww3Z8M7FFZL76sM4acnQr0FPz6JvsViNTAxrOxOw8RRffPJAcS60SdHlMmR6MVDzB3oBrF24PSUYaEOpSzc/cJG0tjxHUgMxE1iIG4SA3GTGIibHW8g1leJqK8Pr7PjO5AYiJsdbyD0Jq7Vl/nt738wRjBiSKcMqVSK9PqRTuFkdtGXyZB1HPZk+zAm/P+ttUqtvky90WC52aTRXKHVatNqrx7tdptW22LVYq1SKuTZnXW2b8Bai+cvdpJaVhPASqCYiOGDPVn2FwsM5PduKvq/SpWy67FYq6P69k8ft+rjOMXtG3CrPu329h5zqhZ/qYa/VKPsep343NPnVGu1bWmtY63FrfhAZsv5QAMXbmcCF72J/l8vIY3qppg6eZZOXo+kF0ZPbuKVwU/eKtYNevJL3Dh0DoBd838Aq8U3Dp3tRap3++q6FYNXZq+i+k1Atu/mrx3/tpv5um4AYN+l2TMpsV8rcgJAlPvWyI3ytZE7vciXkJCQkBCZ/wFMeQNgF+xqwgAAAABJRU5ErkJggg==" style="height: 36px;"/>
                        </a>
                    </button>

                </div>
                @endif

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-flag-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-18px mdi-bell-outline"></i>
                        @if (auth()->user()->unreadNotifications->count())
                            <span class="badge badge-pill badge-danger">{{auth()->user()->unreadNotifications->count()}}</span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            @include('partials.notification.'.snake_case(class_basename($notification->type)))
                        @empty
                            <li class="dropdown-item notify-item" >
                                <a href="#">All caught up here, Great!</a>
                            </li>
                        @endforelse
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                            <img class="rounded-circle header-profile-user" src="{{ url(Auth::user()->profile->avatar) }}" alt="{{ Auth::user()->name }}" >
                        @else
                            <img class="rounded-circle header-profile-user" src="{{  Gravatar::get(auth()->user()->email) }}" alt="{{ Auth::user()->name }}">
                        @endif
                        <span class="d-none d-sm-inline-block ml-1">{{ Auth::user()->name }} - {{ Auth::user()->paynumber }} <span class="caret"></span></span>
                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}" href="{{ url('/profile/'.Auth::user()->name) }}"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

            </div>
        @endguest
    </div>

</header>
@role('root')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/loan-amortization')}}">Amortization Schedule</a></li>
                        <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>-->
                        <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                        <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                        <!--<li><a href="{{url('/ndasenda-processing-loans')}}">Ndasenda Processing</a></li>-->
                        <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                        <li><a href="{{url('/pending-disbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                        <!--<li><a href="{{url('/disbursed-loans-template')}}">Email Disbursed </a></li>-->
                        <li><a href="{{url('/declined-loans')}}">Declined Loans</a></li>
                        <!--<li><a href="{{url('/cleared-loans')}}">Cleared Loans</a></li>-->
                        <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                        <!--<li><a href="{{url('/loans-to-settle')}}">Settle Loans</a></li>-->
                        <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                        <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>
                        <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                        <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                        <li><a href="{{url('/loans')}}">All Loans</a></li>
                        <li><a href="{{url('/loans/deleted')}}">Deleted Loans</a></li>
                        <li><a href="{{url('/product-loans')}}">Product Loans</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-android"></i></div>
                        <span>Device Financing</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>-->
                        <li><a href="{{url('/new-deviceloans')}}">New Loans</a></li>
                        <li><a href="{{url('/kyc-check-deviceloans')}}">Loans Under KYC</a></li>
                        <li><a href="{{url('/initialize-loan-disk')}}">Post to LoanDisk</a></li>
                        <li><a href="{{url('/to-enroll-paytrigger')}}">Enroll To PayTrigger</a></li>
                        <li><a href="{{url('/enrolled-paytrigger')}}">Enrolled on PayTrigger</a></li>
                        <li><a href="{{url('/device-loans')}}">All Device Loans</a></li>
                        <li><a href="{{url('/device-loans/deleted')}}">Deleted Loans</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-lock"></i></div>
                        <span>PayTrigger</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/opt-to-removelock')}}">Remove Lock</a></li>

                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/loan-requests')}}">Loan Requests</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                        <li><a href="{{url('/manage-loan-requests')}}">Manage Loan Requests</a></li>
                        <li><a href="{{url('/loan-requests/deleted')}}">Deleted Loan Requests</a></li>
                    </ul>
                </li>-->

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/eloan-amortization')}}">Amortization Schedule</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/new-eloans')}}">New eLoans</a></li>
                        <li><a href="{{url('/pending-eloans')}}">Pending eLoans</a></li>
                        <li><a href="{{url('/authorized-eloans')}}">Authorized eLoans</a></li>
                        <li><a href="{{url('/pending-edisbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-eloans')}}">Disbursed </a></li>
                        <li><a href="{{url('/declined-eloans')}}">Declined eLoans</a></li>
                        <li><a href="{{url('/cleared-eloans')}}">Cleared eLoans</a></li>
                        <li><a href="{{url('/eloan-records')}}">eLoan Records</a></li>
                        <li><a href="{{url('/eloans-to-settle')}}">Settle Loans</a></li>
                        <li><a href="{{url('/eloans')}}">All eLoans</a></li>
                        <li><a href="{{url('/eloans/deleted')}}">Deleted eLoans</a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-anchor"></i></div>
                        <span>Old Mutual</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/old-mutual-loans')}}">Old Mutual Loans</a></li>
                        <li><a href="{{url('/mutual-clients')}}">Old Mutual Clients</a></li>
                        <li><a href="{{url('/single-client-info')}}">Verify Client Info</a></li>
                        <li><a href="{{url('/start-musoni-loan')}}">Apply For Loan</a></li>

                    </ul>
                </li>-->

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="dripicons-jewel"></i></div>
                        <span>ZWMB</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/unclaimed-kycs')}}">Process KYC</a></li>
                        <li><a href="{{url('/get-reviewed-zwmb')}}">KYC to Authorize</a></li>
                        <li><a href="{{url('/zwmbs')}}">ZWMB Clients</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
                        <li><a href="{{url('/pending-device-kyc')}}"> Pending Device KYCs </a></li>
                        <li><a href="{{url('/authorize-device-kyc')}}"> Authorize Device KYCs </a></li>
                        <li><a href="{{url('/bot-pending-info')}}"> Bot Pending KYCs </a></li>
                        <li><a href="{{url('/pending-partner-kyc')}}"> Partner Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/merchant-kycs')}}">Merchant KYCs </a></li>
                        <li><a href="{{url('/cbz-check')}}">KYC Verification</a></li>
                        <!--<li><a href="{{url('/cbz-pending-kycs')}}"> CBZ Review KYCs </a></li>
                        <li><a href="{{url('/fcb-update')}}">FCB Pending Clients </a></li>
                        <li><a href="{{url('/fcb-recheck')}}">FCB Recheck </a></li>
                        <li><a href="{{url('/fcb-responses')}}">FCB Responses </a></li>-->
                    </ul>
                </li>
@php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                        <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                        <li><a href="{{url('/kycchanges/deleted')}}"> Deleted Requests </a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-robot"></i></div>
                        <span>Bot Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bot-applications')}}">All Applications</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Offer Letters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/current-offer-letters')}}">Current Offer Letters</a></li>
                        <li><a href="{{url('/offer-letters')}}">All Offer Letters</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-database"></i></div>
                        <span>Ndasenda Batches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-batches')}}">Pending Batches</a></li>
                        <li><a href="{{url('/upload-loans-batch')}}">Upload Loans</a></li>
                        <li><a href="{{url('/committed-batches')}}">Committed Batches</a></li>
                        <li><a href="{{url('/processed-batches')}}">Processed Batches</a></li>
                        <li><a href="{{url('/batches')}}">All Batches</a></li>
                        <li><a href="{{url('/ndaseresponses')}}">Ndasenda Responses</a></li>
                        <li><a href="{{url('/batches/deleted')}}">Deleted Batches</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('leads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('sms-leads-list')}}">SMS Leads</a></li>
                        <li><a href="{{url('allocate-leads')}}">Distribute Leads</a></li>
                        <li><a href="{{url('manage-leads')}}">Manage Leads</a></li>
                        <li><a href="{{url('leads-import')}}">Import Leads</a></li>
                        <li><a href="{{url('leads')}}">Leads</a></li>
                        <li><a href="{{url('leads/deleted')}}">Deleted Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls')}}">Calls</a></li>
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('my-calls')}}">My Calls</a></li>
                        <li><a href="{{url('calls/deleted')}}">Deleted Calls</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                        <li><a href="{{url('manage-queries')}}">Manage Queries</a></li>
                        <li><a href="{{url('queries/deleted')}}">Deleted Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Loans Accounting</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-bank"></i></div>
                        <span>Bank Accounts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bank-accounts/create')}}">New Account</a></li>
                        <li><a href="{{url('/bank-accounts')}}">All Accounts</a></li>
                        <li><a href="{{url('/bank-accounts/deleted')}}">Deleted Accounts</a></li>
                    </ul>
                </li>

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cash-usd-outline"></i></div>
                        <span>eDisbursements</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/process-edisbursements')}}">Process eDisbursements</a></li>
                        <li><a href="{{url('/current-edisbursements')}}">Current eDisbursements</a></li>
                        <li><a href="{{url('/edisbursements')}}">All eDisbursements</a></li>
                        <li><a href="{{url('/edisbursements/deleted')}}">Deleted eDisbursements</a></li>
                    </ul>
                </li>--}}

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-clipboard-text"></i></div>
                        <span>Ledgers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/ledgers/create')}}">New Ledger</a></li>
                        <li><a href="{{url('/ledgers')}}">All Ledgers</a></li>
                        <li><a href="{{url('/ledgers/deleted')}}">Deleted Ledgers</a></li>
                    </ul>
                </li>--}}

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-star-outline"></i></div>
                        <span>Borrowers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/borrowers/create')}}">New Borrower</a></li>
                        <li><a href="{{url('/borrowers')}}">All Borrowers</a></li>
                        <li><a href="{{url('/borrowers/deleted')}}">Deleted Borrowers</a></li>
                    </ul>
                </li>--}}

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-crown-outline"></i></div>
                        <span>eAccounts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/accounts/create')}}">New Account</a></li>
                        <li><a href="{{url('/accounts')}}">All Accounts</a></li>
                        <li><a href="{{url('/eshagi-account')}}">eShagi Account</a></li>
                        <li><a href="{{url('/accounts/deleted')}}">Deleted Accounts</a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/repayments/create')}}">New Repayment</a></li>
                        <li><a href="{{url('/current-repayments')}}">Current Repayments</a></li>
                        <li><a href="{{url('/repayments')}}">All Repayments</a></li>
                        <li><a href="{{url('/repayments/deleted')}}">Deleted Repayments</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span>Payments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/payments/create')}}">New Payment</a></li>
                        <li><a href="{{url('/payments')}}">All Payments</a></li>
                        <li><a href="{{url('/zambia-payments/create')}}">New Zambia Payment</a></li>
                        <li><a href="{{url('/zambia-payments')}}">All Zambia Payments</a></li>
                        <li><a href="{{url('/zambia-bulk-payments')}}">Import Bulk Repayments</a></li>
                        <li><a href="{{url('/payments/deleted')}}">Deleted Payments</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package"></i></div>
                        <span>Arrears</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('arrears')}}">All Arrears</a></li>
                        <li><a href="{{url('communicate-arrears')}}">Communication</a></li>
                        <li><a href="{{url('')}}">Settle Arrears</a></li>
                        <li><a href="{{url('')}}">Demand Letter Templates</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Commissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('commissions/create')}}">Add Commission</a></li>
                        <li><a href="{{url('unpaid-commissions')}}">Unpaid</a></li>
                        <li><a href="{{url('paid-commissions')}}">Paid</a></li>
                        <li><a href="{{url('pay-commissions')}}">Register Payments</a></li>
                        <li><a href="{{url('commissions')}}">Commissions</a></li>
                        <li><a href="{{url('commissions/deleted')}}">Deleted Commissions</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('disbursed-report')}}">Disbursed Loans</a></li>
                        <li><a href="{{url('disbursed-product')}}">Disbursed Devices</a></li>
                        <li><a href="{{url('pending-loans-report')}}">Pending Loans</a></li>
                        <li><a href="{{url('declined-report')}}">Declined Loans</a></li>
                        <li><a href="{{url('commissions-report')}}">Commissions</a></li>
                        <li><a href="{{url('loans-by-report')}}">Loans by Partner</a></li>
                        <li><a href="{{url('loans-by-type')}}">Loans By Type</a></li>
                        <li><a href="{{url('sales-admin-report')}}">Sales Admin</a></li>
                        <li><a href="{{url('sales-performance')}}">Sales Agent Type</a></li>
                        <li><a href="{{url('all-loans-report')}}">All Loans</a></li>
                        <li><a href="{{url('monthly-repayments')}}">Monthly Repayments</a></li>
                        <li><a href="{{url('kyc-reg-report')}}">Registered Clients</a></li>
                        <li><a href="{{url('call-centre-weekly')}}">Call Centre Weekly</a></li>
                        <li><a href="{{url('calls-report')}}">Outgoing Sales Calls</a></li>
                        <li><a href="{{url('leads-converted-report')}}">Converted Leads </a></li>
                        <li><a href="{{url('leads-performance')}}">Leads Performance </a></li>
                        <li><a href="{{url('current-month-summary')}}">Current Month Loans </a></li>
                        <li><a href="{{url('monthly-year-summary')}}">Monthly Year Summary</a></li>
                        <li><a href="{{url('executive-summary')}}">Executive Summary</a></li>
                        <li><a href="{{url('zimbabwe-commissions-report')}}">Revenue</a></li>

                        <!--<li><a href="{{url('zambia-disbursed-report')}}">Zambia Disbursed Loans</a></li>
                        <li><a href="{{url('zambia-disbursed-devices')}}">Zambia Disbursed Devices</a></li>
                        <li><a href="{{url('zambia-processing-loans-report')}}">Zambia Processing Loans</a></li>-->
                        <li><a href="{{url('all-zambia-loans-report')}}">All Zambia Loans</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Users</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('clients')}}">All Clients</a></li>
                        <li><a href="{{url('light-registrations')}}">Quick Registrations</a></li>
                        <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                        <li><a href="{{url('limits')}}">Client Credit Limits</a></li>
                        <li><a href="{{url('resend-otp')}}">Resend Client OTP</a></li>
                        <li><a href="{{url('clients/deleted')}}">Deleted Clients</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <!--<li><a href="{{url('zambians')}}">Clients</a></li>-->
                        <!--<li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                        <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>-->
                        <li><a href="{{url('zaleads')}}">Leads</a></li>
                        <li><a href="{{url('zaleads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('import-zambia-lead')}}">Import Leads</a></li>
                        <!--<li><a href="{{url('/zam-pending-kycs')}}"> Zambia Pending </a></li>
                        <li><a href="{{url('/zam-pending-auth-kycs')}}"> Zam Pending Authorization</a></li>
                        <li><a href="{{url('/zam-approved-kycs')}}"> Zambia Approved </a></li>
                        <li><a href="{{url('/savings-accounts')}}"> Savings Accounts </a></li>
                        <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                        <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                        <li><a href="{{url('zambians/deleted')}}">Deleted Clients</a></li>-->
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-shield-account"></i></div>
                        <span>Partners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('agents')}}">Agents</a></li>
                        <li><a href="{{url('merchants')}}">Merchants</a></li>
                        <li><a href="{{url('partners')}}">All Partners</a></li>
                        <li><a href="{{url('partners/deleted')}}">Deleted Partner</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-cash"></i></div>
                        <span>Funders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('funders')}}">Funders</a></li>
                        <li><a href="{{url('funders/create')}}">Add Funder</a></li>
                        <li><a href="{{url('funders/deleted')}}">Deleted Funders</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class=" mdi mdi-account-network"></i></div>
                        <span>Employers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('employers')}}">Employers</a></li>
                        <li><a href="{{url('employers/create')}}">Add Employer</a></li>
                        <li><a href="{{url('employers/deleted')}}">Deleted Employers</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-multiple-outline"></i></div>
                        <span>Representatives</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('representatives')}}">Representatives</a></li>
                        <li><a href="{{url('representatives/create')}}">Add Representative</a></li>
                        <li><a href="{{url('representative-import')}}">Bulk Import Sales Reps</a></li>
                        <li><a href="{{url('representatives/deleted')}}">Deleted Representatives</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-tie-outline"></i></div>
                        <span>Astrogents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/astrogents')}}">Astrogents</a></li>
                        <li><a href="{{url('/manage-astrogents')}}">Manage Astrogents</a></li>
                        <li><a href="{{url('/astrogents/deleted')}}">Deleted Astrogents</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle"></i></div>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/users')}}">Users</a></li>
                        <li><a href="{{url('/users/create')}}">Add User</a></li>
                        <li><a href="{{url('/users/deleted')}}">Deleted Users</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">System Entities</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-earth"></i></div>
                        <span>Locales</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('localels')}}">Locales</a></li>
                        <li><a href="{{url('localels/create')}}">Add Locale</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-map-marker-radius"></i></div>
                        <span>Provinces</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('provinces')}}">Provinces</a></li>
                        <li><a href="{{url('provinces/create')}}">Add Province</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package-variant"></i></div>
                        <span>Masters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">Material Groups</a></li>
                        <li><a href="{{url('categories')}}">Categories</a></li>
                        <li><a href="#">Sub Categories</a></li>
                        <li><a href="#">Bramds</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package-variant"></i></div>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('products')}}">Products</a></li>
                        <li><a href="{{url('products/create')}}">Add Product</a></li>
                        <li><a href="{{url('upload-bulk-products')}}">Add Bulk Products</a></li>
                        <li><a href="{{url('our-products')}}">Products List</a></li>
                        <li><a href="{{url('products/deleted')}}">Deleted Product</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-bank"></i></div>
                        <span>Banks</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('banks')}}">Banks</a></li>
                        <li><a href="{{url('banks/create')}}">Add Bank</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-source-branch"></i></div>
                        <span>Bank Branches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('branches')}}">Branches</a></li>
                        <li><a href="{{url('branches/create')}}">Add Branch</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-percent"></i></div>
                        <span>Interest Rates</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/charges/create')}}">Add New Charge</a></li>
                        <li><a href="{{url('/charges')}}">Additional Charges</a></li>
                        <li><a href="{{url('/periods')}}">Payment Period</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-email"></i></div>
                        <span>Mailing Lists</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/mailings/create')}}">New Mailing List</a></li>
                        <li><a href="{{url('/mailings')}}">Mailing Lists</a></li>
                        <li><a href="{{url('/mailings/deleted')}}">Deleted Lists</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">System Settings</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-supervisor"></i></div>
                        <span>Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="dropdown-item {{ (Request::is('settings') ) ? 'active' : null }}" href="{{url('/settings')}}">
                                Settings
                            </a>
                        </li>
                        <!--<li><a class="dropdown-item {{ (Request::is('check-redsphere-server') ) ? 'active' : null }}" href="{{url('/check-redsphere-server')}}">
                                Check RedSphere Server
                            </a>
                        </li>-->
                        {{--<li><a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="{{ route('laravelroles::roles.index') }}">
                                {!! trans('titles.laravelroles') !!}
                            </a>
                        </li>--}}
                        <li><a class="dropdown-item {{ Request::is('logs') ? 'active' : null }}" href="{{ url('/logs') }}">
                                {!! trans('titles.adminLogs') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('activity') ? 'active' : null }}" href="{{ url('/activity') }}">
                                {!! trans('titles.adminActivity') !!}
                            </a></li>
                        <!--<li><a class="dropdown-item {{ Request::is('phpinfo') ? 'active' : null }}" href="{{ url('/phpinfo') }}">
                                {!! trans('titles.adminPHP') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('routes') ? 'active' : null }}" href="{{ url('/routes') }}">
                                {!! trans('titles.adminRoutes') !!}
                            </a></li>-->
                        <li><a class="dropdown-item {{ Request::is('active-users') ? 'active' : null }}" href="{{ url('/active-users') }}">
                                {!! trans('titles.activeUsers') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('blocker') ? 'active' : null }}" href="{{ route('laravelblocker::blocker.index') }}">
                                {!! trans('titles.laravelBlocker') !!}
                            </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-email-search"></i></div>
                        <span>Emails</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="dropdown-item {{ Request::is('maillogs') ? 'active' : null }}" href="{{ url('/maillogs') }}">
                                Email Logs
                            </a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('admin')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/loan-amortization')}}">Amortization Schedule</a></li>
                        <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>-->
                        <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                        <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                        <!--<li><a href="{{url('/ndasenda-processing-loans')}}">Ndasenda Processing</a></li>-->
                        <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                        <li><a href="{{url('/pending-disbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                        <!--<li><a href="{{url('/disbursed-loans-template')}}">Email Disbursed </a></li>-->
                        <li><a href="{{url('/declined-loans')}}">Declined Loans</a></li>
                        <!--<li><a href="{{url('/cleared-loans')}}">Cleared Loans</a></li>-->
                        <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                        <!--<li><a href="{{url('/loans-to-settle')}}">Settle Loans</a></li>-->
                        <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                        <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>
                        <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                        <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                        <li><a href="{{url('/loans')}}">All Loans</a></li>
                        <li><a href="{{url('/loans/deleted')}}">Deleted Loans</a></li>
                        <li><a href="{{url('/pending-disbursement')}}">Pending Disbursement</a></li>

                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>USD Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                        <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                        <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                        <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                        <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                        <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                        <li><a href="{{url('/usd-loans')}}">All Loans</a></li>
                    </ul>
                </li> --}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>Zambia Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/zam-loan-calculator')}}">Zambia Loan Calculator</a></li>
                        <li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                        <li><a href="{{url('/new-zambia-loans')}}">Open Loans</a></li>
                        <li><a href="{{url('/zambia-pending-loans')}}">Pending Loans</a></li>
                        <li><a href="{{url('/zambia-authorized')}}">Authorized </a></li>
                        <li><a href="{{url('/zambia-disbursed')}}">Disbursed </a></li>
                        <li><a href="{{url('/zambia-declined')}}">Declined Loans</a></li>
                        <li><a href="{{url('/zam-enroll-paytrigger')}}">Enroll To PayTrigger</a></li>
                        <li><a href="{{url('/enrolled-paytrigger')}}">Enrolled on PayTrigger</a></li>
                        <li><a href="{{url('/zambia-loans')}}">All Loans</a></li>
                        <li><a href="{{url('/zambia-loans/deleted')}}">Deleted Loans</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-android"></i></div>
                        <span>Device Financing</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                        <li><a href="{{url('/new-deviceloans')}}">New Loans</a></li>
                        <li><a href="{{url('/kyc-check-deviceloans')}}">Loans Under KYC</a></li>
                        <li><a href="{{url('/initialize-loan-disk')}}">Post to LoanDisk</a></li>
                        <li><a href="{{url('/to-enroll-paytrigger')}}">Enroll To PayTrigger</a></li>
                        <li><a href="{{url('/enrolled-paytrigger')}}">Enrolled on PayTrigger</a></li>
                        <li><a href="{{url('/device-loans')}}">All Device Loans</a></li>
                        <li><a href="{{url('/device-loans/deleted')}}">Deleted Loans</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-lock"></i></div>
                        <span>PayTrigger</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/opt-to-removelock')}}">Remove Lock</a></li>

                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/loan-requests')}}">Loan Requests</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                        <li><a href="{{url('/manage-loan-requests')}}">Manage Loan Requests</a></li>
                        <li><a href="{{url('/loan-requests/deleted')}}">Deleted Loan Requests</a></li>
                    </ul>
                </li>-->

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/eloan-amortization')}}">Amortization Schedule</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/new-eloans')}}">New eLoans</a></li>
                        <li><a href="{{url('/pending-eloans')}}">Pending eLoans</a></li>
                        <li><a href="{{url('/authorized-eloans')}}">Authorized eLoans</a></li>
                        <li><a href="{{url('/pending-edisbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-eloans')}}">Disbursed </a></li>
                        <li><a href="{{url('/declined-eloans')}}">Declined eLoans</a></li>
                        <li><a href="{{url('/cleared-eloans')}}">Cleared eLoans</a></li>
                        <li><a href="{{url('/eloan-records')}}">eLoan Records</a></li>
                        <li><a href="{{url('/eloans-to-settle')}}">Settle Loans</a></li>
                        <li><a href="{{url('/eloans')}}">All eLoans</a></li>
                        <li><a href="{{url('/eloans/deleted')}}">Deleted eLoans</a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-anchor"></i></div>
                        <span>Old Mutual</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/old-mutual-loans')}}">Old Mutual Loans</a></li>
                        <li><a href="{{url('/mutual-clients')}}">Old Mutual Clients</a></li>
                        <li><a href="{{url('/single-client-info')}}">Verify Client Info</a></li>
                        <li><a href="{{url('/start-musoni-loan')}}">Apply For Loan</a></li>

                    </ul>
                </li>-->

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="dripicons-jewel"></i></div>
                        <span>ZWMB</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/unclaimed-kycs')}}">Process KYC</a></li>
                        <li><a href="{{url('/get-reviewed-zwmb')}}">KYC to Authorize</a></li>
                        <li><a href="{{url('/zwmbs')}}">ZWMB Clients</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
                        <li><a href="{{url('/pending-device-kyc')}}"> Pending Device KYCs </a></li>
                        <li><a href="{{url('/authorize-device-kyc')}}"> Authorize Device KYCs </a></li>
                        <li><a href="{{url('/bot-pending-info')}}"> Bot Pending KYCs </a></li>
                        <li><a href="{{url('/pending-partner-kyc')}}"> Partner Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/merchant-kycs')}}">Merchant KYCs </a></li>
                        <li><a href="{{url('/cbz-check')}}">KYC Verification</a></li>
                        <!--<li><a href="{{url('/cbz-pending-kycs')}}"> CBZ Review KYCs </a></li>
                        <li><a href="{{url('/fcb-update')}}">FCB Pending Clients </a></li>
                        <li><a href="{{url('/fcb-recheck')}}">FCB Recheck </a></li>
                        <li><a href="{{url('/fcb-responses')}}">FCB Responses </a></li>-->
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                        <li><a href="{{url('/kycchanges/deleted')}}"> Deleted Requests </a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-robot"></i></div>
                        <span>Bot Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bot-applications')}}">All Applications</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Offer Letters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/current-offer-letters')}}">Current Offer Letters</a></li>
                        <li><a href="{{url('/offer-letters')}}">All Offer Letters</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-database"></i></div>
                        <span>Ndasenda Batches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-batches')}}">Pending Batches</a></li>
                        <li><a href="{{url('/upload-loans-batch')}}">Upload Loans</a></li>
                        <li><a href="{{url('/committed-batches')}}">Committed Batches</a></li>
                        <li><a href="{{url('/processed-batches')}}">Processed Batches</a></li>
                        <li><a href="{{url('/batches')}}">All Batches</a></li>
                        <li><a href="{{url('/ndaseresponses')}}">Ndasenda Responses</a></li>
                        <li><a href="{{url('/batches/deleted')}}">Deleted Batches</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('leads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('sms-leads-list')}}">SMS Leads</a></li>
                        <li><a href="{{url('allocate-leads')}}">Distribute Leads</a></li>
                        <li><a href="{{url('manage-leads')}}">Manage Leads</a></li>
                        <li><a href="{{url('leads-import')}}">Import Leads</a></li>
                        <li><a href="{{url('leads')}}">Leads</a></li>
                        <li><a href="{{url('leads/deleted')}}">Deleted Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls')}}">Calls</a></li>
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('my-calls')}}">My Calls</a></li>
                        <li><a href="{{url('calls/deleted')}}">Deleted Calls</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                        <li><a href="{{url('manage-queries')}}">Manage Queries</a></li>
                        <li><a href="{{url('queries/deleted')}}">Deleted Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Loans Accounting</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-bank"></i></div>
                        <span>Bank Accounts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bank-accounts/create')}}">New Account</a></li>
                        <li><a href="{{url('/bank-accounts')}}">All Accounts</a></li>
                        <li><a href="{{url('/bank-accounts/deleted')}}">Deleted Accounts</a></li>
                    </ul>
                </li>

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cash-usd-outline"></i></div>
                        <span>eDisbursements</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/process-edisbursements')}}">Process eDisbursements</a></li>
                        <li><a href="{{url('/current-edisbursements')}}">Current eDisbursements</a></li>
                        <li><a href="{{url('/edisbursements')}}">All eDisbursements</a></li>
                        <li><a href="{{url('/edisbursements/deleted')}}">Deleted eDisbursements</a></li>
                    </ul>
                </li>--}}

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-clipboard-text"></i></div>
                        <span>Ledgers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/ledgers/create')}}">New Ledger</a></li>
                        <li><a href="{{url('/ledgers')}}">All Ledgers</a></li>
                        <li><a href="{{url('/ledgers/deleted')}}">Deleted Ledgers</a></li>
                    </ul>
                </li>--}}

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-star-outline"></i></div>
                        <span>Borrowers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/borrowers/create')}}">New Borrower</a></li>
                        <li><a href="{{url('/borrowers')}}">All Borrowers</a></li>
                        <li><a href="{{url('/borrowers/deleted')}}">Deleted Borrowers</a></li>
                    </ul>
                </li>--}}

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-crown-outline"></i></div>
                        <span>eAccounts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/accounts/create')}}">New Account</a></li>
                        <li><a href="{{url('/accounts')}}">All Accounts</a></li>
                        <li><a href="{{url('/eshagi-account')}}">eShagi Account</a></li>
                        <li><a href="{{url('/accounts/deleted')}}">Deleted Accounts</a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/repayments/create')}}">New Repayment</a></li>
                        <li><a href="{{url('/current-repayments')}}">Current Repayments</a></li>
                        <li><a href="{{url('/repayments')}}">All Repayments</a></li>
                        <li><a href="{{url('/repayments/deleted')}}">Deleted Repayments</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span>Payments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/payments/create')}}">New Payment</a></li>
                        <li><a href="{{url('/payments')}}">All Payments</a></li>
                        <li><a href="{{url('/zambia-payments/create')}}">New Zambia Payment</a></li>
                        <li><a href="{{url('/zambia-payments')}}">All Zambia Payments</a></li>
                        <li><a href="{{url('/zambia-bulk-payments')}}">Import Bulk Repayments</a></li>
                        <li><a href="{{url('/payments/deleted')}}">Deleted Payments</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package"></i></div>
                        <span>Arrears</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('arrears')}}">All Arrears</a></li>
                        <li><a href="{{url('communicate-arrears')}}">Communication</a></li>
                        <li><a href="{{url('')}}">Settle Arrears</a></li>
                        <li><a href="{{url('')}}">Demand Letter Templates</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Commissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('commissions/create')}}">Add Commission</a></li>
                        <li><a href="{{url('unpaid-commissions')}}">Unpaid</a></li>
                        <li><a href="{{url('paid-commissions')}}">Paid</a></li>
                        <li><a href="{{url('pay-commissions')}}">Register Payments</a></li>
                        <li><a href="{{url('commissions')}}">Commissions</a></li>
                        <li><a href="{{url('commissions/deleted')}}">Deleted Commissions</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('disbursed-report')}}">Disbursed Loans</a></li>
                        <li><a href="{{url('disbursed-product')}}">Disbursed Devices</a></li>
                        <li><a href="{{url('pending-loans-report')}}">Pending Loans</a></li>
                        <li><a href="{{url('declined-report')}}">Declined Loans</a></li>
                        <li><a href="{{url('commissions-report')}}">Commissions</a></li>
                        <li><a href="{{url('loans-by-report')}}">Loans by Partner</a></li>
                        <li><a href="{{url('loans-by-type')}}">Loans By Type</a></li>
                        <li><a href="{{url('sales-admin-report')}}">Sales Admin</a></li>
                        <li><a href="{{url('sales-performance')}}">Sales Agent Type</a></li>
                        <li><a href="{{url('all-loans-report')}}">All Loans</a></li>
                        <li><a href="{{url('monthly-repayments')}}">Monthly Repayments</a></li>
                        <li><a href="{{url('kyc-reg-report')}}">Registered Clients</a></li>
                        <li><a href="{{url('call-centre-weekly')}}">Call Centre Weekly</a></li>
                        <li><a href="{{url('calls-report')}}">Outgoing Sales Calls</a></li>
                        <li><a href="{{url('leads-converted-report')}}">Converted Leads </a></li>
                        <li><a href="{{url('leads-performance')}}">Leads Performance </a></li>
                        <li><a href="{{url('current-month-summary')}}">Current Month Loans </a></li>
                        <li><a href="{{url('monthly-year-summary')}}">Monthly Year Summary</a></li>
                        <li><a href="{{url('executive-summary')}}">Executive Summary</a></li>
                        <li><a href="{{url('zimbabwe-commissions-report')}}">Revenue</a></li>
                        <!--<li><a href="{{url('zambia-disbursed-report')}}">Zambia Disbursed Loans</a></li>
                        <li><a href="{{url('zambia-disbursed-devices')}}">Zambia Disbursed Devices</a></li>
                        <li><a href="{{url('zambia-processing-loans-report')}}">Zambia Processing Loans</a></li>-->
                        <li><a href="{{url('all-zambia-loans-report')}}">All Zambia Loans</a></li>
                    </ul>
                </li>


                <li class="menu-title text-info">Users</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('clients')}}">All Clients</a></li>
                        <li><a href="{{url('light-registrations')}}">Quick Registrations</a></li>
                        <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                        <li><a href="{{url('limits')}}">Client Credit Limits</a></li>
                        <li><a href="{{url('resend-otp')}}">Resend Client OTP</a></li>
                        <li><a href="{{url('clients/deleted')}}">Deleted Clients</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <!--<li><a href="{{url('zambians')}}">Clients</a></li>
                        <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                        <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>-->
                        <li><a href="{{url('zaleads')}}">Zambia Leads</a></li>
                        <li><a href="{{url('zaleads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('import-zambia-lead')}}">Import Leads</a></li>
                        <!--<li><a href="{{url('/zam-pending-kycs')}}"> Zambia Pending </a></li>
                        <li><a href="{{url('/zam-pending-auth-kycs')}}"> Zam Pending Authorization</a></li>
                        <li><a href="{{url('/zam-approved-kycs')}}"> Zambia Approved </a></li>
                        <li><a href="{{url('/savings-accounts')}}"> Savings Accounts </a></li>
                        <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                        <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                        <li><a href="{{url('zambians/deleted')}}">Deleted Clients</a></li>-->
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-shield-account"></i></div>
                        <span>Partners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('agents')}}">Agents</a></li>
                        <li><a href="{{url('merchants')}}">Merchants</a></li>
                        <li><a href="{{url('partners')}}">All Partners</a></li>
                        <li><a href="{{url('partners/deleted')}}">Deleted Partner</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-cash"></i></div>
                        <span>Funders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('funders')}}">Funders</a></li>
                        <li><a href="{{url('funders/create')}}">Add Funder</a></li>
                        <li><a href="{{url('funders/deleted')}}">Deleted Funders</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class=" mdi mdi-account-network"></i></div>
                        <span>Employers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('employers')}}">Employers</a></li>
                        <li><a href="{{url('employers/create')}}">Add Employer</a></li>
                        <li><a href="{{url('employers/deleted')}}">Deleted Employers</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-multiple-outline"></i></div>
                        <span>Representatives</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('representatives')}}">Representatives</a></li>
                        <li><a href="{{url('representatives/create')}}">Add Representative</a></li>
                        <li><a href="{{url('representative-import')}}">Bulk Import Sales Reps</a></li>
                        <li><a href="{{url('representatives/deleted')}}">Deleted Representatives</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-tie-outline"></i></div>
                        <span>Astrogents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/astrogents')}}">Astrogents</a></li>
                        <li><a href="{{url('/manage-astrogents')}}">Manage Astrogents</a></li>
                        <li><a href="{{url('/astrogents/deleted')}}">Deleted Astrogents</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle"></i></div>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/users')}}">Users</a></li>
                        <li><a href="{{url('/users/create')}}">Add User</a></li>
                        <li><a href="{{url('/users/deleted')}}">Deleted Users</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">System Entities</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-earth"></i></div>
                        <span>Locales</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('localels')}}">Locales</a></li>
                        <li><a href="{{url('localels/create')}}">Add Locale</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-map-marker-radius"></i></div>
                        <span>Provinces</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('provinces')}}">Provinces</a></li>
                        <li><a href="{{url('provinces/create')}}">Add Province</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package-variant"></i></div>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('products')}}">Products</a></li>
                        <li><a href="{{url('products/create')}}">Add Product</a></li>
                        <li><a href="{{url('upload-bulk-products')}}">Add Bulk Products</a></li>
                        <li><a href="{{url('our-products')}}">Our Products</a></li>
                        <li><a href="{{url('products/deleted')}}">Deleted Product</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-bank"></i></div>
                        <span>Banks</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('banks')}}">Banks</a></li>
                        <li><a href="{{url('banks/create')}}">Add Bank</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-source-branch"></i></div>
                        <span>Bank Branches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('branches')}}">Branches</a></li>
                        <li><a href="{{url('branches/create')}}">Add Branch</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-percent"></i></div>
                        <span>Interest Rates</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/charges/create')}}">Add New Charge</a></li>
                        <li><a href="{{url('/charges')}}">Additional Charges</a></li>
                        <li><a href="{{url('/periods')}}">Payment Period</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-email"></i></div>
                        <span>Mailing Lists</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/mailings/create')}}">New Mailing List</a></li>
                        <li><a href="{{url('/mailings')}}">Mailing Lists</a></li>
                        <li><a href="{{url('/mailings/deleted')}}">Deleted Lists</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">System Settings</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-supervisor"></i></div>
                        <span>Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="dropdown-item {{ (Request::is('settings') ) ? 'active' : null }}" href="{{url('/settings')}}">
                                Settings
                            </a>
                        </li>
                        <!--<li><a class="dropdown-item {{ (Request::is('check-redsphere-server') ) ? 'active' : null }}" href="{{url('/check-redsphere-server')}}">
                                Check RedSphere Server
                            </a>
                        </li>-->
                        {{--<li><a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="{{ route('laravelroles::roles.index') }}">
                                {!! trans('titles.laravelroles') !!}
                            </a>
                        </li>--}}
                        <li><a class="dropdown-item {{ Request::is('logs') ? 'active' : null }}" href="{{ url('/logs') }}">
                                {!! trans('titles.adminLogs') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('activity') ? 'active' : null }}" href="{{ url('/activity') }}">
                                {!! trans('titles.adminActivity') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('phpinfo') ? 'active' : null }}" href="{{ url('/phpinfo') }}">
                                {!! trans('titles.adminPHP') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('routes') ? 'active' : null }}" href="{{ url('/routes') }}">
                                {!! trans('titles.adminRoutes') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('active-users') ? 'active' : null }}" href="{{ url('/active-users') }}">
                                {!! trans('titles.activeUsers') !!}
                            </a></li>
                        <li><a class="dropdown-item {{ Request::is('blocker') ? 'active' : null }}" href="{{ route('laravelblocker::blocker.index') }}">
                                {!! trans('titles.laravelBlocker') !!}
                            </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-email-search"></i></div>
                        <span>Emails</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="dropdown-item {{ Request::is('maillogs') ? 'active' : null }}" href="{{ url('/maillogs') }}">
                                Email Logs
                            </a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('group')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/loan-amortization')}}">Amortization Schedule</a></li>
                        <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>-->
                        <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                        <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                        <!--<li><a href="{{url('/ndasenda-processing-loans')}}">Ndasenda Processing</a></li>-->
                        <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                        <li><a href="{{url('/pending-disbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                        <!--<li><a href="{{url('/disbursed-loans-template')}}">Email Disbursed </a></li>-->
                        <li><a href="{{url('/declined-loans')}}">Declined Loans</a></li>
                        <!--<li><a href="{{url('/cleared-loans')}}">Cleared Loans</a></li>-->
                        <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                        <!--<li><a href="{{url('/loans-to-settle')}}">Settle Loans</a></li>-->
                        <li><a href="{{url('/zambia-pending-loans')}}">Zambia Pending</a></li>
                        <li><a href="{{url('/zambia-authorized')}}">Zambia Authorized</a></li>
                        <li><a href="{{url('/zambia-disbursed')}}">Zambia Disbursed </a></li>
                        <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                        <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>
                        <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                        <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                        <li><a href="{{url('/loans')}}">All Loans</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>USD Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                        <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                        <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                        <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                        <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                        <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                        <li><a href="{{url('/usd-loans')}}">All Loans</a></li>
                    </ul>
                </li> --}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/loan-requests')}}">Loan Requests</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                        <li><a href="{{url('/manage-loan-requests')}}">Manage Loan Requests</a></li>
                    </ul>
                </li>-->

               {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/eloan-amortization')}}">Amortization Schedule</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/new-eloans')}}">New eLoans</a></li>
                        <li><a href="{{url('/pending-eloans')}}">Pending eLoans</a></li>
                        <li><a href="{{url('/authorized-eloans')}}">Authorized eLoans</a></li>
                        <li><a href="{{url('/pending-edisbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-eloans')}}">Disbursed </a></li>
                        <li><a href="{{url('/declined-eloans')}}">Declined eLoans</a></li>
                        <li><a href="{{url('/cleared-eloans')}}">Cleared eLoans</a></li>
                        <li><a href="{{url('/eloan-records')}}">eLoan Records</a></li>
                        <li><a href="{{url('/eloans-to-settle')}}">Settle Loans</a></li>
                        <li><a href="{{url('/eloans')}}">All eLoans</a></li>
                        <li><a href="{{url('/eloans/deleted')}}">Deleted eLoans</a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-anchor"></i></div>
                        <span>Old Mutual</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/old-mutual-loans')}}">Old Mutual Loans</a></li>
                        <li><a href="{{url('/mutual-clients')}}">Old Mutual Clients</a></li>
                        <li><a href="{{url('/single-client-info')}}">Verify Client Info</a></li>
                        <li><a href="{{url('/start-musoni-loan')}}">Apply For Loan</a></li>

                    </ul>
                </li>-->

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="dripicons-jewel"></i></div>
                        <span>ZWMB</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/unclaimed-kycs')}}">Process KYC</a></li>
                        <li><a href="{{url('/get-reviewed-zwmb')}}">KYC to Authorize</a></li>
                        <li><a href="{{url('/zwmbs')}}">ZWMB Clients</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
{{--                        <li><a href="{{url('/pending-eloans-kyc')}}"> Pending eLoans KYCs </a></li>--}}
                        <li><a href="{{url('/bot-pending-info')}}"> Bot Pending KYCs </a></li>
                        <li><a href="{{url('/pending-partner-kyc')}}"> Partner Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/merchant-kycs')}}">Merchant KYCs </a></li>
                        <li><a href="{{url('/cbz-check')}}">KYC Verification</a></li>
                        <!--<li><a href="{{url('/cbz-pending-kycs')}}"> CBZ Review KYCs </a></li>
                        <li><a href="{{url('/fcb-update')}}">FCB Pending Clients </a></li>
                        <li><a href="{{url('/fcb-recheck')}}">FCB Recheck </a></li>
                        <li><a href="{{url('/fcb-responses')}}">FCB Responses </a></li>-->
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                    </ul>
                </li>--}}


                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-robot"></i></div>
                        <span>Bot Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bot-applications')}}">All Applications</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Offer Letters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/current-offer-letters')}}">Current Offer Letters</a></li>
                        <li><a href="{{url('/offer-letters')}}">All Offer Letters</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-database"></i></div>
                        <span>Ndasenda Batches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-batches')}}">Pending Batches</a></li>
                        <li><a href="{{url('/upload-loans-batch')}}">Upload Loans</a></li>
                        <li><a href="{{url('/committed-batches')}}">Committed Batches</a></li>
                        <li><a href="{{url('/processed-batches')}}">Processed Batches</a></li>
                        <li><a href="{{url('/batches')}}">All Batches</a></li>
                        <li><a href="{{url('/ndaseresponses')}}">Ndasenda Responses</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('leads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('sms-leads-list')}}">SMS Leads</a></li>
                        <li><a href="{{url('allocate-leads')}}">Distribute Leads</a></li>
                        <li><a href="{{url('manage-leads')}}">Manage Leads</a></li>
                        <li><a href="{{url('leads-import')}}">Import Leads</a></li>
                        <li><a href="{{url('leads')}}">Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls')}}">Calls</a></li>
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('my-calls')}}">My Calls</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                        <li><a href="{{url('manage-queries')}}">Manage Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Loans Accounting</li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/repayments/create')}}">New Repayment</a></li>
                        <li><a href="{{url('/current-repayments')}}">Current Repayments</a></li>
                        <li><a href="{{url('/repayments')}}">All Repayments</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package"></i></div>
                        <span>Accounting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('outstanding-loans')}}">Outstanding Loans</a></li>
                        <li><a href="{{url('payouts')}}">Payouts</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Commissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('commissions/create')}}">Add Commission</a></li>
                        <li><a href="{{url('unpaid-commissions')}}">Unpaid</a></li>
                        <li><a href="{{url('paid-commissions')}}">Paid</a></li>
                        <li><a href="{{url('pay-commissions')}}">Register Payments</a></li>
                        <li><a href="{{url('commissions')}}">Commissions</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('disbursed-report')}}">Disbursed Loans</a></li>
                        <li><a href="{{url('disbursed-product')}}">Disbursed Devices</a></li>
                        <li><a href="{{url('pending-loans-report')}}">Pending Loans</a></li>
                        <li><a href="{{url('declined-report')}}">Declined Loans</a></li>
                        <li><a href="{{url('commissions-report')}}">Commissions</a></li>
                        <li><a href="{{url('loans-by-report')}}">Loans by Partner</a></li>
                        <li><a href="{{url('loans-by-type')}}">Loans By Type</a></li>
                        <li><a href="{{url('sales-admin-report')}}">Sales Admin</a></li>
                        <li><a href="{{url('sales-performance')}}">Sales Agent Type</a></li>
                        <li><a href="{{url('all-loans-report')}}">All Loans</a></li>
                        <li><a href="{{url('monthly-repayments')}}">Monthly Repayments</a></li>
                        <li><a href="{{url('kyc-reg-report')}}">Registered Clients</a></li>
                        <li><a href="{{url('call-centre-weekly')}}">Call Centre Weekly</a></li>
                        <li><a href="{{url('calls-report')}}">Outgoing Sales Calls</a></li>
                        <li><a href="{{url('leads-converted-report')}}">Converted Leads </a></li>
                        <li><a href="{{url('leads-performance')}}">Leads Performance </a></li>
                        <li><a href="{{url('current-month-summary')}}">Current Month Loans </a></li>
                        <li><a href="{{url('monthly-year-summary')}}">Monthly Year Summary</a></li>
                        <li><a href="{{url('executive-summary')}}">Executive Summary</a></li>

                        <!--<li><a href="{{url('zambia-disbursed-report')}}">Zambia Disbursed Loans</a></li>
                        <li><a href="{{url('zambia-disbursed-devices')}}">Zambia Disbursed Devices</a></li>
                        <li><a href="{{url('zambia-processing-loans-report')}}">Zambia Processing Loans</a></li>-->
                        <li><a href="{{url('all-zambia-loans-report')}}">All Zambia Loans</a></li>
                    </ul>
                </li>


                <li class="menu-title text-info">Users</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('clients')}}">All Clients</a></li>
                        <li><a href="{{url('light-registrations')}}">Quick Registrations</a></li>
                        <li><a href="{{url('register-pclient')}}">Add Client</a></li>
                        <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                        <li><a href="{{url('limits')}}">Client Credit Limits</a></li>
                        <li><a href="{{url('resend-otp')}}">Resend Client OTP</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-shield-account"></i></div>
                        <span>Partners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('agents')}}">Agents</a></li>
                        <li><a href="{{url('merchants')}}">Merchants</a></li>
                        <li><a href="{{url('partners')}}">All Partners</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-cash"></i></div>
                        <span>Funders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('funders')}}">Funders</a></li>
                        <li><a href="{{url('funders/create')}}">Add Funder</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-multiple-outline"></i></div>
                        <span>Representatives</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('representatives')}}">Representatives</a></li>
                        <li><a href="{{url('representatives/create')}}">Add Representative</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-tie-outline"></i></div>
                        <span>Astrogents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/astrogents')}}">Astrogents</a></li>
                        <li><a href="{{url('/manage-astrogents')}}">Manage Astrogents</a></li>
                        <li><a href="{{url('/astrogents/deleted')}}">Deleted Astrogents</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle"></i></div>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/users')}}">Users</a></li>
                        <li><a href="{{url('/users/create')}}">Add User</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">System Entities</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-earth"></i></div>
                        <span>Locales</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('localels')}}">Locales</a></li>
                        <li><a href="{{url('localels/create')}}">Add Locale</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-map-marker-radius"></i></div>
                        <span>Provinces</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('provinces')}}">Provinces</a></li>
                        <li><a href="{{url('provinces/create')}}">Add Province</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package-variant"></i></div>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('products')}}">Products</a></li>
                        <li><a href="{{url('products/create')}}">Add Product</a></li>
                        <li><a href="{{url('upload-bulk-products')}}">Add Bulk Products</a></li>
                        <li><a href="{{url('our-products')}}">Our Products</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-bank"></i></div>
                        <span>Banks</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('banks')}}">Banks</a></li>
                        <li><a href="{{url('banks/create')}}">Add Bank</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-source-branch"></i></div>
                        <span>Bank Branches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('branches')}}">Branches</a></li>
                        <li><a href="{{url('branches/create')}}">Add Branch</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-percent"></i></div>
                        <span>Interest Rates</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/charges/create')}}">Add New Charge</a></li>
                        <li><a href="{{url('/charges')}}">Additional Charges</a></li>
                        <li><a href="{{url('/periods')}}">Payment Period</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-email"></i></div>
                        <span>Mailing Lists</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/mailings/create')}}">New Mailing List</a></li>
                        <li><a href="{{url('/mailings')}}">Mailing Lists</a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('manager')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(auth()->user()->locale == '2')
                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>Zambia Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/zam-loan-calculator')}}">Zambia Loan Calculator</a></li>
                            <li><a href="{{url('/new-zambia-loans')}}">Open Loans</a></li>
                            <li><a href="{{url('/zambia-pending-loans')}}">Pending Loans</a></li>
                            <li><a href="{{url('/zambia-authorized')}}">Authorized </a></li>
                            <li><a href="{{url('/zambia-disbursed')}}">Disbursed </a></li>
                            <li><a href="{{url('/zambia-declined')}}">Declined Loans</a></li>
                            <li><a href="{{url('/zam-enroll-paytrigger')}}">Enroll To PayTrigger</a></li>
                            <li><a href="{{url('/enrolled-paytrigger')}}">Enrolled on PayTrigger</a></li>
                            <li><a href="{{url('/zambia-loans')}}">All Loans</a></li>
                        </ul>
                    </li>-->
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                            <span>Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                            <li><a href="{{url('/loan-amortization')}}">Amortization Schedule</a></li>
                            <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                            <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>-->
                            <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                            <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                            <!--<li><a href="{{url('/ndasenda-processing-loans')}}">Ndasenda Processing</a></li>-->
                            <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                            <li><a href="{{url('/pending-disbursement')}}">Awaiting Disbursement</a></li>
                            <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                            <!--<li><a href="{{url('/disbursed-loans-template')}}">Email Disbursed </a></li>-->
                            <li><a href="{{url('/declined-loans')}}">Declined Loans</a></li>
                            <!--<li><a href="{{url('/cleared-loans')}}">Cleared Loans</a></li>-->
                            <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                            <!--<li><a href="{{url('/loans-to-settle')}}">Settle Loans</a></li>-->
                            <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                            <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>
                            <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                            <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                            <li><a href="{{url('/loans')}}">All Loans</a></li>
                        </ul>
                    </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>USD Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                            <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                            <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                            <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                            <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                            <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                            <li><a href="{{url('/usd-loans')}}">All Loans</a></li>
                        </ul>
                    </li> --}}
                @endif

                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-android"></i></div>
                        <span>Device Financing</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/new-deviceloans')}}">New Loans</a></li>
                        <li><a href="{{url('/kyc-check-deviceloans')}}">Loans Under KYC</a></li>
                        <li><a href="{{url('/initialize-loan-disk')}}">Post to LoanDisk</a></li>
                        <li><a href="{{url('/to-enroll-paytrigger')}}">Enroll To PayTrigger</a></li>
                        <li><a href="{{url('/enrolled-paytrigger')}}">Enrolled on PayTrigger</a></li>
                        <li><a href="{{url('/device-loans')}}">All Device Loans</a></li>
                    </ul>
                </li>


                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                        <li><a href="{{url('/manage-loan-requests')}}">Manage Loan Requests</a></li>
                    </ul>
                </li>-->

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/eloan-amortization')}}">Amortization Schedule</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/new-eloans')}}">New eLoans</a></li>
                        <li><a href="{{url('/pending-eloans')}}">Pending eLoans</a></li>
                        <li><a href="{{url('/authorized-eloans')}}">Authorized eLoans</a></li>
                        <li><a href="{{url('/pending-edisbursement')}}">Awaiting Disbursement</a></li>
                        <li><a href="{{url('/disbursed-eloans')}}">Disbursed </a></li>
                        <li><a href="{{url('/declined-eloans')}}">Declined eLoans</a></li>
                        <li><a href="{{url('/cleared-eloans')}}">Cleared eLoans</a></li>
                        <li><a href="{{url('/eloan-records')}}">eLoan Records</a></li>
                        <li><a href="{{url('/eloans-to-settle')}}">Settle Loans</a></li>
                        <li><a href="{{url('/eloans')}}">All eLoans</a></li>
                    </ul>
                </li>--}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-anchor"></i></div>
                        <span>Old Mutual</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/old-mutual-loans')}}">Old Mutual Loans</a></li>
                        <li><a href="{{url('/mutual-clients')}}">Old Mutual Clients</a></li>
                        <li><a href="{{url('/single-client-info')}}">Verify Client Info</a></li>

                    </ul>
                </li>-->

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="dripicons-jewel"></i></div>
                        <span>ZWMB</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/unclaimed-kycs')}}">Process KYC</a></li>
                        <li><a href="{{url('/get-reviewed-zwmb')}}">KYC to Authorize</a></li>
                        <li><a href="{{url('/zwmbs')}}">ZWMB Clients</a></li>
                    </ul>
                </li>-->


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
                        <li><a href="{{url('/bot-pending-info')}}"> Bot Pending KYCs </a></li>
                        <li><a href="{{url('/pending-partner-kyc')}}"> Partner Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/merchant-kycs')}}">Merchant KYCs </a></li>
                        <li><a href="{{url('/cbz-check')}}">KYC Verification</a></li>
                        <li><a href="{{url('/fcb-update')}}">FCB Pending Clients </a></li>
                        <li><a href="{{url('/fcb-recheck')}}">FCB Recheck </a></li>
                        <li><a href="{{url('/fcb-responses')}}">FCB Responses </a></li>
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                    </ul>
                </li>--}}
                @endif

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-robot"></i></div>
                        <span>Bot Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bot-applications')}}">All Applications</a></li>
                    </ul>
                </li>-->
                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Offer Letters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/current-offer-letters')}}">Current Offer Letters</a></li>
                        <li><a href="{{url('/offer-letters')}}">All Offer Letters</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-database"></i></div>
                        <span>Ndasenda Batches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-batches')}}">Pending Batches</a></li>
                        <li><a href="{{url('/upload-loans-batch')}}">Upload Loans</a></li>
                        <li><a href="{{url('/committed-batches')}}">Committed Batches</a></li>
                        <li><a href="{{url('/processed-batches')}}">Processed Batches</a></li>
                        <li><a href="{{url('/batches')}}">All Batches</a></li>
                        <li><a href="{{url('/ndaseresponses')}}">Ndasenda Responses</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('leads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('sms-leads-list')}}">SMS Leads</a></li>
                        <li><a href="{{url('allocate-leads')}}">Distribute Leads</a></li>
                        <li><a href="{{url('manage-leads')}}">Manage Leads</a></li>
                        <li><a href="{{url('leads-import')}}">Import Leads</a></li>
                        <li><a href="{{url('leads')}}">Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls')}}">Calls</a></li>
                    </ul>
                </li>
@endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                        <li><a href="{{url('manage-queries')}}">Manage Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Loans Accounting</li>
                @if(auth()->user()->locale == '1')
                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/repayments/create')}}">New Repayment</a></li>
                        <li><a href="{{url('/current-repayments')}}">Current Repayments</a></li>
                        <li><a href="{{url('/repayments')}}">All Repayments</a></li>
                    </ul>
                </li>-->
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span>Payments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(auth()->user()->locale == '2')
                            <li><a href="{{url('/zambia-payments/create')}}">New Zambia Payment</a></li>
                            <li><a href="{{url('/zambia-payments')}}">All Zambia Payments</a></li>
                        @else
                            <li><a href="{{url('/payments/create')}}">New Payment</a></li>
                            <li><a href="{{url('/payments')}}">All Payments</a></li>
                        @endif
                    </ul>
                </li>
                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Commissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('commissions/create')}}">Add Commission</a></li>
                        <li><a href="{{url('unpaid-commissions')}}">Unpaid</a></li>
                        <li><a href="{{url('paid-commissions')}}">Paid</a></li>
                        <li><a href="{{url('commissions')}}">Commissions</a></li>
                    </ul>
                </li>
@endif
                @if(auth()->user()->locale == '2')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                            <span>Reports</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <!--<li><a href="{{url('zambia-disbursed-report')}}">Zambia Disbursed Loans</a></li>
                            <li><a href="{{url('zambia-disbursed-devices')}}">Zambia Disbursed Devices</a></li>
                            <li><a href="{{url('zambia-processing-loans-report')}}">Zambia Processing Loans</a></li>-->
                            <li><a href="{{url('all-zambia-loans-report')}}">All Zambia Loans</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('disbursed-report')}}">Disbursed Loans</a></li>
                            <li><a href="{{url('disbursed-product')}}">Disbursed Devices</a></li>
                            <li><a href="{{url('declined-report')}}">Declined Loans</a></li>
                            <li><a href="{{url('commissions-report')}}">Commissions</a></li>
                            <li><a href="{{url('loans-by-report')}}">Loans by Partner</a></li>
                            <li><a href="{{url('loans-by-type')}}">Loans By Type</a></li>
                            <li><a href="{{url('sales-admin-report')}}">Sales Admin</a></li>
                            <li><a href="{{url('sales-performance')}}">Sales Agent Type</a></li>
                            <li><a href="{{url('all-loans-report')}}">All Loans</a></li>
                            <li><a href="{{url('kyc-reg-report')}}">Registered Clients</a></li>
                            <li><a href="{{url('call-centre-weekly')}}">Call Centre Weekly</a></li>
                            <li><a href="{{url('calls-report')}}">Outgoing Sales Calls</a></li>
                            <li><a href="{{url('leads-converted-report')}}">Converted Leads </a></li>
                            <li><a href="{{url('leads-performance')}}">Leads Performance </a></li>
                            <li><a href="{{url('current-month-summary')}}">Current Month Loans </a></li>
                            <li><a href="{{url('monthly-year-summary')}}">Monthly Year Summary</a></li>
                            <li><a href="{{url('executive-summary')}}">Executive Summary</a></li>
                            <li><a href="{{url('zimbabwe-commissions-report')}}">Revenue</a></li>
                        </ul>
                    </ul>
                </li>
                @endif
                <li class="menu-title text-info">Users</li>

                @if(auth()->user()->locale == '2')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                            <span>Leads</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <!--<li><a href="{{url('zambians')}}">Clients</a></li>
                            <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                            <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>-->
                            <li><a href="{{url('zaleads')}}">Zambia Leads</a></li>
                            <li><a href="{{url('zaleads/create')}}">Add Lead</a></li>
                            <li><a href="{{url('import-zambia-lead')}}">Import Leads</a></li>
                            <!--<li><a href="{{url('/zam-pending-kycs')}}"> Zambia Pending </a></li>
                            <li><a href="{{url('/zam-pending-auth-kycs')}}"> Zam Pending Authorization</a></li>
                            <li><a href="{{url('/zam-approved-kycs')}}"> Zambia Approved </a></li>
                            <li><a href="{{url('/savings-accounts')}}"> Savings Accounts </a></li>
                            <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                            <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>-->
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                            <span>Clients</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('clients')}}">All Clients</a></li>
                            <li><a href="{{url('light-registrations')}}">Quick Registrations</a></li>
                            <li><a href="{{url('limits')}}">Client Credit Limits</a></li>
                            <li><a href="{{url('resend-otp')}}">Resend Client OTP</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-shield-account"></i></div>
                            <span>Partners</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('agents')}}">Agents</a></li>
                            <li><a href="{{url('merchants')}}">Merchants</a></li>
                            <li><a href="{{url('partners')}}">All Partners</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-cash"></i></div>
                            <span>Funders</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('funders')}}">Funders</a></li>
                            <li><a href="{{url('funders/create')}}">Add Funder</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-tie-outline"></i></div>
                            <span>Astrogents</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/astrogents')}}">Astrogents</a></li>
                            <li><a href="{{url('/manage-astrogents')}}">Manage Astrogents</a></li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle"></i></div>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/users')}}">Users</a></li>
                        <li><a href="{{url('/users/create')}}">Add User</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">System Entities</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-bank"></i></div>
                        <span>Banks</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('banks')}}">Banks</a></li>
                        <li><a href="{{url('banks/create')}}">Add Bank</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-source-branch"></i></div>
                        <span>Bank Branches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('branches')}}">Branches</a></li>
                        <li><a href="{{url('branches/create')}}">Add Branch</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-percent"></i></div>
                        <span>Interest Rates</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/charges/create')}}">Add New Charge</a></li>
                        <li><a href="{{url('/charges')}}">Additional Charges</a></li>
                        <li><a href="{{url('/periods')}}">Payment Period</a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('loansofficer')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(auth()->user()->locale == '2')
                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>Zambia Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/zam-loan-calculator')}}">Zambia Loan Calculator</a></li>
                            <li><a href="{{url('/verify-loans')}}">Verify Loans</a></li>
                            <li><a href="{{url('/zambia-pending-loans')}}">Pending Loans</a></li>
                            <li><a href="{{url('/zambia-authorized')}}">Authorized </a></li>
                            <li><a href="{{url('/zambia-disbursed')}}">Disbursed </a></li>
                            <li><a href="{{url('/zambia-declined')}}">Declined </a></li>
                        </ul>
                    </li>-->
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                            <span>Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                            <li><a href="{{url('/loan-amortization')}}">Amortization Schedule</a></li>
                            <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                            <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>-->
                            <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                            <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                            <!--<li><a href="{{url('/ndasenda-processing-loans')}}">Ndasenda Processing</a></li>-->
                            <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                            <li><a href="{{url('/pending-disbursement')}}">Awaiting Disbursement</a></li>
                            <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                            <!--<li><a href="{{url('/disbursed-loans-template')}}">Email Disbursed </a></li>-->
                            <li><a href="{{url('/declined-loans')}}">Declined Loans</a></li>
                            <!--<li><a href="{{url('/cleared-loans')}}">Cleared Loans</a></li>-->
                            <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                            <!--<li><a href="{{url('/loans-to-settle')}}">Settle Loans</a></li>-->
                            <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                            <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>
                            <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                            <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                            <li><a href="{{url('/loans')}}">All Loans</a></li>
                        </ul>
                    </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>USD Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                            <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                            <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                            <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                            <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                            <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                            <li><a href="{{url('/usd-loans')}}">All Loans</a></li>
                        </ul>
                    </li> --}}

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-android"></i></div>
                            <span>Device Financing</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                            <li><a href="{{url('/new-deviceloans')}}">New Loans</a></li>
                            <li><a href="{{url('/kyc-check-deviceloans')}}">Loans Under KYC</a></li>
                            <li><a href="{{url('/initialize-loan-disk')}}">Post to LoanDisk</a></li>
                            <li><a href="{{url('/to-enroll-paytrigger')}}">Enroll To PayTrigger</a></li>
                            <li><a href="{{url('/enrolled-paytrigger')}}">Enrolled on PayTrigger</a></li>
                            <li><a href="{{url('/device-loans')}}">All Device Loans</a></li>
                        </ul>
                    </li>

                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-anchor"></i></div>
                            <span>Old Mutual</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/old-mutual-loans')}}">Old Mutual Loans</a></li>
                            <li><a href="{{url('/mutual-clients')}}">Old Mutual Clients</a></li>
                            <li><a href="{{url('/single-client-info')}}">Verify Client Info</a></li>
                            <li><a href="{{url('/start-musoni-loan')}}">Apply For Loan</a></li>

                        </ul>
                    </li>-->

                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="dripicons-jewel"></i></div>
                            <span>ZWMB</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/unclaimed-kycs')}}">Process KYC</a></li>
                            <li><a href="{{url('/zwmbs')}}">ZWMB Clients</a></li>
                        </ul>
                    </li>-->


                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                        <li><a href="{{url('/manage-loan-requests')}}">Manage Loan Requests</a></li>
                    </ul>
                </li>-->

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/eloan-amortization')}}">Amortization Schedule</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/new-eloans')}}">New eLoans</a></li>
                        <li><a href="{{url('/authorized-eloans')}}">Authorized eLoans</a></li>
                        <li><a href="{{url('/disbursed-eloans')}}">Disbursed </a></li>
                        <li><a href="{{url('/declined-eloans')}}">Declined eLoans</a></li>
                        <li><a href="{{url('/cleared-eloans')}}">Cleared eLoans</a></li>
                        <li><a href="{{url('/eloan-records')}}">eLoan Records</a></li>
                        <li><a href="{{url('/eloans')}}">All eLoans</a></li>
                    </ul>
                </li>--}}

                @php
                    $pendingKyc = Illuminate\Support\Facades\DB::table('loans as l')
                ->join('clients as c', 'c.id','=','l.client_id')
                ->join('kycs as k', 'k.natid','=','c.natid')
                ->whereIn('l.loan_status',[1, 2])
                ->where('c.reds_number','=', null)
                ->where('k.status', '=',false)
                ->where('c.locale_id', '=',auth()->user()->locale)
                ->distinct()
                ->where('l.deleted_at', '=',null)->count();

                    $pendingEkyc = Illuminate\Support\Facades\DB::table('eloans as l')
                ->join('clients as c', 'c.id','=','l.client_id')
                ->join('kycs as k', 'k.natid','=','c.natid')
                ->where('l.loan_status','=',1)
                ->where('c.reds_number','=', null)
                ->where('k.status', '=',false)
                ->where('c.locale_id', '=',auth()->user()->locale)
                ->distinct()
                ->where('l.deleted_at', '=',null)->count();

                $clients = \App\Models\Client::where('locale_id',auth()->user()->locale)
                ->where('fsb_score',null)
                ->orWhere('fsb_score',0)
                ->where('fsb_status',null)
                ->where('fsb_rating',null)
                ->count();

                $totalIssues = $pendingKyc + $clients + $pendingEkyc;
                @endphp
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        @if($totalIssues>0)
                            <span class="badge badge-pill badge-danger float-right">{{$totalIssues}}</span>
                        @endif
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs @if($pendingKyc>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$pendingKyc}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/bot-pending-info')}}"> Bot Pending KYCs </a></li>
                        <li><a href="{{url('/pending-partner-kyc')}}"> Partner Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/merchant-kycs')}}">Merchant KYCs </a></li>
                        <li><a href="{{url('/cbz-check')}}">KYC Verification</a></li>
                        <li><a href="{{url('/fcb-update')}}">FCB Pending Clients @if($clients>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$clients}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/fcb-recheck')}}">FCB Recheck </a></li>
                        <li><a href="{{url('/fcb-responses')}}">FCB Responses </a></li>
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                    </ul>
                </li>--}}
                @endif

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-robot"></i></div>
                        <span>Bot Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bot-applications')}}">All Applications</a></li>
                    </ul>
                </li>-->
                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Offer Letters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/current-offer-letters')}}">Current Offer Letters</a></li>
                        <li><a href="{{url('/offer-letters')}}">All Offer Letters</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-database"></i></div>
                        <span>Ndasenda Batches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-batches')}}">Pending Batches</a></li>
                        <li><a href="{{url('/upload-loans-batch')}}">Upload Loans</a></li>
                        <li><a href="{{url('/committed-batches')}}">Committed Batches</a></li>
                        <li><a href="{{url('/processed-batches')}}">Processed Batches</a></li>
                        <li><a href="{{url('/batches')}}">All Batches</a></li>
                        <li><a href="{{url('/ndaseresponses')}}">Ndasenda Responses</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('leads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('allocate-leads')}}">Distribute Leads</a></li>
                        <li><a href="{{url('manage-leads')}}">Manage Leads</a></li>
                        <li><a href="{{url('leads-import')}}">Import Leads</a></li>
                        <li><a href="{{url('leads')}}">Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('calls')}}">Calls</a></li>
                    </ul>
                </li>
@endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Loans Accounting</li>
                @if(auth()->user()->locale == '1')
                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/repayments/create')}}">New Repayment</a></li>
                        <li><a href="{{url('/current-repayments')}}">Current Repayments</a></li>
                        <li><a href="{{url('/repayments')}}">All Repayments</a></li>
                    </ul>
                </li>-->
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span>Payments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(auth()->user()->locale == '2')
                            <li><a href="{{url('/zambia-payments/create')}}">New Zambia Payment</a></li>
                            <li><a href="{{url('/zambia-payments')}}">All Zambia Payments</a></li>
                        @else
                            <li><a href="{{url('/payments/create')}}">New Payment</a></li>
                            <li><a href="{{url('/payments')}}">All Payments</a></li>
                        @endif
                    </ul>
                </li>
                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Commissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('commissions/create')}}">Add Commission</a></li>
                        <li><a href="{{url('unpaid-commissions')}}">Unpaid</a></li>
                        <li><a href="{{url('paid-commissions')}}">Paid</a></li>
                        <li><a href="{{url('pay-commissions')}}">Register Payments</a></li>
                        <li><a href="{{url('commissions')}}">Commissions</a></li>
                    </ul>
                </li>
@endif
                @if(auth()->user()->locale == '2')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                            <span>Reports</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <!--<li><a href="{{url('zambia-disbursed-report')}}">Zambia Disbursed Loans</a></li>
                            <li><a href="{{url('zambia-disbursed-devices')}}">Zambia Disbursed Devices</a></li>
                            <li><a href="{{url('zambia-processing-loans-report')}}">Zambia Processing Loans</a></li>-->
                            <li><a href="{{url('all-zambia-loans-report')}}">All Zambia Loans</a></li>
                        </ul>
                    </li>
                @else
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('disbursed-report')}}">Disbursed Loans</a></li>
                            <li><a href="{{url('disbursed-product')}}">Disbursed Devices</a></li>
                            <li><a href="{{url('declined-report')}}">Declined Loans</a></li>
                            <li><a href="{{url('loans-by-type')}}">Loans By Type</a></li>
                            <li><a href="{{url('sales-admin-report')}}">Sales Admin</a></li>
                            <li><a href="{{url('sales-performance')}}">Sales Agent Type</a></li>
                            <li><a href="{{url('all-loans-report')}}">All Loans</a></li>
                            <li><a href="{{url('kyc-reg-report')}}">Registered Clients</a></li>
                            <li><a href="{{url('call-centre-weekly')}}">Call Centre Weekly</a></li>
                            <li><a href="{{url('calls-report')}}">Outgoing Sales Calls</a></li>
                            <li><a href="{{url('leads-converted-report')}}">Converted Leads </a></li>
                            <li><a href="{{url('leads-performance')}}">Leads Performance </a></li>
                            <li><a href="{{url('current-month-summary')}}">Current Month Loans </a></li>
                            <li><a href="{{url('monthly-year-summary')}}">Monthly Year Summary</a></li>
                        </ul>
                    </ul>
                </li>
@endif
                <li class="menu-title text-info">Users</li>


                @if(auth()->user()->locale == '2')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                            <span>Leads</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <!--<li><a href="{{url('zambians')}}">Clients</a></li>
                            <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                            <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>-->
                            <li><a href="{{url('zaleads')}}">Zambia Leads</a></li>
                            <li><a href="{{url('zaleads/create')}}">Add Lead</a></li>
                            <li><a href="{{url('import-zambia-lead')}}">Import Leads</a></li>
                            <!--<li><a href="{{url('/zam-approved-kycs')}}"> Zambia Approved </a></li>
                            <li><a href="{{url('/savings-accounts')}}"> Savings Accounts </a></li>
                            <li><a href="{{url('/crb-update')}}">CRB Pending Clients</a></li>
                            <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>-->
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                            <span>Clients</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('clients')}}">All Clients</a></li>
                            <li><a href="{{url('light-registrations')}}">Quick Registrations</a></li>
                            <li><a href="{{url('limits')}}">Client Credit Limits</a></li>
                            <li><a href="{{url('resend-otp')}}">Resend Client OTP</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-shield-account"></i></div>
                            <span>Partners</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('agents')}}">Agents</a></li>
                            <li><a href="{{url('merchants')}}">Merchants</a></li>
							<li><a href="{{url('approve-merchants')}}">Verify Merchants</a></li>
                            <li><a href="{{url('partners')}}">All Partners</a></li>
                        </ul>
                    </li>

                @php
                    $agents = \App\Models\Astrogent::where('activated',false)
                    ->count();
                @endphp
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-tie-outline"></i></div>
                        @if($agents>0)
                            <span class="badge badge-pill badge-danger float-right">{{$agents}}</span>
                        @endif
                        <span>Astrogents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/astrogents')}}">Astrogents</a></li>
                        <li><a href="{{url('/manage-astrogents')}}">Manage Astrogents @if($agents>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$agents}}</span>
                                @endif</a></li>
                    </ul>
                </li>
                @endif

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole

@role('salesadmin')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(auth()->user()->locale == '2')
                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>Zambia Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/zam-loan-calculator')}}">Zambia Loan Calculator</a></li>
                            <li><a href="{{url('/verify-loans')}}">Verify Loans</a></li>
                            <li><a href="{{url('/zambia-pending-loans')}}">Pending Loans</a></li>
                            <li><a href="{{url('/zambia-authorized')}}">Authorized </a></li>
                            <li><a href="{{url('/zambia-disbursed')}}">Disbursed </a></li>
                            <li><a href="{{url('/zambia-declined')}}">Declined </a></li>
                        </ul>
                    </li>-->
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                            <span>Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                            <li><a href="{{url('/loan-amortization')}}">Amortization Schedule</a></li>
                            <!--<li><a href="{{url('/reassign-loan')}}">ReAssign Loan</a></li>
                            <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>-->
                            <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                            <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                            <!--<li><a href="{{url('/ndasenda-processing-loans')}}">Ndasenda Processing</a></li>-->
                            <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                            <li><a href="{{url('/pending-disbursement')}}">Awaiting Disbursement</a></li>
                            <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                            <!--<li><a href="{{url('/disbursed-loans-template')}}">Email Disbursed </a></li>-->
                            <li><a href="{{url('/declined-loans')}}">Declined Loans</a></li>
                            <!--<li><a href="{{url('/cleared-loans')}}">Cleared Loans</a></li>-->
                            <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                            <!--<li><a href="{{url('/loans-to-settle')}}">Settle Loans</a></li>-->
                            <li><a href="{{url('sync-zambians')}}">Sync to Loan Disk</a></li>
                            <li><a href="{{url('loan-disk-check')}}">Loan Disk Lookup</a></li>
                            <li><a href="{{url('/crb-update')}}">CRB Pending Clients </a></li>
                            <li><a href="{{url('/crb-recheck')}}">CRB Recheck </a></li>
                            <li><a href="{{url('/loans')}}">All Loans</a></li>
                        </ul>
                    </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>USD Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                            <li><a href="{{url('/new-loans')}}">New Loans</a></li>
                            <li><a href="{{url('/pending-loans')}}">Pending Loans</a></li>
                            <li><a href="{{url('/approved-loans')}}">Approved</a></li>
                            <li><a href="{{url('/disbursed-loans')}}">Disbursed </a></li>
                            <li><a href="{{url('/loan-records')}}">Loan Records</a></li>
                            <li><a href="{{url('/usd-loans')}}">All Loans</a></li>
                        </ul>
                    </li> --}}

                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-anchor"></i></div>
                            <span>Old Mutual</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/old-mutual-loans')}}">Old Mutual Loans</a></li>
                            <li><a href="{{url('/mutual-clients')}}">Old Mutual Clients</a></li>
                            <li><a href="{{url('/single-client-info')}}">Verify Client Info</a></li>

                        </ul>
                    </li>-->

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                        <li><a href="{{url('/manage-loan-requests')}}">Manage Loan Requests</a></li>
                    </ul>
                </li>-->

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/eloan-amortization')}}">Amortization Schedule</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/new-eloans')}}">New eLoans</a></li>
                        <li><a href="{{url('/authorized-eloans')}}">Authorized eLoans</a></li>
                        <li><a href="{{url('/disbursed-eloans')}}">Disbursed </a></li>
                        <li><a href="{{url('/declined-eloans')}}">Declined eLoans</a></li>
                        <li><a href="{{url('/cleared-eloans')}}">Cleared eLoans</a></li>
                        <li><a href="{{url('/eloan-records')}}">eLoan Records</a></li>
                        <li><a href="{{url('/eloans')}}">All eLoans</a></li>
                    </ul>
                </li>--}}



                @php
                    $pendingKyc = Illuminate\Support\Facades\DB::table('loans as l')
                ->join('clients as c', 'c.id','=','l.client_id')
                ->join('kycs as k', 'k.natid','=','c.natid')
                ->whereIn('l.loan_status',[1, 2])
                ->where('c.reds_number','=', null)
                ->where('k.status', '=',false)
                ->where('c.locale_id', '=',auth()->user()->locale)
                ->distinct()
                ->where('l.deleted_at', '=',null)->count();

                    $pendingEkyc = Illuminate\Support\Facades\DB::table('eloans as l')
                ->join('clients as c', 'c.id','=','l.client_id')
                ->join('kycs as k', 'k.natid','=','c.natid')
                ->where('l.loan_status','=',1)
                ->where('c.reds_number','=', null)
                ->where('k.status', '=',false)
                ->where('c.locale_id', '=',auth()->user()->locale)
                ->distinct()
                ->where('l.deleted_at', '=',null)->count();

                $clients = \App\Models\Client::where('locale_id',auth()->user()->locale)
                ->where('fsb_score',null)
                ->where('fsb_status',null)
                ->where('fsb_rating',null)
                ->count();

                $totalIssues = $pendingKyc + $clients + $pendingEkyc;
                @endphp
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        @if($totalIssues>0)
                            <span class="badge badge-pill badge-danger float-right">{{$totalIssues}}</span>
                        @endif
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs @if($pendingKyc>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$pendingKyc}}</span>
                                @endif</a></li>
{{--                        <li><a href="{{url('/pending-eloans-kyc')}}"> Pending eLoans KYCs @if($pendingEkyc>0)--}}
{{--                                    <span class="badge badge-pill badge-danger float-right">{{$pendingEkyc}}</span>--}}
{{--                                @endif</a></li>--}}
                        <li><a href="{{url('/bot-pending-info')}}"> Bot Pending KYCs </a></li>
                        <li><a href="{{url('/pending-partner-kyc')}}"> Partner Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/merchant-kycs')}}">Merchant KYCs </a></li>
                        <li><a href="{{url('/cbz-check')}}">KYC Verification</a></li>
                        <li><a href="{{url('/fcb-update')}}">FCB Pending Clients @if($clients>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$clients}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/fcb-recheck')}}">FCB Recheck </a></li>
                        <li><a href="{{url('/fcb-responses')}}">FCB Responses </a></li>
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                    </ul>
                </li>--}}
                @endif
                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-robot"></i></div>
                        <span>Bot Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/bot-applications')}}">All Applications</a></li>
                    </ul>
                </li>-->
                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Offer Letters</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/current-offer-letters')}}">Current Offer Letters</a></li>
                        <li><a href="{{url('/offer-letters')}}">All Offer Letters</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-database"></i></div>
                        <span>Ndasenda Batches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-batches')}}">Pending Batches</a></li>
                        <li><a href="{{url('/upload-loans-batch')}}">Upload Loans</a></li>
                        <li><a href="{{url('/committed-batches')}}">Committed Batches</a></li>
                        <li><a href="{{url('/processed-batches')}}">Processed Batches</a></li>
                        <li><a href="{{url('/batches')}}">All Batches</a></li>
                        <li><a href="{{url('/ndaseresponses')}}">Ndasenda Responses</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('leads/create')}}">Add Lead</a></li>
                        <li><a href="{{url('allocate-leads')}}">Distribute Leads</a></li>
                        <li><a href="{{url('manage-leads')}}">Manage Leads</a></li>
                        <li><a href="{{url('leads-import')}}">Import Leads</a></li>
                        <li><a href="{{url('my-leads')}}">My Leads</a></li>
                        <li><a href="{{url('my-converted-leads')}}">Converted Leads</a></li>
                        <li><a href="{{url('leads')}}">Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls')}}">Calls</a></li>
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('my-calls')}}">My Calls</a></li>
                    </ul>
                </li>
@endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                    </ul>
                </li>
                @if(auth()->user()->locale == '1')
                <li class="menu-title text-info">Loans Accounting</li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/repayments/create')}}">New Repayment</a></li>
                        <li><a href="{{url('/current-repayments')}}">Current Repayments</a></li>
                        <li><a href="{{url('/repayments')}}">All Repayments</a></li>
                    </ul>
                </li>-->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Commissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('commissions/create')}}">Add Commission</a></li>
                        <li><a href="{{url('unpaid-commissions')}}">Unpaid</a></li>
                        <li><a href="{{url('paid-commissions')}}">Paid</a></li>
                        <li><a href="{{url('commissions')}}">Commissions</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('disbursed-report')}}">Disbursed Loans</a></li>
                            <li><a href="{{url('disbursed-product')}}">Disbursed Devices</a></li>
                            <li><a href="{{url('declined-report')}}">Declined Loans</a></li>
                            <li><a href="{{url('loans-by-type')}}">Loans By Type</a></li>
                            <li><a href="{{url('sales-admin-report')}}">Sales Admin</a></li>
                            <li><a href="{{url('sales-performance')}}">Sales Agent Type</a></li>
                            <li><a href="{{url('all-loans-report')}}">All Loans</a></li>
                            <li><a href="{{url('kyc-reg-report')}}">Registered Clients</a></li>
                            <li><a href="{{url('call-centre-weekly')}}">Call Centre Weekly</a></li>
                            <li><a href="{{url('calls-report')}}">Outgoing Sales Calls</a></li>
                            <li><a href="{{url('leads-converted-report')}}">Converted Leads </a></li>
                            <li><a href="{{url('leads-performance')}}">Leads Performance </a></li>
                            <li><a href="{{url('current-month-summary')}}">Current Month Loans </a></li>
                            <li><a href="{{url('monthly-year-summary')}}">Monthly Year Summary</a></li>
                        </ul>
                    </ul>
                </li>

                <li class="menu-title text-info">Users</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/partner-users')}}">All Clients</a></li>
                        <li><a href="{{url('register-pclient')}}">Add Client</a></li>
                        <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                        <li><a href="{{url('limits')}}">Client Credit Limits</a></li>
                        <li><a href="{{url('resend-otp')}}">Resend Client OTP</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-shield-account"></i></div>
                        <span>Partners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('agents')}}">Agents</a></li>
                        <li><a href="{{url('merchants')}}">Merchants</a></li>
                        <li><a href="{{url('partners')}}">All Partners</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-cash"></i></div>
                        <span>Funders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('funders')}}">Funders</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-tie-outline"></i></div>
                        <span>Astrogents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/astrogents')}}">Astrogents</a></li>
                        <li><a href="{{url('/manage-astrogents')}}">Manage Astrogents</a></li>
                    </ul>
                </li>
                @endif
                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('partner')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/new-partner-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/new-partner-credit')}}">Existing Customer Credit</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>
                        <li><a href="{{url('/partner-loans')}}">Partner Loans</a></li>
                        <li><a href="{{url('/loans-pending-disbursement')}}">Payments Pending</a></li>
                    </ul>
                </li>    <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Product Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/orders?status=new')}}">New Orders</a></li>
                        <li><a href="{{url('/orders?status=pending-approval-loan')}}">Pending Approval( Loan Officer )</a></li>
                        <li><a href="{{url('/orders?status=pending-approval-financier')}}">Pending Approval( Financier )</a></li>
                        <li><a href="{{url('/orders?status=pending-dispatch')}}">Approved Orders Pending Dispatch</a></li>
                        <li><a href="{{url('/orders?status=dispatched-orders')}}">Dispatched Orders</a></li>
                        <li><a href="{{url('/orders?status=new')}}">Disbursement</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>USD Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                        <li><a href="{{url('/new-partner-usd-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/partner-usd-loans')}}">Partner Loans</a></li>
                     </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/register-pclient')}}">New Client</a></li>
                        <li><a href="{{url('/partner-users')}}">Manage Clients</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-multiple-outline"></i></div>
                        <span>Representatives</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-representatives')}}">Representatives</a></li>
                        <li><a href="{{url('representatives/create')}}">Add Representative</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-multiple-outline"></i></div>
                        <span>Branches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-branches')}}">Branches</a></li>
                        <li><a href="{{url('branch/new')}}">Add Branch</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-package-variant"></i></div>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('products/create')}}">Add Product</a></li>
                        <li><a href="{{url('upload-bulk-products')}}">Add Bulk Products</a></li>
                        <li><a href="{{url('our-products')}}">Our Products</a></li>
                        <li><a href="{{url('product-pricing')}}">Prices Modifier</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('loans-by-report')}}">Loans by Partner</a></li>
                        <li><a href="{{url('product-performance')}}">Loans by Products</a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('agent')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>
@if(auth()->user()->locale == '2')
                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>Zambia Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/zam-loan-calculator')}}">Zambia Loan Calculator</a></li>
                            <li><a href="{{url('/zambia-loans/create')}}">New Zam Device Loan</a></li>
                            <li><a href="{{url('/check-affordability')}}">New Zam Cash Loan</a></li>
                            <li><a href="{{url('/my-zambia-loans')}}">My Loans</a></li>
                        </ul>
                    </li>-->
                @else
                    <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>
                        <li><a href="{{url('/new-partner-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/new-partner-credit')}}">Existing Customer Credit</a></li>
                        {{--<li><a href="{{url('/new-partner-hybrid')}}">Existing Hybrid Credit</a></li>--}}
                        <li><a href="{{url('/partner-loans')}}">My Loans</a></li>
                    </ul>
                </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>USD Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                            <li><a href="{{url('/new-partner-usd-loan')}}">Existing Customer</a></li>
                            <li><a href="{{url('/partner-usd-loans')}}">My USD Loans</a></li>
                        </ul>
                    </li> --}}

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-comments-dollar"></i></div>
                        <span>Loan Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-requests/create')}}">Place Loan Request</a></li>
                        <li><a href="{{url('/my-loan-requests')}}">My Loan Requests</a></li>
                    </ul>
                </li>-->

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloan-calculator')}}">eLoan Calculator</a></li>
                        <li><a href="{{url('/unsigned-eloans')}}">Unsigned eLoans</a></li>
                        <li><a href="{{url('/partner-eloans')}}">My eLoans</a></li>

                    </ul>
                </li>--}}


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-android"></i></div>
                        <span>Device Financing</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/new-adevice-loan')}}">New Device Loan</a></li>
                        <li><a href="{{url('/my-agent-device-loans')}}">My Device Loans</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                    </ul>
                </li>--}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-leads')}}">My Leads</a></li>
                        <li><a href="{{url('my-converted-leads')}}">Converted Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('my-calls')}}">My Calls</a></li>
                    </ul>
                </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Users</li>
                @if(auth()->user()->locale == '2')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <!--<li><a href="{{url('zambians')}}">All Clients</a></li>-->
                        <li><a href="{{url('check-affordability')}}">New Client</a></li>
                        <li><a href="{{url('zaleads')}}">Zambia Leads</a></li>
                        <li><a href="{{url('zaleads/create')}}">Add Lead</a></li>
                    </ul>
                </li>
                @else
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
					    <li><a href="{{url('clients')}}">All Clients</a></li>
                        <li><a href="{{url('/partner-users')}}">Partners</a></li>
                        <li><a href="{{url('register-pclient')}}">Add Partner</a></li>
                        <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                    </ul>
                </li>
@endif

                <li class="menu-title text-info">Reports</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-commissions')}}">My Commissions</a></li>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('astrogent')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>
                        <li><a href="{{url('/new-partner-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/new-partner-credit')}}">Existing Customer Credit</a></li>
                        {{--<li><a href="{{url('/new-partner-hybrid')}}">Existing Hybrid Credit</a></li>--}}
                        <li><a href="{{url('/partner-loans')}}">My Loans</a></li>
                    </ul>
                </li>
{{--
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>USD Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                        <li><a href="{{url('/new-partner-usd-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/partner-usd-loans')}}">My USD Loans</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi mdi-file-phone"></i></div>
                        <span>Sales Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-leads')}}">My Leads</a></li>
                        <li><a href="{{url('my-converted-leads')}}">Converted Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-phone-outgoing"></i></div>
                        <span>Calls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('calls/create')}}">Place Call</a></li>
                        <li><a href="{{url('my-calls')}}">My Calls</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Users</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/partner-users')}}">Clients</a></li>
                        <li><a href="{{url('register-pclient')}}">Add Client</a></li>
                        <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Reports</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-commissions')}}">My Commissions</a></li>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('fielder')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(auth()->user()->locale == '2')
                    <!--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>Zambia Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/zam-loan-calculator')}}">Zambia Loan Calculator</a></li>
                            <li><a href="{{url('/zambia-loans/create')}}">New Zam Device Loan</a></li>
                            <li><a href="{{url('/create-zam-cash-loan')}}">New Zam Cash Loan</a></li>
                            <li><a href="{{url('/my-zambia-loans')}}">My Loans</a></li>
                        </ul>
                    </li>-->
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                            <span>Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                            <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>
                            <li><a href="{{url('/new-partner-loan')}}">Existing Customer</a></li>
                            <li><a href="{{url('/new-partner-credit')}}">Existing Customer Credit</a></li>
                            {{--<li><a href="{{url('/new-partner-hybrid')}}">Existing Hybrid Credit</a></li>--}}
                            <li><a href="{{url('/partner-loans')}}">My Loans</a></li>
                        </ul>
                    </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>USD Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                            <li><a href="{{url('/new-partner-usd-loan')}}">Existing Customer</a></li>
                            <li><a href="{{url('/partner-usd-loans')}}">My USD Loans</a></li>
                        </ul>
                    </li> --}}


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycs')}}"> Pending KYCs </a></li>
                        <li><a href="{{url('/approved-kycs')}}"> Approved KYCs </a></li>
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                    </ul>
                </li>
                @php $requests = \App\Models\Kycchange::where('status', false)->count();@endphp
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-users-cog"></i></div>
                        @if($requests>0)
                            <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                        @endif
                        <span>KYC Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/pending-kycchanges')}}"> Pending Requests @if($requests>0)
                                    <span class="badge badge-pill badge-danger float-right">{{$requests}}</span>
                                @endif</a></li>
                        <li><a href="{{url('/approved-kycchanges')}}"> Approved Requests </a></li>
                        <li><a href="{{url('/kycchanges')}}"> All Requests </a></li>
                    </ul>
                </li>--}}
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-ticket-account"></i></div>
                        <span>Queries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('queries')}}">Queries</a></li>
                        <li><a href="{{url('queries/create')}}">Log Query</a></li>
                        <li><a href="{{url('my-queries')}}">My Queries</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Users</li>

                @if(auth()->user()->locale == '2')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                            <span>Leads</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <!--<li><a href="{{url('zambians')}}">All Clients</a></li>-->
                            <li><a href="{{url('register-for-zambia')}}">New Client</a></li>
                            <li><a href="{{url('zaleads')}}">Zambia Leads</a></li>
                            <li><a href="{{url('zaleads/create')}}">Add Lead</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                            <span>Clients</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/partner-users')}}">Clients</a></li>
                            <li><a href="{{url('register-pclient')}}">Add Client</a></li>
                            <li><a href="{{url('converted-leads')}}">Pickup Registration</a></li>
                        </ul>
                    </li>
                @endif

                <li class="menu-title text-info">Reports</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-commissions')}}">My Commissions</a></li>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('representative')
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-black">Menu</li>

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/loan-calculator')}}">Loan Calculator</a></li>
                        <li><a href="{{url('/unsigned-loans')}}">Unsigned Loans</a></li>
                        <li><a href="{{url('/new-partner-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/new-partner-credit')}}">Existing Customer Credit</a></li>
                        {{--<li><a href="{{url('/new-partner-hybrid')}}">Existing Hybrid Credit</a></li>--}}
                        <li><a href="{{url('/pending-partner-loans')}}">Pending Loans</a></li>
                        <li><a href="{{url('/disbursed-partner-loans')}}">Disbursed Loans</a></li>
                        <li><a href="{{url('/partner-loans')}}">My Loans</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>USD Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                        <li><a href="{{url('/new-partner-usd-loan')}}">Existing Customer</a></li>
                        <li><a href="{{url('/partner-usd-loans')}}">My USD Loans</a></li>
                    </ul>
                </li> --}}

                <li class="menu-title text-info">Users</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-account-circle-outline"></i></div>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/partner-users')}}">Clients</a></li>
                        <li><a href="{{url('register-pclient')}}">Add Client</a></li>
                    </ul>
                </li>

                <li class="menu-title text-info">Reports</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-receipt"></i></div>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('my-commissions')}}">My Commissions</a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@endrole
@role('redsphere')
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Home</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/client-kycs')}}"> Client KYCs </a></li>
                        <!--<li><a href="{{url('/cbz-pending-kycs')}}"> CBZ Review KYCs </a></li>-->
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
    </div>
</div>
@endrole
@role('womensbank')
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Home</span>
                    </a>
                </li>

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-address-card"></i></div>
                        <span>KYCs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/zwmb-client-kycs')}}"> Client KYCs </a></li>
                        <li><a href="{{url('/zwmb-pending-kycs')}}"> Pending KYCs </a></li>
                    </ul>
                </li>-->

                <!--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="dripicons-jewel"></i></div>
                        <span>ZWMB</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/unclaimed-kycs')}}">Process KYC</a></li>
                        <li><a href="{{url('/get-reviewed-zwmb')}}">KYC to Authorize</a></li>
                        <li><a href="{{url('/zwmbs')}}">ZWMB Clients</a></li>
                    </ul>
                </li>-->

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
    </div>
</div>
@endrole
@role('client')
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{url('/home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-desktop-mac-dashboard"></i></div>
                        <span>Home</span>
                    </a>
                </li>
                @if(auth()->user()->locale == '2')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/zam-loan-calculator')}}">Loan Calculator</a></li>
                            <li><a href="{{url('/new-zambia-device')}}">Apply Device Loan</a></li>
                            <li><a href="{{url('/loans/create')}}">New Product Loan</a></li>
                            <li><a href="{{url('/new-zambia-cash')}}">Apply Cash Loan</a></li>
                            <li><a href="{{url('/zambia-me-loans')}}">My Loans</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-dollar-sign"></i></div>
                            <span>Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/loans/create')}}">New Cash Loan</a></li>
                            <li><a href="{{url('/create-credit-loan')}}">New Store Credit Loan</a></li>
                            <li><a href="{{url('/myloans')}}">My Loans</a></li>
                        </ul>
                    </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                            <span>USD Loans</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/usd-loan-calculator')}}">USD Loan Calculator</a></li>
                            <li><a href="{{url('/usd-loans/create')}}">New USD Loan </a></li>
                            <li><a href="{{url('/my-usd-loans')}}">My USD Loans</a></li>
                        </ul>
                    </li> --}}
                @endif
                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fab fa-erlang"></i></div>
                        <span>eLoans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/eloans/create')}}">New Cash eLoan</a></li>
                        <li><a href="{{url('/create-credit-eloan')}}">New Store Credit eLoan</a></li>
                        <li><a href="{{url('/create-hybrid-eloan')}}">New Hybrid eLoan</a></li>
                        <li><a href="{{url('/new-recharge-eloan')}}">New Recharge eLoan</a></li>
                        <li><a href="{{url('/myeloans')}}">My Instant eLoans</a></li>
                    </ul>
                </li>--}}
                @if(auth()->user()->locale == '1')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-cellphone-android"></i></div>
                        <span>Device Financing</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/device-loans/create')}}">Apply For Device Loan</a></li>
                        <li><a href="{{url('/my-device-loans')}}">My Device Loans</a></li>
                    </ul>
                </li>
                @endif

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-funnel-dollar"></i></div>
                        <span>Repayments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/my-repayments')}}">My Repayments</a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sign-out-alt"></i></div>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
    </div>
</div>
@endrole
