<?php

namespace App\Exports\Sheets;

// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use App\Models\Job;

class JobSheet implements FromCollection, WithTitle, WithEvents
{
    private $data;
    private $sheetName;
    private $startAt;
    private $endAt;

    public function __construct($data, $sheetName, $startAt = null, $endAt = null)
    {
        $this->data = $data;
        $this->sheetName = $sheetName;
        $this->startAt = $startAt;
        $this->endAt = empty($endAt) ? Carbon::now() : $endAt;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->sheetName;
    }

    public function collection()
    {
        $rows = collect();
        foreach ($this->data as $job) {
            $item = [
                'user_name' => $job->executeUser->name,
                'company_name' => $job->company->name,
                'job_name' => $job->name,
                'resumes_count' => (string)$job->resumes_count,
                'talking_resumes_count' => (string)$job->talking_resumes_count,
                'push_resume_resumes_count' => (string)$job->push_resume_resumes_count,
                'interview_resumes_count' => (string)$job->interview_resumes_count,
                'offer_resumes_count' => (string)$job->offer_resumes_count,
                'out_resumes_count' => (string)$job->out_resumes_count,
                'over_probation_resumes_count' => (string)$job->over_probation_resumes_count,
                'onboarding_resumes_count' => (string)$job->onboarding_resumes_count,
            ];
            $rows->push($item);
        }

        if (empty($this->startAt)) {
            $rowDate = array(sprintf('统计时间（至%s）', $this->endAt->format('Y/m/d')));
        } else if ($this->endAt->diffInDays($this->startAt) === 0) {
            $rowDate = array(sprintf('统计时间（%s）', $this->endAt->format('Y/m/d')));
        } else {
            $rowDate = array(sprintf('统计时间（%s-%s）', $this->startAt->format('Y/m/d'), $this->endAt->format('Y/m/d')));
        }

        $rowSum = array('总计', null, null, (string)$this->data->pluck('resumes_count')->sum(), null, null, null, null, null, (string)$this->data->pluck('over_probation_resumes_count')->sum(), (string)$this->data->pluck('onboarding_resumes_count')->sum());
        $rowTitle = [
            'user_name' => '员工名称',
            'company_name' => '企业名称',
            'job_name' => '职位名称',
            'resumes_count' => '筛选简历',
            'talking_resumes_count' => '电话沟通',
            'push_resume_resumes_count' => '推荐简历',
            'interview_resumes_count' => '面试',
            'offer_resumes_count' => 'OFFER',
            'out_resumes_count' => '淘汰',
            'over_probation_resumes_count' => '过保',
            'onboarding_resumes_count' => '入职',
        ];

        $rows->prepend($rowTitle);
        $rows->prepend($rowDate);
        $rows->push(array(null));
        $rows->push(array(null));
        $rows->push($rowSum);

        return $rows;
    }

    /**
     * 注册事件
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lines = 50;
                $cols = ['A' => 20.14, 'B' => 47.29, 'C' => 42.14, 'D' => 18.43, 'E' => 18.43, 'F' => 18.43, 'G' => 18.43, 'H' => 18.43, 'I' => 18.43, 'J' => 18.43, 'K' => 18.43, 'L' => 18.43, 'M' => 18.43];
                $sumLine = 5 + count($this->data);
                $event->sheet->setTitle($this->sheetName); // 设置标题
                $event->sheet->getDelegate()->mergeCells('A1:K1'); // 合并单元格
                $event->sheet->getDelegate()->getStyle('A1:K1265')->getAlignment()->setHorizontal('center'); // 设置区域单元格垂直居中
                $event->sheet->getDelegate()->getStyle('A1:K1265')->getAlignment()->setVertical('center'); // 设置区域单元格垂直居中
                foreach ($cols as $no => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($no)->setWidth($width); // 设置列宽
                }
                for ($i = 0; $i < $lines; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(33.75); // 设置行高
                }
                // 设置区域单元格字体、颜色、背景等
                $event->sheet->getDelegate()->getStyle('A2:K2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle("A$sumLine")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
                $event->sheet->getDelegate()->getStyle("D$sumLine")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFBFBF');
                $event->sheet->getDelegate()->getStyle("J$sumLine")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFBFBF');
                $event->sheet->getDelegate()->getStyle("K$sumLine")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFBFBF');
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => '000000'
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'ffff00',
                        ],
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('C2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => 'ffffff'
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'C0504D',
                        ],
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('D2')->applyFromArray([
                    'font' => [
                        'color' => [
                            'rgb' => 'ffffff'
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => '00B050',
                        ],
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('K2')->applyFromArray([
                    'font' => [
                        'color' => [
                            'rgb' => 'ffffff'
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => '31869B',
                        ],
                    ],
                ]);
            },
        ];
    }
}
