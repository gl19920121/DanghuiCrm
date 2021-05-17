<div class="job-detail">
    <div class="row row-cols-5">
        <div class="col-12">
            <h5>企业基本信息</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">公司名称：</span>{{ $job->company }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">招聘人数：</span>{{ $job->quota }}</p>
        </div>
    </div>
    <div class="row row-cols-4">
        <div class="col-12">
            <h5>职位基本信息</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">职位名称：</span>{{ $job->name }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">职位类别：</span>{{ $job->type->rd }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">工作性质：</span>{{ $job->nature }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">工作城市：</span>{{ $job->location->city }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">税前月薪：</span>{{ sprintf('%dK-%dK', $job->salary_min, $job->salary_max) }}</p>
        </div>
        <div class="col col-9">
            <p class="font-size-m"><span class="color-gray">福利待遇：</span>{{ $job->welfare }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">职位亮点：</span>{{ $job->sparkle }}</p>
        </div>
    </div>
    <div class="row row-cols-3">
        <div class="col-12">
            <h5>职位要求</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">年龄范围：</span>{{ sprintf('%d岁-%d岁', $job->age_min, $job->age_max) }}</p>
        </div>
    </div>
</div>
