<?php

namespace App\Http\Controllers;

use App\Models\job;
use App\Models\workofcompany;
use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade;

class WOCController extends Controller
{
    public function FunctionName($id)
    {
        //lấy job
    $job = job::where('id', $id)->first();
    //crawler dữ liệu
    $crawler = GoutteFacade::request('GET', $job['job_link']);
    $job_name = $crawler->filter('h1.font-size20.mb-2.c--primary')->text();
    $job_detail = $crawler->filter('div.left-cont')->html();
    //update or create
     workofcompany::updateOrCreate(
        ['nominee'=>$job_name],
        ['content_job'=>$job_detail,'job_id' =>$job['id']]
     );
    //return
    return view('work_of_company')->with('jobdetail',$job_detail);

    }
}
