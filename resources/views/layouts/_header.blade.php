<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="route('home')">
                <img alt="" src="{{ URL::asset('images/logo_with_text.png') }}" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 text-center">
                <li class="nav-item {{ Route::currentRouteName() === 'home' ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        首页 <span class="sr-only">(current)</span>
                    </a>
                    @if (in_array(Route::currentRouteName(), ['home']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'jobs.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('jobs.create') }}">
                        运作职位
                    </a>
                    @if (in_array(Route::currentRouteName(), ['jobs.create', 'jobs.list']))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'resumes.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        简历库
                    </a>
                    @if (in_array(Route::currentRouteName(), []))
                      <div class="triangle-up"></div>
                    @endif
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'tasks.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        招聘进度
                    </a>
                    @if (in_array(Route::currentRouteName(), []))
                      <div class="triangle-up"></div>
                    @endif
                </li>
            </ul>
            <div class="form-inline ml-auto">
                <div class="notice">
                    <img src="{{ URL::asset('images/icon_message.png') }}" />
                </div>
                <div class="dropdown my-menu">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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

@if (in_array(Route::currentRouteName(), ['jobs.create', 'jobs.list', 'jobs.search']))
  @include('layouts._second_header')
@endif
