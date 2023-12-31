<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store</title>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
    {{-- Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body id="body-pd">
    <header class="header shadow-sm" id="header">
        @if ($user->store) 
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        @else
        <div class="header_toggle">Store Registration</div>
        @endif
        <div class="dropdown text-end">
            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                @if ($user->store) 
                @if ($user->store->image)
                <img src="{{ asset('storage/'.$user->store->image->url) }}" alt="mdo" width="32" height="32" class="rounded-circle border border-dark">
                @else
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="mdo" width="32" height="32" class="rounded-circle border border-dark">           
                @endif
                {{ $user->store->name }}
                @endif
              </a>
            <ul class="dropdown-menu text-small">
                @if ($user->store) 
                <li><a class="dropdown-item" href="{{ route('store.edit',$user->store->id) }}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                @endif
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @method('delete')
                  @csrf
                  <button type="submit" class="dropdown-item">Log out</button>
              </form>
              </li>
            </ul>
          </div>
    </header>
      @if ($user->store)          
      <div class="l-navbar" id="nav-bar">
          <nav class="nav">
              <div> 
                  <a href="#" class="nav_logo"> 
                      <i class='bx bx-layer nav_logo-icon'></i> 
                      <span class="nav_logo-name">{{ $user->store->name }}</span> 
                  </a>
                  <div class="nav_list"> 
                      <a href="{{ route('store.index') }}" class="nav_link {{ Route::is('store*') ? 'active' : '' }}"> 
                          <i class='bx bx-grid-alt nav_icon'></i> 
                          <span class="nav_name">Dashboard</span> 
                      </a> 
                      <a href="{{ route('products.index') }}" class="nav_link {{ Route::is('products*') ? 'active' : '' }}">  
                          <i class='bx bx-package nav_icon'></i> 
                          <span class="nav_name">Products</span> 
                      </a> 
                      <a href="{{ route('order.index',1) }}" class="nav_link {{ Route::is('order.index') ? 'active' : '' }}"> 
                          <i class='bx bx-message-square-detail nav_icon'></i> 
                          <span class="nav_name">Orders</span>
                      </a> 
                      <a href="#" class="nav_link"> 
                          <i class='bx bx-bookmark nav_icon'></i> 
                          <span class="nav_name">Bookmark</span> 
                      </a> 
                      <a href="#" class="nav_link"> 
                          <i class='bx bx-folder nav_icon'></i> 
                          <span class="nav_name">Files</span> 
                      </a> 
                      <a href="#" class="nav_link"> 
                          <i class='bx bx-bar-chart-alt-2 nav_icon'></i> 
                          <span class="nav_name">Stats</span> 
                      </a> 
                  </div>
              </div> 
              <a href="#" class="nav_link"> 
                  <i class='bx bx-log-out nav_icon'></i> 
                  <span class="nav_name">SignOut</span> 
              </a>
          </nav>
      </div>
      @endif
    
    <!--Container Main start-->
    <div class="container">
        @yield('container')
    </div>
    <!--Container Main end-->

    {{-- JavaScript --}}
    <script src="{{ asset('js/multiple-uploader.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- JQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
