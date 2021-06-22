<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Job;
use App\Models\Resume;
use App\Models\ResumeUser;
use App\Models\User;
// use Illuminate\Support\Facades\Storage;
use Auth;
use ZipArchive;

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
        $table->addCell(5000, $cellVCentered)->addText($job->location['city'], $styleFouns, $cellHCentered);

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
        return response()->download($files, $name, $headers = ['Content-Type'=>'application/zip;charset=utf-8'])->deleteFileAfterSend(true);
    }

    public function exportResume(Resume $resume)
    {
        $fileName;
        $phpword = $this->createResume($resume, $fileName);
        $this->downloadResume($phpword, $fileName);
    }

    public function exportUserResume(User $user)
    {
        $fnameZip = "$user->name-简历统计.zip";
        $zip = new ZipArchive();
        if ($zip->open($fnameZip, ZIPARCHIVE::CREATE) !== TRUE) {
            return;
        }

        $fileNames = [];
        foreach ($user->uploadResumes as $index => $resume) {
            $fileName; $filePath;
            $phpword = $this->createResume($resume, $fileName);

            $this->saveResume($phpword, $fileName);

            if (file_exists($fileName)) {
                $zip->addFile($fileName);
            }

            $fileNames[] = $fileName;
        }

        $zip->close();
        if (!file_exists($fnameZip)){
            return;
        }

        foreach ($fileNames as $fileName) {
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }

        $files = base_path() . "/public/$fnameZip";
        $name = basename($files);
        return response()->download($files, $name, $headers = ['Content-Type'=>'application/zip;charset=utf-8'])->deleteFileAfterSend(true);
    }

    private function createResume($resume, &$fileName)
    {
        ResumeUser::store($resume->id, Auth::user()->id, 'download');

        $phpword = new PHPWord(); //实例化phpword类
        $section = $phpword->addSection(); //整体页面
        $header = $section->createHeader();

        // $header->addWatermark(base_path().'/public/images/bg_1.jpg');

        $fontStyle2 = array('align' => 'center');
        $phpword->addTitleStyle(1, ['bold' => true, 'color' => '000', 'size' => 17, 'name' => '宋体'], $fontStyle2); //title样式

        $section->addTitle($resume->name);
        $section->addText("简历编号：$resume->no                                                                       更新时间：$resume->updated_at");

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
        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('个人信息',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('姓名', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->name, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('求职状态', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->jobhunter_status_show, $styleFouns, $cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText("性别", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->sex, $styleFouns,$cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText("所在城市", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->location['city'], $styleFouns,$cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText("教育程度", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->education_show, $styleFouns,$cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText("工作年限", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->work_years_show_long, $styleFouns,$cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText("所在行业", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->cur_industry_show, $styleFouns,$cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText("所在公司", $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->cur_company, $styleFouns,$cellHCentered);

        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('职位基本信息',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('手机号', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->phont_num, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('电子邮箱', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->email, $styleFouns, $cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('微信号', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->wechat, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('QQ号', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->qq, $styleFouns, $cellHCentered);

        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('职业期望',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('期望职位', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->exp_position_show, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('期望城市', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->exp_location['city'], $styleFouns, $cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('期望薪资', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->exp_salary_show, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('目前薪资', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->cur_salary_show_short, $styleFouns, $cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('期望行业', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->exp_industry_show, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('所在行业', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->cur_industry_show, $styleFouns, $cellHCentered);

        $table->addRow(500);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(5000, $cellVCentered)->addText('工作性质', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->exp_work_nature_show, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('勿推企业', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->blacklist, $styleFouns, $cellHCentered);

        foreach ($resume->resumeWorks as $index => $work) {
            $table->addRow(500);
            if ($index === 0) {
                $table->addCell(5000, $cellRowSpan)->addText('工作经历',
                    $styleFoun, $cellHCentered);
            } else {
                $table->addCell(null, $cellRowContinue);
            }
            $table->addCell(5000, $cellColSpans)->addText(sprintf('%s（工作时间：%s，%s）', $work->company_name, $work->duration, $work->long), $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellColSpans)->addText(sprintf('%s %s %s', $work->company_industry_show, $work->company_scale_show, $work->company_investment_show), $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('所任职位', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellVCentered)->addText($work->job_type['nd'], $styleFouns, $cellHCentered);
            $table->addCell(5000, $cellVCentered)->addText('下属人数', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellVCentered)->addText($work->subordinates, $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('职位类别', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellVCentered)->addText($work->job_type['rd'], $styleFouns, $cellHCentered);
            $table->addCell(5000, $cellVCentered)->addText('薪资', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellVCentered)->addText($work->salary_show, $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('工作描述', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellColSpan)->addText($work->work_desc, $styleFouns, $cellHCentered);
        }

        foreach ($resume->resumePrjs as $index => $project) {
            $table->addRow(500);
            if ($index === 0) {
                $table->addCell(5000, $cellRowSpan)->addText('项目经历',
                    $styleFoun, $cellHCentered);
            } else {
                $table->addCell(null, $cellRowContinue);
            }
            $table->addCell(5000, $cellColSpans)->addText(sprintf('%s（项目时间：%s，%s）', $project->name, $project->duration, $project->long), $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('担任角色', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellColSpan)->addText($project->role, $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('项目内容', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellColSpan)->addText($project->body, $styleFouns, $cellHCentered);
        }

        foreach ($resume->resumeEdus as $index => $eduction) {
            $table->addRow(500);
            if ($index === 0) {
                $table->addCell(5000, $cellRowSpan)->addText('教育经历',
                    $styleFoun, $cellHCentered);
            } else {
                $table->addCell(null, $cellRowContinue);
            }
            $table->addCell(5000, $cellVCentered)->addText('毕业院校', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellColSpan)->addText(sprintf('%s（%s）', $eduction->school_name, $eduction->duration), $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('学历', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellColSpan)->addText($eduction->school_level_show, $styleFouns, $cellHCentered);

            $table->addRow(500);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(5000, $cellVCentered)->addText('所学专业', $styleFoun, $cellHCentered);
            $table->addCell(5000, $cellColSpan)->addText($eduction->major, $styleFouns, $cellHCentered);
        }

        $table->addRow(500);
        $table->addCell(5000, $cellRowSpan)->addText('附加信息',
                $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('社交主页', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->social_home, $styleFouns, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText('个人优势', $styleFoun, $cellHCentered);
        $table->addCell(5000, $cellVCentered)->addText($resume->personal_advantage, $styleFouns, $cellHCentered);

        $fileName = "$resume->name.docx";
        return $phpword;
    }

    private function saveResume($phpword, $fileName)
    {
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
        $writer->save($fileName);
    }

    private function downloadResume($phpword, $fileName)
    {
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
        $writer->save("php://output");
    }
}
