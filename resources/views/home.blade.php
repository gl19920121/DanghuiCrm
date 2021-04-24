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
							<div class="col-2 pl-4 pt-3">
								<img src="{{ URL::asset('images/welcome.png') }}">
							</div>
							<div class="col pl-5">
								<div class="row align-items-center justify-content-end top mr-4">
									<div class="col">
										<h5>HI 亲爱的<span>{{ Auth::user()->name }}</span>，欢迎回到当会~</h5>
										<p>没有特别幸运，那么请先特别努力</p>
									</div>
									<div class="col text-right">
										<button class="btn btn-danger">完善资料</button>
									</div>
								</div>
								<div class="row mt-2 text-center">
									<div class="col">
										<b>10</b><br>
										<b>运作职位</b>
									</div>
									<div class="col">
										<b>10</b><br>
										<b>新增应聘</b>
									</div>
									<div class="col">
										<b>10</b><br>
										<b>新增委托</b>
									</div>
									<div class="col">
										<b>10</b><br>
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