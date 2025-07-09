<ul>
                            <li class="{{ $dashboard ?? '' }}"><a href="{{ route('my-account.dashboard') }}">Dashboard</a></li>
                            <li class="{{ $orders ?? '' }}"><a href="{{ route('my-account.orders') }}">Orders</a></li>
                            <li class="{{ $addresses ?? '' }}"><a href="{{ route('my-account.addresses') }}">Addresses</a></li>
                            <li class="{{ $accountDetails ?? '' }}"><a href="{{ route('my-account.account-details') }}">Account details</a></li>
                            <li class="{{ $logout ?? '' }}"><a href="{{ route('my-account.logout') }}">Logout</a></li>
                        </ul>