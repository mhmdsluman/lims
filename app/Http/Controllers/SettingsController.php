<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::all()->keyBy('key')->map(function ($setting) {
            $value = json_decode($setting->value, true);
            // If json_decode fails, it returns null, so we use the original value.
            return is_null($value) ? $setting->value : $value;
        });

        return Inertia::render('Settings/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->all();

        foreach ($validatedData as $key => $value) {
            $setting = Setting::firstOrNew(['key' => $key]);

            $valueToStore = is_array($value) ? json_encode($value) : $value;

            $setting->value = $valueToStore;
            $setting->save();
        }

        return Redirect::route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
