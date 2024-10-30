<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="Authenticate user",
     *      description="Authenticate existing user",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Login existing user",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="john.doe@q.agency"),
     *              @OA\Property(property="password", type="string", example="secretPassword")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="1|HM3l3TpqlOlOxMwMeFlzaVorpgyR0UFJzlPTHHdA"),
     *              @OA\Property(property="token_type", type="string", example="Bearer"),
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource")
     *          ),
     *      ),
     * ),
     * @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Invalid credentials"),
     *          @OA\Property(property="errors", type="object", example=null),
     *      ),
     *    ),
     * )
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $data = [
            'token' => auth()->user()?->createToken('api_token')->plainTextToken,
            'tokenType' => 'Bearer',
            'user' => new UserResource(auth()->user()),
        ];

        return response()->json($data, Response::HTTP_CREATED);
    }
}
