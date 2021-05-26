<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class PdfController extends Controller
{
    public function exportJob(Job $job)
    {
        $pdf = new \TCPDF();
        // 设置文档信息
        $pdf->SetCreator('当会直聘');
        $pdf->SetAuthor('当会直聘');
        $pdf->SetTitle($job->name);
        $pdf->SetSubject($job->name);
        // $pdf->SetKeywords('TCPDF, PDF, PHP');

        // 设置页眉和页脚信息
        $pdf->SetHeaderData('', 0, 'www.danghui.com', '当会直聘', [0, 64, 255], [0, 64, 128]);
        $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

        // 设置页眉和页脚字体
        $pdf->setHeaderFont(['stsongstdlight', '', '10']);
        $pdf->setFooterFont(['helvetica', '', '8']);

        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('courier');

        // 设置间距
        $pdf->SetMargins(15, 15, 15);//页面间隔
        $pdf->SetHeaderMargin(5);//页眉top间隔
        $pdf->SetFooterMargin(10);//页脚bottom间隔

        // 设置分页
        $pdf->SetAutoPageBreak(true, 25);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        //设置字体 stsongstdlight支持中文
        $pdf->SetFont('stsongstdlight', '', 14);

        //第一页
        $pdf->AddPage();
        $pdf->Ln(5);
        $pdf->writeHTML('<h3>企业基本信息</h3>');
        $pdf->writeHTML(sprintf('<p>公司名称：%s</p>', $job->company->name));
        $pdf->writeHTML(sprintf('<p>所在地：%s</p>', $job->company->locationShow));
        $pdf->writeHTML(sprintf('<p>所属行业：%s</p>', $job->company->industryShow));
        $pdf->writeHTML(sprintf('<p>企业性质：%s</p>', $job->company->natureShow));
        $pdf->writeHTML(sprintf('<p>企业规模：%s</p>', $job->company->scaleShow));
        $pdf->writeHTML(sprintf('<p>融资阶段：%s</p>', $job->company->investmentShow));
        $pdf->writeHTML(sprintf('<p>招聘人数：%s</p>', $job->quota));
        $pdf->Ln(5);
        $pdf->writeHTML('<h3>职位基本信息</h3>');
        $pdf->writeHTML(sprintf('<p>职位名称：%s</p>', $job->name));
        $pdf->writeHTML(sprintf('<p>职位类别：%s</p>', $job->typeShow));
        $pdf->writeHTML(sprintf('<p>工作性质：%s</p>', $job->natureShow));
        $pdf->writeHTML(sprintf('<p>工作城市：%s</p>', $job->locationShow));
        $pdf->writeHTML(sprintf('<p>税前月薪：%s</p>', $job->salaryShow));
        $pdf->writeHTML(sprintf('<p>福利待遇：%s</p>', $job->welfareShow));
        $pdf->writeHTML(sprintf('<p>职位亮点：%s</p>', $job->sparkle));
        $pdf->Ln(5);
        $pdf->writeHTML('<h3>职位要求</h3>');
        $pdf->writeHTML(sprintf('<p>年龄范围：%s</p>', $job->ageShow));
        $pdf->writeHTML(sprintf('<p>学历要求：%s</p>', $job->educationShow));
        $pdf->writeHTML(sprintf('<p>经验要求：%s</p>', $job->experienceShow));
        $pdf->writeHTML(sprintf('<p>工作职责：%s</p>', $job->duty));
        $pdf->writeHTML(sprintf('<p>任职要求：%s</p>', $job->requirement));
        $pdf->Ln(5);
        $pdf->writeHTML('<h3>职位备注</h3>');
        $pdf->writeHTML(sprintf('<p>紧急程度：%s</p>', $job->urgencyLevelShow));
        $pdf->writeHTML(sprintf('<p>发布渠道：%s</p>', $job->channelShow));
        $pdf->writeHTML(sprintf('<p>截止日期：%s</p>', $job->deadline));

        //第二页
        // $pdf->AddPage();

        //输出PDF
        $fileName = sprintf('%s.pdf', $job->name);
        $pdf->Output($fileName, 'D'); //I输出、D下载
    }
}
