<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\WorkController@getAll');

Route::get('company/{ID}', 'App\Http\Controllers\CompanyController@getAll');

Route::get('workofcompany/{id}','App\Http\Controllers\WOCController@FunctionName');

// Route::get('test', function () {
//     $data = [];
//     $ch = curl_init('https://topdev.vn/it-jobs/load-more-company');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         'Content-Type: application/json',
//         'Content-Length: ' . strlen($data_string))
//     );
//     // execute!
//     $response = curl_exec($ch);
//     // close the connection, release resources used
//     curl_close($ch);
//     // do anything you want with your response
//     var_dump($response);
// });
