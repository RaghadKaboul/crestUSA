<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use MongoDB\Driver\Session;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\WebmasterSection;

use Redirect;
use File;
use Helper;
use Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->webmaster_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
    }
    public function viewcheckPassword() {
        $GeneralWebmasterSections = Cache::remember('GeneralWebmasterSections', now()->addMinutes(10), function () {
            return WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        });
        return view('dashboard.checkpassword',compact('GeneralWebmasterSections'));
    }

    public function checkPassword(Request $request) {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        $userPassword = auth()->user()->password;
        if (Hash::check($request->password, $userPassword)) {
            return redirect()->route('backup.database')->with('success', __('backend.Done'));
        }

        return back()->withErrors(['password' => __('backend.notDone')]);
    }


}
