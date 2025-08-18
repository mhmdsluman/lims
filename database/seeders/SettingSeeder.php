<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $general_settings = [
            'hospital_name'            => 'Your Hospital Name',
            'hospital_short_name'      => 'YHN',
            'hospital_tagline'         => 'Compassionate Care, Advanced Medicine',
            'logo_path'                => '/storage/logos/logo.png',
            'logo_retina_path'         => '/storage/logos/logo@2x.png',
            'favicon_path'             => '/storage/logos/favicon.ico',
            'primary_color'            => '#0056b3',
            'secondary_color'          => '#00a99d',
            'accent_color'             => '#f39c12',
            'background_color'         => '#ffffff',
            'text_color'               => '#222222',
            'font_family'              => 'Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial',
            'custom_css'               => '',
            'contact_email'            => 'info@yourhospital.example',
            'contact_phone'            => '+000-000-0000',
            'contact_fax'              => '',
            'address_line1'            => '123 Health St.',
            'address_line2'            => 'Suite 100',
            'city'                     => 'Cityname',
            'state_province'           => 'State/Province',
            'postal_code'              => '00000',
            'country'                  => 'Country Name',
            'default_timezone'         => 'Africa/Mogadishu',
            'default_locale'           => 'en',
            'supported_locales'        => ['en','ar','fr','es'],
            'date_format'              => 'Y-m-d',
            'time_format'              => 'H:i',
            'datetime_format'          => 'Y-m-d H:i:s',
            'first_day_of_week'        => 1,
            'currency_code'            => 'USD',
            'currency_symbol'          => '$',
            'currency_position'        => 'prefix',
            'decimal_separator'        => '.',
            'thousand_separator'       => ',',
            'number_of_decimals'       => 2,
            'default_theme'            => 'light',
            'admin_theme'              => 'system',
            'patient_portal_theme'     => 'brand',
            'show_logo_on_reports'     => true,
            'print_header_text'        => 'Your Hospital - Official Report',
            'footer_text'              => '© {year} Your Hospital. All rights reserved.',
            'meta_description'         => 'Hospital Management System',
            'meta_keywords'            => 'hospital, clinic, health, HMS',
            'site_enabled'             => true,
            'maintenance_mode'         => false,
            'maintenance_message'      => 'The system is under maintenance. Please try again later.',
            'allow_patient_registration'=> true,
            'require_patient_approval' => true,
            'default_user_role'        => 'patient',
            'login_via_email_only'     => true,
            'allow_social_login'       => false,
            'max_upload_file_size_mb'  => 20,
            'allowed_file_types'       => ['png','jpg','jpeg','pdf','doc','docx','xls','xlsx'],
            'smtp_host'                => '',
            'smtp_port'                => 587,
            'smtp_username'            => '',
            'smtp_from_address'        => 'no-reply@yourhospital.example',
            'smtp_from_name'           => 'Your Hospital',
            'smtp_encryption'          => 'tls',
            'sms_provider'             => 'twilio',
            'sms_api_key'              => '',
            'sms_sender_id'            => 'HOSPITAL',
            'enable_appointment_reminders' => true,
            'appointment_reminder_delay_hours' => 24,
            'enable_test_result_notifications' => true,
            'result_notification_channel' => ['email','sms'],
            'critical_result_recipients'  => ['lab_manager','ordering_doctor'],
            'enable_patient_portal'     => true,
            'portal_default_language'   => 'en',
            'patient_portal_terms'      => 'Please read and accept terms.',
            'allow_portal_result_download'=> true,
            'patient_data_retention_days'=> 3650,
            'enable_patient_document_upload'=> true,
            'max_patient_documents'     => 10,
            'logo_storage_disk'         => 'public',
            'logo_storage_dir'          => 'logos',
            'cookie_consent_text'       => 'We use cookies to improve your experience.',
            'mrn_prefix'                => 'MRN',
            'mrn_next_sequence'         => 100000,
            'invoice_prefix'           => 'INV',
            'invoice_next_sequence'     => 1,
            'accession_prefix'         => 'ACC',
            'accession_next_sequence'   => 1,
            'force_https'               => true,
            'session_timeout_minutes'   => 120,
            'enable_2fa'                => false,
            'require_2fa_for_roles'     => ['admin','super-admin'],
            'password_min_length'       => 10,
            'password_require_numbers'  => true,
            'password_require_special'  => true,
            'google_maps_api_key'       => '',
            'analytics_tracking_id'     => '',
            'terms_of_service_url'      => '/legal/terms',
            'privacy_policy_url'        => '/legal/privacy',
            'show_newsfeed_on_dashboard' => true,
            'enable_quick_actions'       => true,
            'use_compact_sidebar'        => false,
            'support_email'             => 'support@yourhospital.example',
            'support_phone'             => '+000-000-0000',
            'emergency_contact'         => '+000-000-9111',
            'branding_palettes'         => [
                'default' => [
                    'primary'   => '#0056b3',
                    'secondary' => '#00a99d',
                    'accent'    => '#f39c12',
                    'text'      => '#222222',
                    'muted'     => '#6c757d',
                ],
                'alternative' => [
                    'primary' => '#2b6cb0',
                    'accent'  => '#e53e3e',
                ],
            ],
            'footer_links' => [
                ['label' => 'About Us', 'url' => '/about'],
                ['label' => 'Contact', 'url' => '/contact'],
                ['label' => 'Privacy', 'url' => '/legal/privacy'],
            ],
            'settings_version'          => '1.0.0',
            'settings_last_updated'     => date('Y-m-d H:i:s'),
        ];

        foreach ($general_settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }
    }
}
