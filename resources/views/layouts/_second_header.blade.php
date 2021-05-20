<nav class="navbar navbar-expand-lg second-navbar">
  <div class="container">
    <div class="my-nav-tabs jobs">
      <ul class="nav nav-tabs text-center justify-content-center">
          <li class="nav-item">
            <a class=" nav-link {{ in_array(Route::currentRouteName(), ['jobs.create', 'jobs.edit']) ? 'active': '' }}"" href="{{ route('jobs.create') }}">
              发职位
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['jobs.list', 'jobs.show', 'drafts.list']) ? 'active': '' }}"" href="{{ route('jobs.list') }}">
              职位管理
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['companys.list', 'companys.show', 'companys.edit']) ? 'active': '' }}" href="{{ route('companys.list') }}">
              企业管理
            </a>
          </li>
        </ul>
    </div>
  </div>
</nav>
