<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayPalReportUploadRequest;
use Illuminate\Http\Request;
use League\Csv\Reader;

class FinanceController extends Controller
{
    public function showUploadForm()
    {
        return view('finance.upload-report');
    }

    public function processUploadForm(PayPalReportUploadRequest $request)
    {
        $csv = Reader::createFromPath($request->file('report'), 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        dd($csv->getContent());
    }
}
