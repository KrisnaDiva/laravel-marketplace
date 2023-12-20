<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="40">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('dashboard') }}" class="nav-link px-2 link-secondary">Dashboard</a></li>
          {{-- <li><a href="#" class="nav-link px-2 link-body-emphasis">Inventory</a></li> --}}
        </ul>


        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            @if ($user->image)
            <img src="{{ asset('storage/'.$user->image->url) }}" alt="mdo" width="32" height="32" class="rounded-circle border border-dark">
            @else
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="mdo" width="32" height="32" class="rounded-circle border border-dark">           
            @endif
            {{ $user->name }}
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('store.index') }}">Store</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @method('delete')
                @csrf
                <button type="submit" class="dropdown-item">Log out</button>
            </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>