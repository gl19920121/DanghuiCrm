@extends('layouts.default')
@section('title', '首页')
@section('content')
<div class="home">
	<div class="row">
		<div class="col">
			<div class="banner">
				<div class="row">
					<div class="col m-auto">
						<img src="{{ URL::asset('images/nav_left.png') }}">
					</div>
					<div class="col m-auto">
						<img class="mr-5" src="{{ URL::asset('images/nav_center.png') }}">
					</div>
					<div class="col m-auto">
						<img class="mr-5" src="{{ URL::asset('images/nav_right.png') }}">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-9">
			<div class="row">
				<div class="col">
					<div class="message">
						<div class="row">
							<div class="col-2 pl-4 pt-4">
								<img src="{{ URL::asset('images/welcome.png') }}">
							</div>
							<div class="col pl-4 pt-4">
								<div class="row align-items-center justify-content-end top mr-4">
									<div class="col">
										<h5>HI 亲爱的<span>{{ Auth::user()->name }}</span>，欢迎回到当会~</h5>
										<p>没有特别幸运，那么请先特别努力</p>
									</div>
									<div class="col text-right">
										<button class="btn btn-danger">完善资料</button>
									</div>
								</div>
								<div class="row mt-4 justify-content-start bottom text-center">
									<div class="col">
										<h4>10</h4><br>
										<b>运作职位</b>
									</div>
									<div class="col">
										<h4>10</h4><br>
										<b>新增应聘</b>
									</div>
									<div class="col">
										<h4>10</h4><br>
										<b>新增委托</b>
									</div>
									<div class="col">
										<h4>10</h4><br>
										<b>新增留言</b>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="list">
            <div class="my-nav-tabs">
              <ul class="nav nav-tabs mr-4" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="job-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="job"
                        aria-selected="true">
                    <h6>运作职位</h6>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="accept-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="accept"
                      aria-selected="false">
                    <h6>新增应聘</h6>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="task-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="task"
                      aria-selected="false">
                    <h6>新增委托</h6>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="message-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="message"
                      aria-selected="false">
                    <h6>新增留言</h6>
                  </a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent" >
                <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="job-tab">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <div class="empty row">
                        <div class="col text-center m-auto">
                          <img src="{{ URL::asset('images/empty.png') }}">
                          <p>您还没有运作的职位</p>
                        </div>
                      </div>
                    </li>
                  </ul>
              </div>
              <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="accept-tab">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"></li>
                  </ul>
              </div>
              <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="task-tab">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"></li>
                  </ul>
              </div>
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="message-tab">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"></li>
                  </ul>
                </div>
              </div>
            </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="general text-center">
        <div class="row avatar">
          <div class="col">
            <img src="{{ URL::asset('images/avatar_default.png') }}"">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h3>{{ Auth::user()->name }}</h3>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h5>{{ Auth::user()->job }}</h5>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <p>满意指数：<span class="color-red">198</span></p>
          </div>
          <div class="col">
            <p>当前星级：</p>
          </div>
        </div>
        <hr class="divider">
        <div class="row">
          <div class="col">
            <div class="list-item">
              <div class="row">
                <div class="col">
                  <div class="form-inline title">
                    <img src="{{ URL::asset('images/icon_resume.png') }}">
                    <h4>简历统计</h4>
                  </div>
                </div>
              </div>
              <div class="row content mt-4 justify-content-start bottom text-center">
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>查看</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>查看</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>上传</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
         <hr class="divider">
         <div class="row">
          <div class="col">
            <div class="list-item">
              <div class="row">
                <div class="col">
                  <div class="form-inline title">
                    <img src="{{ URL::asset('images/icon_job.png') }}">
                    <h4>职位统计</h4>
                  </div>
                </div>
              </div>
              <div class="row content mt-4 justify-content-start bottom text-center">
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>运作职位</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>新增应聘</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>新增委托</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
         <hr class="divider">
         <div class="row">
          <div class="col">
            <div class="list-item">
              <div class="row">
                <div class="col">
                  <div class="form-inline title">
                    <img src="{{ URL::asset('images/icon_process.png') }}">
                    <h4>进度统计</h4>
                  </div>
                </div>
              </div>
              <div class="row content mt-4 justify-content-start bottom text-center">
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>电话沟通</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>推荐成功</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>进企面试</p>
                  </div>
                </div>
              </div>
              <div class="row content mt-4 justify-content-start bottom text-center">
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>面试通过</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>成功入职</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>105</h3>
                    <p>入职过保</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>
@stop
