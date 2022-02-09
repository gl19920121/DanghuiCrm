<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
// use Maatwebsite\Excel\Events\BeforeExport;
// use Maatwebsite\Excel\Events\BeforeWriting;
// use Maatwebsite\Excel\Events\BeforeSheet;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

use App\Models\User;

//WithMultipleSheets ShouldAutoSize
class JobsExport implements FromCollection, WithEvents
{
    // use Exportable;

    private $user;
    private $data;
    private $colTitle;
    private $startAt;
    private $endAt;

    public function __construct($user, $data, $colTitle, $startAt, $endAt)
    {
        $this->user = $user;
        $this->data = $data;
        $this->colTitle = $colTitle;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function collection()
    {
        // return new Collection($this->createData());
        return collect($this->createData());
    }

    public function createData()
    {
        $rows = $this->data;
        $date = array(sprintf('统计时间（%s-%s）', $this->startAt->format('Y/m/d'), $this->endAt->format('Y/m/d')));
        $sum = array('总计', null, null, (string)array_sum(array_column($this->data, 'resume_count')), null, null, null, null, null, (string)array_sum(array_column($this->data, 'resume_over_probation_count')), (string)array_sum(array_column($this->data, 'resume_onboarding_count')));
        array_unshift($rows, $date, $this->colTitle);
        array_push($rows, array(null), array(null), $sum);

        // dd($rows);
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
                $event->sheet->setTitle($this->user->name); // 设置标题
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
