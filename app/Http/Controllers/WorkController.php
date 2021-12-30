<?php

namespace App\Http\Controllers;

use App\Models\work;
use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade;

class WorkController extends Controller
{
    public function getAll()
    {
           //crawler dữ liệu từ url
    $crawler = GoutteFacade::request('GET', 'https://topdev.vn/viec-lam-it/php,c-sharp-da-nang-kt1,24l48');

    $name = $crawler->filter('div.col-12.company_item>div>div>h3>a.job-title.mb-1.js_add_utm.c--primary')->each(function ($node) {
        return $node->text();
    });
    $link = $crawler->filter('div.col-12.company_item>div>div>h3>a.job-title.mb-1.js_add_utm.c--primary')->each(function ($node) {
        $url = 'https://topdev.vn' . $node->attr("href");
        return str_replace(' ', '', $url);
    });
    $address = $crawler->filter('div.job-bottom.mb-0>p.job-location.fl.mb-1')->each(function ($node) {
        return $node->text();
    });
    $nationality = $crawler->filter('p.company_nationality')->each(function ($node) {
        return $node->text();
    });
    $size_of = $crawler->filter('p.company_size')->each(function ($node) {
        return $node->text();
    });
    $tech_stack = $crawler->filter('p.company_skill')->each(function ($node) {
        return $node->text();
    });
    //updateorcreate work
    for ($i = 0; $i < count($name); $i++) {
        if (isset($address[$i]) && isset($nationality[$i]) && isset($size_of[$i]) && isset($tech_stack[$i])) {
            work::updateOrCreate(
                [
                    'name' => $name[$i],
                    'link' => $link[$i]
                ],
                [
                    'address' => $address[$i],
                    'national' => $nationality[$i],
                    'sizeOf' => $size_of[$i],
                    'skill' => $tech_stack[$i]
                ],
            );
        } else {
            work::updateOrCreate(
                ['name' => $name[$i], 'link' => $link[$i]],
                ['address' => null],
                ['national' => null],
                ['sizeOf' => null],
                ['skill' => null]
            );
        }
    }
    //return
    return view('work')->with('data', work::all());
    }
}
