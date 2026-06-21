<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="{{ route('home') }}" role="button"> Website <i class="fas fa-globe"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">

      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">0</span>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 0 new messages
        </a>
        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <!-- Full Screen Button -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- User Button -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>

      <div class="dropdown-menu dropdown-menu-right">

        @if (Auth::guard('admin')->check())
            <a class="dropdown-item" href="{{ route('admin.change-password') }}"> Profile </a>
        @else
            <a class="dropdown-item" href="{{ route('seller.change-password') }}"> Profile </a>
        @endif

        <div class="dropdown-divider"></div>

        @if (Auth::guard('admin')->check())
            <a class="dropdown-item" href="{{ route('admin.logout') }}"> <i class="fas fa-lock"></i> Logout</a>
        @else
            <a class="dropdown-item" href="{{ route('seller.logout') }}"> <i class="fas fa-lock"></i> Logout</a>
        @endif

      </div>
    </li>

  </ul>
</nav>
