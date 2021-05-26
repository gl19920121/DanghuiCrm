<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Job;

class WordController extends Controller
{
    public function exportJob(Job $job)
    {
        $phpword = new PHPWord(); //实例化phpword类
        $section = $phpword->addSection(); //整体页面

        $fontStyle2 = array('align' => 'center');
        $phpword->addTitleStyle(1, ['bold' => true, 'color' => '000', 'size' => 17, 'name' => '宋体'], $fontStyle2); //title样式

        $section->addTitle($job->name);
        $section->addText("职位编号：$job->no                                                                       更新时间：$job->updated_at");

        //表格样式
        $styleTable = [
            'borderColor' => '006699',
            'borderSize' => 6,
            'cellMargin' => 50,
        ]; //整体样式
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center'); // 设置可跨行，且文字在居中
        $cellRowContinue = array('vMerge' => 'continue'); //使行连接，且无边框线
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center'); //设置跨列
        $cellColSpans = array('gridSpan' => 4, 'valign' => 'center'); //设置跨列
        $cellHCentered = array('align' => 'center'); //居中
        $cellVCentered = array('valign' => 'center'); //居中

        //字体样式
        $styleFoun = array('name' => '宋体', 'size'=> 13);
        $styleFouns = array('name' => '黑体', 'size'=> 13);

        //表格
        $phpword->addTableStyle('table', $styleTable);
        $table = $section->addTable('table');

        //表格内容填充
        //第一行
        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('企业基本信息',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('公司名称', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->company->name, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('所在地', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->company->locationShow, $styleFouns, $cellHCentered);

        //第二行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText("所属行业", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->company->industryShow, $styleFouns,$cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText("企业性质", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->company->natureShow, $styleFouns,$cellHCentered);

        //第三行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText("企业规模", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->company->scaleShow, $styleFouns,$cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText("融资阶段", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->company->investmentShow, $styleFouns,$cellHCentered);

        //第三行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText("招聘人数", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellColSpan)->addText($job->quota, $styleFouns,$cellHCentered);

        //第四行
        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('职位基本信息',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('职位名称', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->name, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('职位类别', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->typeShow, $styleFouns, $cellHCentered);

        //第五行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('工作性质', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->natureShow, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('工作城市', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->location->city, $styleFouns, $cellHCentered);

        //第六行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('税前月薪', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->salaryShow, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('福利待遇', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->welfareShow, $styleFouns, $cellHCentered);

        //第七行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('职位亮点', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellColSpan)->addText($job->sparkle, $styleFouns, $cellHCentered);

        //第八行
        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('职位要求',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('年龄范围', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->ageShow, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('学历要求', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->educationShow, $styleFouns, $cellHCentered);

        //第八行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('经验要求', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellColSpan)->addText($job->experienceShow, $styleFouns, $cellHCentered);

        //第九行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('工作职责', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellColSpan)->addText($job->salaryShow, $styleFouns, $cellHCentered);

        //第十行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('任职要求', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellColSpan)->addText($job->requirement, $styleFouns, $cellHCentered);

        //第十一行
        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('职位备注',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('紧急程度', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->urgencyLevelShow, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('发布渠道', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($job->channelShow, $styleFouns, $cellHCentered);

        //第十一行
        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('截止日期', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellColSpan)->addText($job->deadline, $styleFouns, $cellHCentered);

        // 保存文件
        $fileName = "$job->name.docx";
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
        $writer->save($fileName);
        $files = base_path() . "/public/$fileName";
        $name = basename($files);
        return response()->download($files, $name, $headers = ['Content-Type'=>'application/zip;charset=utf-8']);
    }
}
