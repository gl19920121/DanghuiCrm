<nav class="navbar navbar-expand-lg second-navbar">
  <div class="container">
    <div class="my-nav-tabs {{ $tab }}">
      <ul class="nav nav-tabs text-center justify-content-center">
        @switch ($tab)
          @case ('jobs')
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
            @break
          @case ('resumes')
            <li class="nav-item">
              <a class=" nav-link {{ in_array(Route::currentRouteName(), ['resumes.create', 'resumes.edit']) ? 'active': '' }}" href="{{ route('resumes.create') }}">
                上传简历
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['resumes.list', 'resumes.show']) ? 'active': '' }}" href="{{ route('resumes.list') }}">
                搜索简历
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['resumes.mine']) ? 'active': '' }}" href="{{ route('resumes.mine') }}">
                人才管理
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['resumes.current']) ? 'active': '' }}" href="{{ route('resumes.current') }}">
                新上传
              </a>
            </li>
            @break
        @endswitch
      </ul>
    </div>
  </div>
</nav>
