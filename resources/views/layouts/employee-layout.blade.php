<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .view-order-status-customer {
      background: linear-gradient(
          137.15deg,
          rgba(23, 232, 255, 0) 0%,
          rgba(23, 232, 255, 0.2) 100%
        ),
        linear-gradient(to left, rgba(7, 156, 214, 0.2), rgba(7, 156, 214, 0.2)),
        linear-gradient(
          119.69deg,
          rgba(93, 141, 230, 0) 0%,
          rgba(142, 176, 239, 0.1) 45.69%,
          rgba(36, 89, 188, 0.2) 96.88%
        ),
        linear-gradient(to left, rgba(47, 53, 109, 0.2), rgba(47, 53, 109, 0.2));
      height: 100vh;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      overflow: hidden;
      display: flex;
    }
    .sidebar {
      background: rgba(217, 217, 217, 0.5);
      width: 250px;
      padding: 20px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
      overflow-y: auto;
    }
    .sidebar-container {
      width: 100%;
      padding: 0 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .sidebar img {
      width: 100%;
      max-width: 150px;
      margin-bottom: 30px;
    }
    .sidebar .nav {
      width: 100%;
    }
    .sidebar .nav-link {
      color: #000000;
      font-size: 1rem;
      margin: 8px 0;
      text-align: left;
      width: 100%;
      padding: 10px 15px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
    }
    .sidebar .nav-link:hover {
      background-color: rgba(7, 156, 214, 0.1);
    }
    .sidebar .nav-link.active {
      background-color: #079CD6;
      color: white;
      font-weight: 500;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .sidebar .nav-link i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }
    .main-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      height: 100vh;
    }
    /* Custom scrollbar for sidebar */
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }
    .sidebar::-webkit-scrollbar-track {
      background: rgba(217, 217, 217, 0.3);
    }
    .sidebar::-webkit-scrollbar-thumb {
      background-color: rgba(7, 156, 214, 0.5);
      border-radius: 6px;
    }
    .sidebar::-webkit-scrollbar-thumb:hover {
      background-color: rgba(7, 156, 214, 0.7);
    }
  </style>
  @stack('styles')
</head>
<body>
  <div class="view-order-status-customer">
    <div class="sidebar">
      <div class="sidebar-container">
        <img src="{{ asset('img/1ds-removebg-preview.png') }}" alt="Company Logo">
        <nav class="nav flex-column">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
          <a class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
            <i class="fas fa-receipt"></i> Order/Transaction
          </a>
          <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
            <i class="fas fa-eye"></i> View Laundry
          </a>
          <a class="nav-link {{ request()->routeIs('employee.supplier.index') ? 'active' : '' }}" href="{{ route('employee.supplier.index') }}">
            <i class="fas fa-truck"></i> Supplier
          </a>
          <a class="nav-link {{ request()->routeIs('employee.items.index') ? 'active' : '' }}" href="{{ route('employee.items.index') }}">
            <i class="fas fa-boxes"></i> Items
          </a>
          <a class="nav-link {{ request()->routeIs('employee.stock_in_index') ? 'active' : '' }}" href="{{ route('employee.stock_in_index') }}">
            <i class="fas fa-arrow-down"></i> Stock In
          </a>
          <a class="nav-link {{ request()->routeIs('employee.stock_out_index') ? 'active' : '' }}" href="{{ route('employee.stock_out_index') }}">
            <i class="fas fa-arrow-up"></i> Stock Out
          </a>
          <a class="nav-link {{ request()->routeIs('employee.receive-orders.index') ? 'active' : '' }}" href="{{ route('employee.receive-orders.index') }}">
            <i class="fas fa-clipboard-check"></i> Receive Order
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();">
              <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
          </form>
        </nav>
      </div>
    </div>
    <div class="main-content">
      @yield('content')
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Add active class to current route
    $(document).ready(function() {
      const currentRoute = "{{ request()->path() }}";
      $('.nav-link').each(function() {
        const linkRoute = $(this).attr('href').split('/').filter(Boolean).join('/');
        if (currentRoute.includes(linkRoute)) {
          $(this).addClass('active');
        }
      });
    });
  </script>
  @stack('scripts')
</body>
</html>