<?php

namespace App\Http\Controllers;

use App\Http\Requests\DependentWaiverRequest;
use App\Http\Requests\IndividualWaiverRequest;
use App\Mail\WaiverSigned;
use App\Waiver;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WaiverController extends Controller
{
    public function index()
    {
        return view('waivers.index');
    }

    public function admin()
    {
        $waivers = Waiver::all();

        return view('waivers.admin')->with('waivers', $waivers);
    }

    public function individual()
    {
        return view('waivers.individual');
    }

    public function dependent()
    {
        return view('waivers.dependent');
    }

    public function saveIndividualWaiver(IndividualWaiverRequest $request)
    {
        $birth_date = new Carbon($request->birth_date);

        $waiver = new Waiver();
        $waiver->between_name = $request->between_name;
        $waiver->initial_1 = $request->initial_1;
        $waiver->name = $request->name;
        $waiver->address = $request->address;
        $waiver->phone = $request->phone;
        $waiver->email = $request->email;
        $waiver->contact_name = $request->contact_name;
        $waiver->contact_phone = $request->contact_phone;
        $waiver->birth_date = $birth_date->toDateTimeString();
        $waiver->signature = $request->signature;
        $waiver->save();

        $this->renderIndividualWaiver($waiver);

        if (env('DB_USERNAME') !== 'travis') {
            $this->emailWaiver($waiver);
        }

        return redirect()->action('WaiverController@index');
    }

    public function renderIndividualWaiver($waiver)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('Letter', 'portrait');
        $pdf->loadView('waivers.individual-render', $waiver);
        $output = @$pdf->output();
        $file_name = storage_path().'/waivers/'.$waiver->id.'.pdf';
        file_put_contents($file_name, $output);
    }

    public function saveDependentWaiver(DependentWaiverRequest $request)
    {
        $waiver = new Waiver();
        $waiver->between_name = $request->between_name;
        $waiver->initial_1 = $request->initial_1;
        $waiver->name = $request->name;
        $waiver->address = $request->address;
        $waiver->phone = $request->phone;
        $waiver->email = $request->email;
        $waiver->contact_name = $request->contact_name;
        $waiver->contact_phone = $request->contact_phone;
        $waiver->dependents = $request->dependents;
        $waiver->signature = $request->signature;
        $waiver->save();

        $this->renderDependentWaiver($waiver);
        $this->emailWaiver($waiver);

        return redirect()->action('WaiverController@index');
    }

    public function renderDependentWaiver($waiver)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('Letter', 'portrait');
        $pdf->loadView('waivers.dependent-render', $waiver);
        $output = @$pdf->output();
        $file_name = storage_path().'/waivers/'.$waiver->id.'.pdf';
        file_put_contents($file_name, $output);
    }

    public function emailWaiver($waiver)
    {
        Mail::to($waiver->email)->send(new WaiverSigned($waiver));
    }

    public function downloadWaiver($request)
    {
        $waiver = Waiver::find($request);

        if (! $waiver) {
            throw new BadRequestHttpException('Bad Request');
        }

        $file = storage_path('waivers/'.$waiver->id.'.pdf');
        $headers = [
            'Content-Type: application/pdf',
        ];

        return Response::download($file, 'MidsouthMakers-Waiver.pdf', $headers);
    }
}
