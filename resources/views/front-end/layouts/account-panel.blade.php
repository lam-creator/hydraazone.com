<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item">
        <a href="{{ route('user.dashboard') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i> My Profile</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.order-list') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i> My Orders</a>
    </li>
    {{-- <li class="nav-item">
        <a href="wishlist.php"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i> Wishlist</a>
    </li> --}}
    <li class="nav-item">
        <a href="{{ route('user.change-password') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i> Change Password</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.logout') }}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </li>
</ul>

<style>

    ul#account-panel {
    background: #f5f5f5;
    border-radius: 5px;
    border: 1px solid #ddd;
    }

    ul#account-panel li {
    border-bottom: 1px solid #ddd;
    }

    ul#account-panel li:hover {
    background: #e9e9e9;
    }

     ul#account-panel li:last-child {
    border-bottom: none;
    }
    ul#account-panel li a {
    color: #333;
    padding: 10px 15px;
    }

</style>
