<?php
 
namespace App\Http\Controllers\Update;
 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Artisan;
use DB;

class UpdateController extends Controller
{
   
    /**
     * Start upgrading to latest version
     *
     * @return void
     */
    public function update()
    {
        try {
            
            // Check if update file exists, or application is up to date
            if (!File::exists(base_path('updating'))) {
                return redirect('/');
            }

            // Drop old tables
            Schema::dropIfExists('paystack_settings');
            Schema::dropIfExists('cashfree_settings');
            Schema::dropIfExists('xendit_settings');
            Schema::dropIfExists('offline_payment_settings');
            Schema::dropIfExists('settings_appearance');
            Schema::dropIfExists('settings_gateways');

            // Delete migrations
            DB::table('migrations')->whereIn('migration', [
                '2022_10_06_143113_create_paystack_settings_table',
                '2022_10_08_103551_create_cashfree_settings_table',
                '2022_10_08_170526_create_xendit_settings_table',
                '2022_09_25_150145_create_offline_payment_settings_table',
                '2022_09_24_060850_create_settings_appearance_table',
                '2022_07_11_104415_create_settings_gateways_table',
                '2022_10_11_163414_add_custom_fonts_to_settings_appearance_table'
            ])->delete();

            // Run migration
            Artisan::call('migrate', [ '--force' => true ]);

            // After that we need to run seeders
            Artisan::call('db:seed', [ '--class' => 'PaystackSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'CashfreeSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'XenditSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'FlutterwaveSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'JazzcashSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'MercadopagoSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'MollieSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'OfflinePaymentSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'PaymobSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'PaypalSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'PaytabsSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'PaytrSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'ProjectsSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'ProjectsSubscriptionsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'RazorpaySettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'SettingsAppearanceTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'StripeSettingsTableSeeder', '--force' => true ]);
            Artisan::call('db:seed', [ '--class' => 'VnpaySettingsTableSeeder', '--force' => true ]);

            // Clear settings appearance
            settings('appearance', true);

            // Clear cache
            Artisan::call('view:clear');
            Artisan::call('config:clear');

            // Delete update file
            File::delete(base_path('updating'));
            
            // Delete folder
            if (File::exists(app_path('Http/Controllers/Update'))) {
                File::deleteDirectory( app_path('Http/Controllers/Update') );
            }

            // Redirect
            return redirect('/');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}