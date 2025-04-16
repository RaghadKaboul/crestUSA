<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Cache;
use OpenApi\Annotations as OA;



class CertificateAPIController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/certificates",
     *     summary="Retrieve all certificates",
     *     description="Fetch all certificates stored in the system.",
     *     @OA\Response(response=200, description="List of certificates"),
     *     @OA\Response(response=404, description="No certificates found")
     * )
     */
    public function index()
    {
        $certificates = Cache::remember('certificates', now()->addMinutes(10), function () {
            return Certificate::all();
        });

        if ($certificates->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No certificates available',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Certificates retrieved successfully',
            'data' => $certificates
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/certificates",
     *     summary="Create a new certificate",
     *     description="Store a new certificate in the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"certificate_number", "certificate_holders_name", "releas_date", "Issuing_authority", "status"},
     *             @OA\Property(property="certificate_number", type="integer", example=12345),
     *             @OA\Property(property="certificate_holders_name", type="string", example="John Doe"),
     *             @OA\Property(property="releas_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="Expiry_date", type="string", format="date", example="2025-01-01"),
     *             @OA\Property(property="Issuing_authority", type="string", example="Certification Board"),
     *             @OA\Property(property="status", type="string", example="Active")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Certificate created successfully"),
     *     @OA\Response(response=422, description="Certificate number already exists")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'certificate_number' => 'required|integer',
            'certificate_holders_name' => 'required|string',
            'releas_date' => 'required|date',
            'Expiry_date' => 'nullable|date',
            'Issuing_authority' => 'required|string',
            'status' => 'required|string',
        ]);

        $exists = Certificate::where('certificate_number', $request->certificate_number)->exists();
        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Certificate number already registered. Please check your certificate number or enter a different one.'
            ], 422);
        }

        $certificate = Certificate::create($validatedData);
        Cache::forget('certificates');

        return response()->json([
            'status' => 'success',
            'message' => 'Certificate added successfully.',
            'data' => $certificate
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/certificates/{id}",
     *     summary="Update an existing certificate",
     *     description="Modify the details of an existing certificate.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Certificate ID"
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="certificate_number", type="integer", example=12345),
     *             @OA\Property(property="certificate_holders_name", type="string", example="Jane Doe"),
     *             @OA\Property(property="releas_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="Expiry_date", type="string", format="date", example="2025-01-01"),
     *             @OA\Property(property="Issuing_authority", type="string", example="Certification Authority"),
     *             @OA\Property(property="status", type="string", example="Expired")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Certificate updated successfully"),
     *     @OA\Response(response=404, description="Certificate not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $certificate = Certificate::find($id);
        if (!$certificate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Certificate not found.'
            ], 404);
        }

        if ($request->has('certificate_number')) {
            $exists = Certificate::where('certificate_number', $request->certificate_number)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Certificate number is already registered for another certificate. Please enter a different number.'
                ], 422);
            }
        }

        $validatedData = $request->validate([
            'certificate_number' => 'sometimes|integer',
            'certificate_holders_name' => 'sometimes|string',
            'releas_date' => 'sometimes|date',
            'Expiry_date' => 'nullable|date',
            'Issuing_authority' => 'sometimes|string',
            'status' => 'sometimes|string',
        ]);

        $certificate->update($validatedData);
        Cache::forget('certificates');

        return response()->json([
            'status' => 'success',
            'message' => 'Certificate updated successfully.',
            'data' => $certificate
        ]);
    }


/**
 * @OA\Get(
 *     path="/certificate/search",
 *     summary="البحث عن شهادة عبر رقم الشهادة",
 *     description="يتم البحث عن الشهادة باستخدام رقمها وإرجاع بياناتها إذا كانت موجودة.",
 *     operationId="searchCertificate",
 *     tags={"Certificates"},
 *     @OA\Parameter(
 *         name="certificate_number",
 *         in="query",
 *         description="رقم الشهادة المطلوب البحث عنه",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="تم العثور على الشهادة بنجاح",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="تم العثور على الشهادة."),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="certificate_number", type="string", example="12345"),
 *                 @OA\Property(property="issued_date", type="string", format="date", example="2025-04-14")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="لم يتم العثور على شهادة بهذا الرقم",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="لم يتم العثور على شهادة بهذا الرقم.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="رقم الشهادة غير موجود في الطلب",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="رقم الشهادة غير موجود في الطلب.")
 *         )
 *     )
 * )
 */
public function search(Request $request)
{
    if ($request->has('certificate_number')) {
        $Certificate = Certificate::where('certificate_number', $request->certificate_number)->first();

        if (!$Certificate) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على شهادة بهذا الرقم.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم العثور على الشهادة.',
            'data' => $Certificate
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'رقم الشهادة غير موجود في الطلب.'
    ], 400);
}


    /**
     * @OA\Delete(
     *     path="/api/certificates/{id}",
     *     summary="Delete a certificate",
     *     description="Remove a certificate from the database.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Certificate ID"
     *     ),
     *     @OA\Response(response=200, description="Certificate deleted successfully"),
     *     @OA\Response(response=404, description="Certificate not found")
     * )
     */
    public function destroy($id)
    {
        $certificate = Certificate::find($id);
        if (!$certificate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Certificate not found.'
            ], 404);
        }

        $certificate->delete();
        Cache::forget('certificates');

        return response()->json([
            'status' => 'success',
            'message' => 'Certificate deleted successfully.'
        ]);
    }
}
