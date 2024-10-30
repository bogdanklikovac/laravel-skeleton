<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ResetPassword extends Controller
{
    /**
     * @OA\Put(
     *      path="/api/v1/reset-password/{token}",
     *      operationId="resetPassword",
     *      tags={"Authentication"},
     *      summary="Update password",
     *      description="Update password",
     *      @OA\Parameter(
     *          name="token",
     *          description="Token string",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              example="1|HM3l3TpqlOlOxMwMeFlzaVorpgyR0UFJzlPTHHdA"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Update password",
     *          @OA\JsonContent(
     *              required={"email", "password", "password_confirmation"},
     *              @OA\Property(property="email", type="string", example="john.doe@q.agency"),
     *              @OA\Property(property="password", type="string", example="secretPassword"),
     *              @OA\Property(property="password_confirmation", type="string", example="secretPassword"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User created successfully",
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
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        if ($request->changePasswordStatus() !== Password::PASSWORD_RESET) {
            return response()->json([
                'message' => __($request->changePasswordStatus()),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['message' => 'Password has been changed successfully'], Response::HTTP_OK);
    }
}
