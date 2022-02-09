<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img alt="" src="{{ URL::asset('images/logo_with_text.png') }}" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 text-center">
                <li class="nav-item {{ Route::currentRouteName() === 'home' || Route::currentRouteName() === 'users.show' || Route::currentRouteName() === 'users.edit' ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        首页 <span class="sr-only">(current)</span>
                    </a>
                    @if (in_array(Route::currentRouteName(), ['home', 'users.show', 'users.edit']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'jobs.') !== false || Route::currentRouteName() === 'drafts.list' || Route::currentRouteName() === 'companys.list' || Route::currentRouteName() === 'companys.edit' || Route::currentRouteName() === 'companys.show' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('jobs.list') }}">
                        运作职位
                    </a>
                    @if (in_array(Route::currentRouteName(), ['jobs.create', 'jobs.list', 'jobs.show', 'companys.list', 'companys.edit', 'companys.show']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'resumes.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('resumes.list') }}">
                        简历库
                    </a>
                    @if (in_array(Route::currentRouteName(), ['resumes.create', 'resumes.create.manual', 'resumes.edit', 'resumes.list', 'resumes.show', 'resumes.mine', 'resumes.current']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                @can ('rpo-manager')
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'management.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('management.job.list') }}">
                        员工管理
                    </a>
                    @if (in_array(Route::currentRouteName(), ['management.job.list', 'management.staff.list']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                @endcan
                @can ('statistics')
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'statistics.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('statistics.list') }}">
                        数据统计
                    </a>
                    @if (in_array(Route::currentRouteName(), ['statistics.list']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                @endcan
                @can ('article-publish')
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'articles.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('articles.create') }}">
                        文章发布
                    </a>
                    @if (strpos(Route::currentRouteName(), 'articles.') !== false)
                      <div class="triangle-up"></div>
                    @endif
                </li>
                @endcan
            </ul>
            <div class="form-inline ml-auto">
                <div class="notice">
                    <img src="{{ URL::asset('images/icon_message.png') }}" />
                </div>
                <div class="dropdown my-menu">
                    <a class="nav-link dropdown-toggle a-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">编辑资料</a>
                        <a class="dropdown-item" id="logout" href="#">
                            <form action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                            </form>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@if (in_array(Route::currentRouteName(), ['jobs.create', 'jobs.edit', 'jobs.list', 'jobs.show', 'drafts.list', 'companys.list', 'companys.edit', 'companys.show']))
  @include('layouts._second_header', ['tab' => 'jobs'])
@elseif (in_array(Route::currentRouteName(), ['resumes.create', 'resumes.create.manual', 'resumes.edit', 'resumes.list', 'resumes.show', 'resumes.mine', 'resumes.current']))
  @include('layouts._second_header', ['tab' => 'resumes'])
@elseif (in_array(Route::currentRouteName(), ['management.job.list', 'management.resume.list', 'management.staff.list']))
  @include('layouts._second_header', ['tab' => 'management'])
@elseif (strpos(Route::currentRouteName(), 'articles.') !== false)
  @include('layouts._second_header', ['tab' => 'articles'])
@endif
