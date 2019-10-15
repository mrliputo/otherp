<ul>
  <li class="nav-item">
    <span class="username">{{ Auth::user()->name }}</span>
  </li>
  <li class="nav-item">
    <a href="#" class=" icon-cogs-menu dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-cogs"></i>
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <li class="dropdown-item">
        <a href="javascript:void(0)"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();
        "><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </li>
</ul>
