<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ForgotPassword extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/reset-password",
     *      operationId="forgotPassword",
     *      tags={"Authentication"},
     *      summary="Send password reset link",
     *      description="Sends password reset link",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Send password reset link",
     *          @OA\JsonContent(
     *              required={"email"},
     *              @OA\Property(property="email", type="string", example="john.doe@q.agency"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Password reset link sent successfully",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        if ($request->emailLinkStatus() !== Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($request->emailLinkStatus()),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['message' => 'Password reset link sent successfully'], Response::HTTP_OK);
    }
}
