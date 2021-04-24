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
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'jobtasks.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        运作职位
                    </a>
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'resumes.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        简历库
                    </a>
                </li>
                <li class="nav-item {{ strpos(Route::currentRouteName(), 'jobtasks.') !== false ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        招聘进度
                    </a>
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

<nav hidden class="navbar navbar-expand-lg navbar-dark navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="route('home')">
                <img alt="" src="{{ URL::asset('images/logo_with_text.png') }}" />
            </a>
        </div>
        <ul class="navbar-nav justify-content-end">
            <li class="nav-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}">运作职位</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}">简历库</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}">招聘进度</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个人中心</a>
                    <a class="dropdown-item" href="#">编辑资料</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" id="logout" href="#">
                        <form action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                        </form>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
