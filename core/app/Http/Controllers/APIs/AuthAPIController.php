<?php
namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Info(
 *     title="Authentication API",
 *     version="1.0",
 *     description="API for handling user authentication and token management",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 */
class AuthAPIController extends Controller
{
    use HasApiTokens, Notifiable;
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User Login",
     *     description="Authenticate the user and generate an access token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // البحث عن المستخدم باستخدام البريد الإلكتروني
        $user = User::where('email', $request->email)->first();
        // التحقق مما إذا كان المستخدم موجود
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // إنشاء رمز وصول جديد
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Login successful',
            // يمكنك إرجاع بيانات المستخدم أيضًا إذا كنت بحاجة إليها
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/refresh-token",
     *     summary="Refresh Token",
     *     description="Generate a new authentication token after revoking old tokens.",
     *     @OA\Response(response=200, description="New token issued")
     * )
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $newToken = $user->createToken('authToken')->plainTextToken;

        $encryptedToken = Crypt::encryptString($newToken);
        $user->encrypted_token = $encryptedToken;
        $user->last_token_issued_at = now();
        $user->save();

        return response()->json(['token' => $newToken]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout",
     *     description="Revoke the user's current access token.",
     *     security={{ "BearerAuth": {} }},
     *     @OA\Response(response=200, description="Logged out successfully")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}
