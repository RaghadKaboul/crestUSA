<?php

namespace App\Http\Controllers;

use App\Models\WebmasterSetting;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Models\Certificate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    /**
     * Apply authentication middleware to ensure only authorized users can access these routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the certificates.
     */
    public function index()
    {
        // Clear cached certificate data to ensure fresh results
        Cache::forget('certificates');
        Cache::forget('certificates_count');

        // Cache general webmaster sections for 10 minutes to reduce queries
        $GeneralWebmasterSections = Cache::remember('GeneralWebmasterSections', now()->addMinutes(10), function () {
            return WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        });

        // Retrieve and cache paginated certificate data for 10 minutes
        $certificates = Cache::remember('certificates', now()->addMinutes(10), function () {
            return Certificate::paginate(5);
        });

        // Cache the count of certificates for performance optimization
        $certificatescount = Cache::remember('certificates_count', now()->addMinutes(10), function () {
            return Certificate::count();
        });

        // Return the dashboard view with retrieved data
        return view('dashboard.certificates.index', compact("GeneralWebmasterSections", "certificates", "certificatescount"));
    }

    /**
     * Search for a certificate using its number.
     */
    public function searchCertificate(Request $request)
    {
        // Get the certificate number from the request
        $certificateNumber = $request->certificateNumber;

        // Retrieve general webmaster settings
        $webmasterSetting = WebmasterSetting::first();

        // Increment the search counter for tracking purposes
        if ($webmasterSetting) {
            $webmasterSetting->countsearch += 1;
            $webmasterSetting->save();
        }

        // If a certificate number is provided, attempt to find the certificate in the database

            if ($certificateNumber) {
                $certificate = Cache::remember("certificate_{$certificateNumber}", now()->addMinutes(10), function () use ($certificateNumber) {
                    return DB::table('certificates')->where('certificate_number', '=', $certificateNumber)->first();
                });

                return view('frontend.serchresoult', ['certificate' => $certificate]);
            }


        // Return a search results view with no certificate found
        return view('frontend.serchresoult', ['certificate' => null]);
    }

    /**
     * Display the certificate creation form.
     */
    public function create()
    {
        // Retrieve and cache webmaster sections for the create certificate view
        $GeneralWebmasterSections = Cache::remember('GeneralWebmasterSections', now()->addMinutes(10), function () {
            return WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        });

        return view('dashboard.certificates.create', compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created certificate in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'certificate_number' => 'required|unique:certificates',
            'certificate_holders_name' => 'required',
            'releas_date' => 'required|date',
            'Expiry_date' => 'nullable|date|after_or_equal:releas_date',
            'Issuing_authority' => 'required',
            'status' => 'required',
        ]);

        // Check if the certificate number already exists
        $exists = Certificate::where('certificate_number', $request->certificate_number)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['certificate_number' => 'Certificate number is already registered.']);
        }

        // Create a new certificate with validated data
        Certificate::create($request->all());

        // Clear cached certificate data to reflect the new addition
        Cache::forget('certificates');
        Cache::forget('certificates_count');

        // Redirect back to the certificates index page with success message
        return redirect()->route('certificate.index')->with('doneMessage', __('backend.addDone'));
    }

    /**
     * Show the form for editing an existing certificate.
     */
    public function edit($id)
    {
        // Retrieve webmaster sections for the edit certificate view
        $GeneralWebmasterSections = Cache::remember('GeneralWebmasterSections', now()->addMinutes(10), function () {
            return WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        });

        // Find the certificate by ID, or fail if it doesn't exist
        $certificate = Certificate::findOrFail($id);

        return view('dashboard.certificates.edit', compact('certificate', "GeneralWebmasterSections"));
    }

    /**
     * Update an existing certificate in the database.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'certificate_number' => 'required|unique:certificates,certificate_number,' . $id,
            'certificate_holders_name' => 'required',
            'releas_date' => 'required|date',
            'Expiry_date' => 'nullable|date|after_or_equal:releas_date',
            'Issuing_authority' => 'required',
            'status' => 'required',
        ]);

        // Find the certificate by ID, or fail if it doesn't exist
        $certificate = Certificate::findOrFail($id);

        // Update certificate with validated data
        $certificate->update($request->all());

        // Clear cached certificate data to reflect the update
        Cache::forget('certificates');
        Cache::forget('certificates_count');
        Cache::forget("certificate_{$certificate->certificate_number}");

        // Redirect back with a success message
        return redirect()->route('certificate.index')->with('doneMessage', __('backend.saveDone'));
    }

    /**
     * Remove a certificate from the database.
     */
    public function destroy($id)
    {
        // Find the certificate by ID, or fail if it doesn't exist
        $certificate = Certificate::findOrFail($id);

        // Delete the certificate
        $certificate->delete();

        // Clear cached certificate data after deletion
        Cache::forget('certificates');
        Cache::forget('certificates_count');
        Cache::forget("certificate_{$certificate->certificate_number}");

        // Redirect back with a success message
        return redirect()->route('certificate.index')->with('doneMessage', __('backend.deleteDone'));
    }

}
