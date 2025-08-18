<?php

namespace App\Http\Middleware;
use App\Libraries\Ziggy\Ziggy;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            // Add this for i18n
            'locale' => function () {
                return app()->getLocale();
            },
            'language' => function () {
                if (file_exists(resource_path('lang/'. app()->getLocale() .'.json'))) {
                    return json_decode(file_get_contents(resource_path('lang/'. app()->getLocale() .'.json')), true);
                }
                return [];
            },
            'settings' => [
                'hospital_name' => config('settings.hospital_name'),
                'hospital_short_name' => config('settings.hospital_short_name'),
                'hospital_tagline' => config('settings.hospital_tagline'),
                'allow_patient_registration' => config('settings.allow_patient_registration'),
                'footer_text' => config('settings.footer_text'),
            ],
            // Add this to handle flash messages
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
