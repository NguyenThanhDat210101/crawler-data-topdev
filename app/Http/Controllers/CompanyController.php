<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\job;
use App\Models\work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Weidner\Goutte\GoutteFacade;

class CompanyController extends Controller
{
    public function getAll($ID)
    {
      //lấy link trong table work
    $work = work::where('id', $ID)->first();
    $crawler = GoutteFacade::request('GET', $work['link']);
    //lấy tên và nội dung từ thông tin công ty
    $name = $crawler->filter('h1.fwb.font-size20')->text();
    $content = $crawler->filter('div.left-cont')->text();
    //updateorcreate company
    $company = company::updateOrCreate(
        ['name' => $name],
        ['work_id' => $work->id, 'content' => $content],
    );
    //lấy id của trang từ crawler và chèn vào api
    $list_job_id = $crawler->filter('div.list-job-wrapper')->attr("id");
    $job_id = explode('-', $list_job_id);
    $response = Http::get('https://api.topdev.vn/td/v2/companies/' . $job_id[2] . '/jobs?fields[job]=id,title,detail_url');
    //số công việc của api
    $count  =  $response['aggregations']['status'][0]['doc_count'];
    //tạo aray để thực hiện wherenotin
    $array = array();
    for ($i = 0; $i < $count; $i++) {
        $array[$i] = $response['data'][$i]['title'];
    }
    // xóa các dữ liệu không còn tồn tại trong api
    job::whereNotIn('job_name',$array)->where('company_id',$company->id)->delete();
    //updateorcreate table job
    for ($i = 0; $i < $count; $i++) {
        $result =  $response['data'][$i];
        job::updateOrCreate(
            ['job_name' => $result['title']],
            ['job_link' => $result['detail_url'], 'company_id' => $company->id]
        );
    }
    //lấy data job
    $job_data = job::where('company_id', $company->id)->get();
    //return
    return view('company')->with('name', $name)
        ->with('contents', $content)
        ->with('jobdata', $job_data);
    }
}
