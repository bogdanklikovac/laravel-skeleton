<?php

use App\Http\Controllers\Api\V1\Author\CreateAuthor;
use App\Http\Controllers\Api\V1\Author\DeleteAuthor;
use App\Http\Controllers\Api\V1\Author\RetrieveAuthor;
use App\Http\Controllers\Api\V1\Author\RetrieveCollectionAuthor;
use App\Http\Controllers\Api\V1\Author\UpdateAuthor;
use App\Http\Controllers\Api\V1\Book\CreateBook;
use App\Http\Controllers\Api\V1\Book\DeleteBook;
use App\Http\Controllers\Api\V1\Book\RetrieveBook;
use App\Http\Controllers\Api\V1\Book\RetrieveCollectionBook;
use App\Http\Controllers\Api\V1\Book\UpdateBook;
use App\Http\Controllers\Api\V1\Publisher\CreatePublisher;
use App\Http\Controllers\Api\V1\Publisher\DeletePublisher;
use App\Http\Controllers\Api\V1\Publisher\RetrieveCollectionPublisher;
use App\Http\Controllers\Api\V1\Publisher\RetrievePublisher;
use App\Http\Controllers\Api\V1\Publisher\UpdatePublisher;
use App\Http\Controllers\Api\V1\Tag\CreateTag;
use App\Http\Controllers\Api\V1\Tag\DeleteTag;
use App\Http\Controllers\Api\V1\Tag\RetrieveCollectionTag;
use App\Http\Controllers\Api\V1\Tag\RetrieveTag;
use App\Http\Controllers\Api\V1\Tag\UpdateTag;
use App\Http\Controllers\Api\V1\User\AddUserTag;
use App\Http\Controllers\Api\V1\User\CreateUser;
use App\Http\Controllers\Api\V1\User\DeleteUser;
use App\Http\Controllers\Api\V1\User\RemoveUserTag;
use App\Http\Controllers\Api\V1\User\RetrieveCollectionUser;
use App\Http\Controllers\Api\V1\User\RetrieveUser;
use App\Http\Controllers\Api\V1\User\UpdateUser;
use App\Http\Controllers\Authentication\ForgotPassword;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\ResetPassword;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::post('/logout', LogoutController::class);

    Route::post('users/{user}/tags/{tag}', AddUserTag::class);
    Route::delete('users/{user}/tags/{tag}', RemoveUserTag::class);
    Route::get('users/{user}', RetrieveUser::class);
    Route::get('users', RetrieveCollectionUser::class);
    Route::put('users/{user}', UpdateUser::class);
    Route::delete('users/{user}', DeleteUser::class);

    Route::post('tags', CreateTag::class);
    Route::get('tags/{tag}', RetrieveTag::class);
    Route::get('tags', RetrieveCollectionTag::class);
    Route::put('tags/{tag}', UpdateTag::class);
    Route::delete('tags/{tag}', DeleteTag::class);

    Route::post('publishers', CreatePublisher::class);
    Route::get('publishers', RetrieveCollectionPublisher::class);
    Route::get('publishers/{publisher}', RetrievePublisher::class);
    Route::put('publishers/{publisher}', UpdatePublisher::class);
    Route::delete('publishers/{publisher}', DeletePublisher::class);

    Route::post('books', CreateBook::class);
    Route::get('books', RetrieveCollectionBook::class);
    Route::get('books/{book}', RetrieveBook::class);
    Route::put('books/{book}', UpdateBook::class);
    Route::delete('books/{book}', DeleteBook::class);

    Route::post('authors', CreateAuthor::class);
    Route::get('authors', RetrieveCollectionAuthor::class);
    Route::get('authors/{author}', RetrieveAuthor::class);
    Route::put('authors/{author}', UpdateAuthor::class);
    Route::delete('authors/{author}', DeleteAuthor::class);
});

Route::post('users', CreateUser::class);
Route::post('login', LoginController::class);
Route::post('reset-password', ForgotPassword::class);
Route::put('reset-password/{token}', ResetPassword::class);

Route::fallback(static function () {
    return response()->json(['message' => 'Route not found.'], Response::HTTP_NOT_FOUND);
});
