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
										<a href="{{ route('users.show', Auth::user()) }}" class="btn btn-danger">完善资料</a>
									</div>
								</div>
								<div class="row mt-4 justify-content-start bottom text-center">
									<div class="col-auto">
                    <div class="tip-item">
                      <h4>{{ $statistics['job_doing'] }}</h4>
                      <b>运作职位</b>
                    </div>
									</div>
									<div class="col-auto">
                    <div class="tip-item">
  										<h4 class="color-red">{{ $statistics['job_apply'] }}</h4>
  										<b>新增应聘</b>
                    </div>
									</div>
									<div class="col-auto">
                    <div class="tip-item">
  										<h4 class="color-red">{{ $statistics['job_commission'] }}</h4>
  										<b>新增委托</b>
                    </div>
									</div>
									<div class="col-auto">
                    <div class="tip-item">
  										<h4>{{ $statistics['message'] }}</h4>
  										<b>新增留言</b>
                    </div>
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
              <ul class="nav nav-tabs mr-4" role="tablist">
                <li class="nav-item">
                  <a class="nav-link @if(empty($tab) || $tab === 'jobs') active @endif" data-toggle="tab" href="#tabJobs" role="tab" aria-controls="tabJobs"
                        aria-selected="true">
                    <h6>发布职位</h6>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($tab === 'newJobs') active @endif" data-toggle="tab" href="#tabNewJobs" role="tab" aria-controls="tabNewJobs"
                      aria-selected="false">
                    <h6>新增应聘</h6>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($tab === 'newResumes') active @endif" data-toggle="tab" href="#tabCommission" role="tab" aria-controls="tabCommission"
                      aria-selected="false">
                    <h6>新增委托</h6>
                  </a>
                </li>
                <li hidden class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#tabSeen" role="tab" aria-controls="tabSeen"
                      aria-selected="false">
                    <h6>谁看过我</h6>
                  </a>
                </li>
                <li hidden class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#tabContact" role="tab" aria-controls="tabContact"
                      aria-selected="false">
                    <h6>新增留言</h6>
                  </a>
                </li>
              </ul>
              <div class="tab-content" >
                <div class="tab-pane fade @if($tab === 'jobs') show active @endif" id="tabJobs" role="tabpanel">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      @if(count($list['jobs']) > 0)
                      <table class="table table-striped default-table">
                        <thead>
                          <tr>
                            <th scope="col">职位</th>
                            <th scope="col">公司名称</th>
                            <th scope="col">发布渠道</th>
                            <th scope="col">浏览量</th>
                            <th scope="col">应聘量</th>
                            <th scope="col">更新时间</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($list['jobs'] as $job)
                            <tr>
                              <td>
                                <a class="color-red" href="{{ route('jobs.show', $job) }}">{{ $job->name }}</a>
                              </td>
                              <td>{{ $job->company->name }}</td>
                              <td>
                                @foreach ($job->channel as $index => $value)
                                  {{ App\Models\Job::channelArr[$value]['text'] }}{{ $index === 0 ? '/' : '' }}
                                @endforeach
                              </td>
                              <td>{{ $job->pv }}</td>
                              <td>{{ $job->resumes_count }}</td>
                              <td>{{ $job->updated_at }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <div class="row justify-content-end">
                        <div class="col-auto">
                          {{ $list['jobs']->appends(['tab' => 'jobs', 'njpage' => $list['newJobs']->currentPage(), 'nrpage' => $list['newResumes']->currentPage()])->links('vendor.pagination.bootstrap-4') }}
                        </div>
                      </div>
                      @else
                      <div class="empty row">
                        <div class="col text-center m-auto">
                          <img src="{{ URL::asset('images/empty.png') }}">
                          <p>您还没有运作的职位</p>
                        </div>
                      </div>
                      @endif
                    </li>
                  </ul>
                </div>
                <div class="tab-pane fade @if($tab === 'newJobs') show active @endif" id="tabNewJobs" role="tabpanel">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        @if(count($list['newJobs']) > 0)
                        <table class="table table-striped default-table">
                          <thead>
                            <tr>
                              <th scope="col">职位</th>
                              <th scope="col">公司名称</th>
                              <th scope="col">来源渠道</th>
                              <th scope="col">待处理简历</th>
                              <th scope="col">更新时间</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($list['newJobs'] as $job)
                              <tr>
                                <td>{{ $job->name }}</td>
                                <td>{{ $job->company->name }}</td>
                                <td>
                                  @foreach ($job->channel as $index => $value)
                                    {{ App\Models\Job::channelArr[$value]['text'] }}{{ $index === 0 ? '/' : '' }}
                                  @endforeach
                                </td>
                                <td>{{ $job->resumes_count }}</td>
                                <td>{{ $job->updated_at }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>

                        <div class="row justify-content-end">
                          <div class="col-auto">
                            {{ $list['newJobs']->appends(['tab' => 'newJobs', 'jobs' => $list['jobs']->currentPage(), 'nrpage' => $list['newResumes']->currentPage()])->links('vendor.pagination.bootstrap-4') }}
                          </div>
                        </div>
                        @else
                        <div class="empty row">
                          <div class="col text-center m-auto">
                            <img src="{{ URL::asset('images/empty.png') }}">
                            <p>您还没有新增的应聘</p>
                          </div>
                        </div>
                        @endif
                      </li>
                    </ul>
                </div>
                <div class="tab-pane fade @if($tab === 'newResumes') show active @endif" id="tabCommission" role="tabpanel">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        @if(count($list['newResumes']) > 0)
                          @foreach($list['newResumes'] as $resume)
                            <div class="commission">
                              <div class="row justify-content-between">
                                <div class="col col-auto">
                                  <p class="color-light-gray font-size-s">ID:{{ $resume->no }}</p>
                                </div>
                                <div class="col col-auto">
                                  <p class="color-light-gray font-size-s">投递时间：{{ $job->created_at }}</p>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col col-auto">
                                  <img src="{{ URL::asset('images/avatar_default.png') }}">
                                </div>
                                <div class="col">
                                  <p class="color-red">
                                    {{ $resume->name }}<span>|</span>{{ $resume->sex }}<span>|</span>{{ sprintf('%s岁', $resume->age) }}<span>|</span>{{ $resume->city }}<span>|</span>{{ $resume->education }}<span>|</span>{{ sprintf('工作%s年', $resume->work_years) }}
                                  </p>
                                  <p>最高学历：</p>
                                  <p>近期工作：</p>
                                  <p>
                                    <span>求职者状态：</span>
                                    <span class="ml-2">来源渠道：</span>
                                  </p>
                                  <p>委托职位：<span class="color-red">{{ $resume->job->name }}</span></p>
                                </div>
                                <div class="col col-auto align-self-end">
                                  <button class="btn btn-danger">沟通邀请</button>
                                </div>
                              </div>
                            </div>
                          @endforeach
                        <div class="row justify-content-end">
                          <div class="col-auto">
                            {{ $list['newResumes']->appends(['tab' => 'newResumes', 'jobs' => $list['jobs']->currentPage(), 'njpage' => $list['newJobs']->currentPage()])->links('vendor.pagination.bootstrap-4') }}
                          </div>
                        </div>
                        @else
                        <div class="empty row">
                          <div class="col text-center m-auto">
                            <img src="{{ URL::asset('images/empty.png') }}">
                            <p>您还没有新增的委托</p>
                          </div>
                        </div>
                        @endif
                      </li>
                    </ul>
                </div>
                <div hidden class="tab-pane fade" id="tabSeen" role="tabpanel">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <div class="empty row">
                        <div class="col text-center m-auto">
                          <img src="{{ URL::asset('images/empty.png') }}">
                          <p>还没有人看过您</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div hidden class="tab-pane fade" id="tabContact" role="tabpanel">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <div class="empty row">
                        <div class="col text-center m-auto">
                          <img src="{{ URL::asset('images/empty.png') }}">
                          <p>您还没有新增的留言</p>
                        </div>
                      </div>
                    </li>
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
            <p>满意指数：<span class="color-red">0</span></p>
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
                    <h3>{{ $statistics['resume_check'] }}</h3>
                    <p>查看</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['resume_download'] }}</h3>
                    <p>下载</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['resume_upload'] }}</h3>
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
                    <h3>{{ $statistics['job_doing'] }}</h3>
                    <p>运作职位</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['job_apply'] }}</h3>
                    <p>新增应聘</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['job_commission'] }}</h3>
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
                    <h3>{{ $statistics['schedule_talking'] }}</h3>
                    <p>电话沟通</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['schedule_push_resume'] }}</h3>
                    <p>推荐成功</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['schedule_interview'] }}</h3>
                    <p>进企面试</p>
                  </div>
                </div>
              </div>
              <div class="row content mt-4 justify-content-start bottom text-center">
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['schedule_offer'] }}</h3>
                    <p>面试通过</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['schedule_onboarding'] }}</h3>
                    <p>成功入职</p>
                  </div>
                </div>
                <div class="col">
                  <div class="item-content">
                    <h3>{{ $statistics['schedule_over_probation'] }}</h3>
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
