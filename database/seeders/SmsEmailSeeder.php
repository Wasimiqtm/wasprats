<?php

namespace Database\Seeders;

use App\Models\SmsEmails;
use Illuminate\Database\Seeder;

class SmsEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsEmails::create([
            'name' => 'Invoice',
            'subject' => '[::company_name::] Invoice [::invoice_number::].',
            'description' => 'Please review the attached pdf invoice [::invoice_number::]

Thank you,
[::company_name::]
[::company_phone::]
[::company_email::]',
            'sms_text' => 'Hi [::client_first_name::], This message is from [::company_name::]. For your convenience here is a link to view your invoice [::view_invoice::] Here is a link to easily pay for your Invoice [::online_payment_link::] We appreciate your business.',
            'type' => 'default',
        ]);
        SmsEmails::create([
            'name' => 'Invoice: Request E-Signature',

            'subject' => '[::company_name::] Invoice.',
            'description' => 'Hi,

[::company_name::] has sent you a invoice to sign.

[::preview_sign_invoice::]

[::company_name::]
[::company_phone::]
[::company_email::]',
            'sms_text' => 'Hi [::client_first_name::], This message is from [::company_name::]. For your convenience here is a link to sign your invoice [::preview_sign_invoice::] Here is a link to easily pay for your Invoice. [::online_payment_link::] We appreciate your business.',
            'type' => 'default',
        ]);
    }
}
