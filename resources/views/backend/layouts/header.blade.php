<nav class="navbar">
    <div class="header">
        <ul class="navbar-nav navbar-nav-left">
            <li class="nav-item">
                <a href="{{ route('user.list') }}">User</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('product.list') }}">Product</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('category.list') }}">Category</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('role.list') }}">Role</a>
            </li>
        </ul>
        @if (Auth::check())
            <div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item">
                        <a href="{{ route('user.logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        @else
            <div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item">
                        <a href="">Register</a>
                    </li>
                    <li class="nav-item">
                        <a href="">Login</a>
                    </li>
                </ul>
            </div>
        @endif
        {{-- <div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="">Register</a>
                </li>
                <li class="nav-item">
                    <a href="">Login</a>
                </li>
            </ul>
        </div> --}}
    </div>
</nav>