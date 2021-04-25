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
            <ul class="nav nav-tabs mr-4" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="home"
                      aria-selected="true">
                  <h6>运作职位</h6>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="profile"
                    aria-selected="false">
                  <h6>新增应聘</h6>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="contact"
                    aria-selected="false">
                  <h6>新增委托</h6>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                    aria-selected="false">
                  <h6>新增留言</h6>
                </a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent" >
              <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="home-tab">
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
            <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="profile-tab">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="contact-tab">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"></li>
                </ul>
              </div>
            </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="general">

			</div>
		</div>
	</div>
</div>
@stop
