<?php

namespace App\Tools;

use Carbon\Carbon;

class Statistic
{
    private $type;
    public $startAt;
    public $endAt;

    public function __construct($type, $startAt = null, $endAt = null)
    {
        if (!empty($startAt) && !($startAt instanceof Carbon)) {
            $startAt = Carbon::parse($startAt);
        }
        if (!empty($endAt) && !($endAt instanceof Carbon)) {
            $endAt = Carbon::parse($endAt);
        }

        if (!empty($endAt) && $endAt->hour == 0 && $endAt->minute == 0 && $endAt->second == 0) {
            $endAt = $endAt->addHours(23)->addMinutes(59)->addSecond(59);
        }

        $this->type = $type;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function queryJobStatistic(&$query)
    {
        $opTable = 'operation_job_work';
        $withArr = [
            'operation as resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 1);
                $this->queryDate($query, $opTable);
            },
            'operation as talking_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 2);
                $this->queryDate($query, $opTable);
            },
            'operation as push_resume_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 3);
                $this->queryDate($query, $opTable);
            },
            'operation as interview_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 4);
                $this->queryDate($query, $opTable);
            },
            'operation as offer_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 5);
                $this->queryDate($query, $opTable);
            },
            'operation as onboarding_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 6);
                $this->queryDate($query, $opTable);
            },
            'operation as over_probation_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 7);
                $this->queryDate($query, $opTable);
            },
            'operation as out_resumes_count' => function ($query) use ($opTable) {
                $query->where($opTable . '.status', 0);
                $this->queryDate($query, $opTable);
            }
        ];

        if ($this->type === 'user') {
            $withArr['executeJobs as jobs_count'] = function ($query) {
                $query->where('status', 1);
                $this->queryDate($query);
            };
            $withArr['executeJobs as checkpending_jobs_count'] = function ($query) {
                $query->where('status', -1);
                $this->queryDate($query);
            };
        }

        $query->withCount($withArr);

        return;
    }

    private function queryDate(&$query, $table = null)
    {
        $table = empty($table) ? '' : $table . '.';

        if (!empty($this->startAt)) {
            $query->where($table . 'created_at', '>=', $this->startAt);
        }
        if (!empty($this->endAt)) {
            $query->where($table . 'created_at', '<=', $this->endAt);
        } else {
            $query->where($table . 'created_at', '<=', Carbon::now());
        }

        return;
    }
}
