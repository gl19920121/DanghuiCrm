<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;

// use Maatwebsite\Excel\Events\BeforeExport;
// use Maatwebsite\Excel\Events\BeforeWriting;
// use Maatwebsite\Excel\Events\BeforeSheet;

use DateTime;
use App\Exports\Sheets\JobSheet;
use App\Models\User;
use App\Models\Department;
use App\Models\Job;
use App\Models\Company;
use App\Tools\Statistic;
use Carbon\Carbon;
use Auth;

//WithMultipleSheets ShouldAutoSize FromCollection WithEvents
class JobsExport implements WithMultipleSheets
{
    // use Exportable;

    private $ids;
    private $type;
    public $startAt;
    public $endAt;

    public function __construct($ids, $type, $startAt = null, $endAt = null)
    {
        $this->ids = $ids;
        $this->type = $type;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function sheets(): array
    {
        $sheets = []; $data; $query;

        foreach ($this->ids as $item) {
            if (is_array($item)) {
                $id = $item['id'];
                $type = $item['type'];
            } else {
                $id = $item;
                $type = $this->type;
            }

            switch ($type) {
                case 'user':
                    $query = Job::where('execute_uid', $id);
                    $sheetName = User::find($id)->name;
                    break;
                case 'department':
                    $department = Department::find($id);
                    $ids = $department->users->pluck('id')->toArray();
                    $query = Job::whereIn('execute_uid', $ids);
                    $sheetName = $department->name;
                    break;
                case 'job':
                    $query = Job::where('id', $id);
                    $sheetName = Job::find($id)->name;
                    break;
                case 'company':
                    $jobsid = Job::whereIn('execute_uid', Auth::user()->departmentUser)->get()->pluck('id')->toArray();
                    $query = Job::whereIn('id', $jobsid)->where('company_id', $id);
                    $sheetName = Company::find($id)->name;
                    break;

                default:
                    break;
            }

            $Statistic = new Statistic(null, $this->startAt, $this->endAt);
            $Statistic->queryJobStatistic($query);

            $data = $query->orderBy('created_at', 'desc')->get();

            // if (!$this->hasStartAt && $data->last()->created_at->lt($this->startAt)) {
            //     $this->startAt = $data->last()->created_at;
            // }

            $sheets[] = new JobSheet($data, $sheetName, $this->startAt, $this->endAt);
        }

        return $sheets;
    }
}
