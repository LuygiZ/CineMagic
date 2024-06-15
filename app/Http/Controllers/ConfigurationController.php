<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigurationFormRequest;
use App\Models\Configuration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ConfigurationController extends Controller
{
    public function index() : View
    {

        $configuration = Configuration::first();

        return view('configurations.index', compact('configuration'));

    }

    public function edit() : View
    {
        $configuration = Configuration::first();

        return view('configurations.edit', compact('configuration'));

    }


    public function update(ConfigurationFormRequest $request): RedirectResponse
    {
        $configuration = Configuration::first();

        if($request->validated()){
            $configuration->ticket_price = $request->ticketPrice;
            $configuration->registered_customer_ticket_discount = $request->newCustomerDiscount;
            $configuration->save();
        }
        
        $htmlMessage = "Configurations updated successfully!";
        return redirect()->route('configurations.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
