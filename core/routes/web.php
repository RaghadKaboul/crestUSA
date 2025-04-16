<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SiteMapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\DB;


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
// Language Route
Route::post('/lang', [LanguageController::class, 'index'])->middleware('LanguageSwitcher')->name('lang');
// For Language direct URL link
Route::get('/lang/{lang}', [LanguageController::class, 'change'])->middleware('LanguageSwitcher')->name('langChange');
Route::get('/locale/{lang}', [LanguageController::class, 'locale'])->middleware('LanguageSwitcher')->name('localeChange');
// .. End of Language Route

// Not Found
Route::get('/{lang?}/404', [HomeController::class, 'page_404'])->name('NotFound');

// RSS Feed Routes
if (config('smartend.rss_status')) {
    Route::feeds();
}
Route::post('/certificate/{certificateNumber}', [\App\Http\Controllers\CertificateController::class, 'searchCertificate'])->name('search');


// Social Auth
Route::get('/oauth/{driver}', [SocialAuthController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('/oauth/{driver}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

Route::Group(['prefix' => config('smartend.backend_path')], function () {
    Auth::routes();

});
Route::get('viewcheck', [BackupController::class, 'viewcheckPassword'])->name('backup.viewcheck');
Route::post('/backup-controller/check', [BackupController::class, 'checkPassword'])->name('backup.check');


//backupDatabase
Route::get('/backup', function () {

    // Check Permissions
    if (!@Auth::user()->permissionsGroup->webmaster_status) {
        return Redirect::to(route('NoPermission'))->send();
    }

    // الاتصال بقاعدة البيانات
    $databaseName = env('DB_DATABASE');
    $pdo = DB::connection()->getPdo();

    // جلب أسماء الجداول
    $statement = $pdo->query("SHOW TABLES");
    $tables = $statement->fetchAll(PDO::FETCH_COLUMN);

    // تعطيل قيود المفاتيح الأجنبية لمنع أخطاء الاستيراد
    $output = "SET FOREIGN_KEY_CHECKS=0;\n\n";

    foreach ($tables as $table) {
        // جلب استعلام إنشاء الجدول
        $createTableStatement = $pdo->query("SHOW CREATE TABLE " . $table);
        $createTableResult = $createTableStatement->fetch();

        $output .= "\n\n" . $createTableResult['Create Table'] . ";\n\n";

        // جلب البيانات من الجدول
        $selectStatement = $pdo->query("SELECT * FROM `$table`");
        $rows = $selectStatement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $columns = array_keys($row);
            $values = array_map(fn($value) => addslashes($value), array_values($row));

            $output .= "\nINSERT INTO `$table` (`" . implode("`, `", $columns) . "`) VALUES ('" . implode("', '", $values) . "');\n";
        }
    }

    // إعادة تمكين قيود المفاتيح الأجنبية
    $output .= "\n\nSET FOREIGN_KEY_CHECKS=1;\n";

    // تحديد المسار وتأكد من وجود المجلد
    $backupPath = storage_path('app/backups/');
    if (!file_exists($backupPath)) {
        mkdir($backupPath, 0777, true);
    }

    // حفظ النسخة الاحتياطية
    $fileName = 'database_backup_on_' . date('Y-m-d_H-i-s') . '.sql';
    $filePath = $backupPath . $fileName;
    file_put_contents($filePath, $output);

    // إعدادات تحميل الملف
    return response()->download($filePath)->deleteFileAfterSend();
})->name('backup.database');



// Start of Frontend Routes
// - site map
Route::get('/sitemap.xml', [SiteMapController::class, 'siteMap'])->name('siteMap');
Route::get('/{lang}/sitemap', [SiteMapController::class, 'siteMap'])->name('siteMapByLang');

// - Public form submit
Route::post('/form-submit', [HomeController::class, 'form_submit'])->name('formSubmit');

// - Newsletter form submit
Route::post('/subscribe', [HomeController::class, 'subscribe_submit'])->name('subscribeSubmit');

// - Comment form submit
Route::post('/comment', [HomeController::class, 'comment_submit'])->name('commentSubmit');

// - Order form submit
Route::post('/order', [HomeController::class, 'order_submit'])->name('orderSubmit');

// - Contact page form submit
Route::post('/contact-submit', [HomeController::class, 'contact_submit'])->name('contactPageSubmit');

// - Tags
Route::get('/tag/{tag_slug?}', [HomeController::class, 'tag'])->name('tag');

// - All Other slugs
Route::get('/{part1?}/{part2?}/{part3?}/{part4?}/{part5?}/{part6?}', [HomeController::class, 'seo'])->name("frontendRoute");
// End of Frontend Route
