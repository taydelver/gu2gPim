<div class="navbar navbar-main">
  <div class="navbar__left"></div>
  <div class="navbar__right">
    <div class="navbar__user">
       <div class="nav-item dropdown">
          <a id="navbarUserDropdown" class="nav-link dropdown-toggle user-navlink" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <div class="user-navlink__avatar"><i class="ni ni-single-02"></i></div>
              {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUserDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </div>
        </div>
    </div>
  </div>
</div>