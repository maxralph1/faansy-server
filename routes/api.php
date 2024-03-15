<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TipController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\ChatController;
use App\Http\Controllers\Api\V1\PollController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\BlockController;
use App\Http\Controllers\Api\V1\StoryController;
use App\Http\Controllers\Api\V1\WalletController;
use App\Http\Controllers\Api\V1\FanlistController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\BookmarkController;
use App\Http\Controllers\Api\V1\PostlikeController;
use App\Http\Controllers\Api\V1\RestrictController;
use App\Http\Controllers\Api\V1\UserlikeController;
use App\Http\Controllers\Api\V1\PolloptionController;
use App\Http\Controllers\Api\V1\FanactivityController;
use App\Http\Controllers\Api\V1\FundraisingController;
use App\Http\Controllers\Api\V1\PostcommentController;
use App\Http\Controllers\Api\V1\TransactionController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\PollresponseController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\WalletfundingController;
use App\Http\Controllers\Api\V1\FundwithdrawalController;
use App\Http\Controllers\Api\V1\UserverificationController;
use App\Http\Controllers\Api\V1\UsercreatorrequestController;
use App\Http\Controllers\Api\V1\FundraisingdonationController;
use App\Http\Controllers\Api\V1\UserbecomecreatorrequestController;
// use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// return $request->user();
// });

Route::get('/storage-symlink', function (Request $request) {
    File::link(storage_path('app/public'), public_path('storage'));
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('password-reset-request', 'resetPasswordRequest');
    Route::post('password-reset', 'resetPassword');
    Route::post(
        'passwordless-signin-request',
        'passwordlessSigninRequest'
    );
    Route::post('passwordless-signin/{username}/{token}', 'passwordlessSignin');

    // // Google Auth
    // Route::get('google/auth/redirect', function () {
    //     return Socialite::driver('google')->redirect();
    // });

    // Route::get('google/auth/callback', function () {
    //     $user = Socialite::driver('google')->user();

    //     // $user->token
    // });


    Route::get('google/auth/redirect', 'redirectToGoogle');
    Route::get('google/auth/callback', 'handleGoogleCallback');
});

// Block
Route::controller(BlockController::class)->group(function () {
    Route::patch('blocks/{block}/restore', 'restore');
    Route::delete('blocks/{block}/delete', 'forceDestroy');
});
Route::apiResource('blocks', BlockController::class);

// Bookmark
Route::controller(BookmarkController::class)->group(function () {
    Route::patch('bookmarks/{bookmark}/restore', 'restore');
    Route::delete('bookmarks/{bookmark}/delete', 'forceDestroy');
});
Route::apiResource('bookmarks', BookmarkController::class);

// Card
Route::controller(CardController::class)->group(function () {
    Route::patch('cards/{card}/restore', 'restore');
    Route::delete('cards/{card}/delete', 'forceDestroy');
    Route::patch('cards/{card}/make-default', 'makeDefault');
});
Route::apiResource('cards', CardController::class);

// Chat
Route::controller(ChatController::class)->group(function () {
    Route::patch('chats/{chat}/restore', 'restore');
    Route::delete('chats/{chat}/delete', 'forceDestroy');
});
Route::apiResource('chats', ChatController::class);

// Fanactivity
Route::controller(FanactivityController::class)->group(function () {
    Route::patch('fanactivities/{fanactivity}/restore', 'restore');
    Route::delete('fanactivities/{fanactivity}/delete', 'forceDestroy');
});
Route::apiResource('fanactivities', FanactivityController::class);

// Fanlist
Route::controller(FanlistController::class)->group(function () {
    Route::patch('fanlists/{fanlist}/restore', 'restore');
    Route::delete('fanlists/{fanlist}/delete', 'forceDestroy');
});
Route::apiResource('fanlists', FanlistController::class);

// Fundraising
Route::controller(FundraisingController::class)->group(function () {
    Route::patch('fundraisings/{fundraising}/restore', 'restore');
    Route::delete('fundraisings/{fundraising}/delete', 'forceDestroy');
});
Route::apiResource('fundraisings', FundraisingController::class);

// Fundraisingdonation
Route::controller(FundraisingdonationController::class)->group(function () {
    Route::patch('fundraisingdonations/{fundraisingdonation}/restore', 'restore');
    Route::delete('fundraisingdonations/{fundraisingdonation}/delete', 'forceDestroy');
});
Route::apiResource('fundraisingdonations', FundraisingdonationController::class);

// Fundwithdrawal
Route::controller(FundwithdrawalController::class)->group(function () {
    Route::patch('fundwithdrawals/{fundwithdrawal}/restore', 'restore');
    Route::delete('fundwithdrawals/{fundwithdrawal}/delete', 'forceDestroy');
});
Route::apiResource('fundwithdrawals', FundwithdrawalController::class);

// Message
Route::controller(MessageController::class)->group(function () {
    Route::patch('messages/{message}/restore', 'restore');
    Route::delete('messages/{message}/delete', 'forceDestroy');
    Route::post('messages/new-message', 'storeNewMessage');
});
Route::apiResource('messages', MessageController::class);

// Notification
Route::controller(NotificationController::class)->group(function () {
    Route::patch('notifications/{notification}/restore', 'restore');
    Route::delete('notifications/{notification}/delete', 'forceDestroy');
    Route::put('notifications/{notification}/mark-as-read', 'markAsRead');
});
Route::apiResource('notifications', NotificationController::class);

// Poll
Route::controller(PollController::class)->group(function () {
    Route::patch('polls/{poll}/restore', 'restore');
    Route::delete('polls/{poll}/delete', 'forceDestroy');
});
Route::apiResource('polls', PollController::class);

// Polloption
Route::controller(PolloptionController::class)->group(function () {
    Route::patch('polloptions/{polloption}/restore', 'restore');
    Route::delete('polloptions/{polloption}/delete', 'forceDestroy');
});
Route::apiResource('polloptions', PolloptionController::class);

// Pollresponse
Route::controller(PollresponseController::class)->group(function () {
    Route::patch('pollresponses/{pollresponse}/restore', 'restore');
    Route::delete('pollresponses/{pollresponse}/delete', 'forceDestroy');
});
Route::apiResource('pollresponses', PollresponseController::class);

// Postcomment
Route::controller(PostcommentController::class)->group(function () {
    Route::patch('postcomments/{postcomment}/restore', 'restore');
    Route::delete('postcomments/{postcomment}/delete', 'forceDestroy');
});
Route::apiResource('postcomments', PostcommentController::class);

// Post
Route::controller(PostController::class)->group(function () {
    Route::post('posts/{post}/repost', 'repost');
    Route::post('posts/featured-posts/{post}', 'makePostFeatured');
    Route::get('posts/featured-posts', 'featuredPosts');
    Route::get('posts/my-posts', 'myPosts');
    Route::post('posts/{post}/pin-post', 'pinPost');
    Route::post('posts/{post}', 'update');
});
Route::apiResource('posts', PostController::class);

// Postlikes
Route::controller(PostlikeController::class)->group(function () {
    Route::patch('postlikes/{postlike}/restore', 'restore');
    Route::delete('postlikes/{postlike}/delete', 'forceDestroy');
});
Route::apiResource('postlikes', PostlikeController::class);

// Restricts
Route::controller(RestrictController::class)->group(function () {
    Route::patch('restricts/{restrict}/restore', 'restore');
    Route::delete('restricts/{restrict}/delete', 'forceDestroy');
});
Route::apiResource('restricts', RestrictController::class);

// Stories
Route::controller(StoryController::class)->group(function () {
    Route::patch('storys/{story}/restore', 'restore');
    Route::delete('storys/{story}/delete', 'forceDestroy');
});
Route::apiResource('storys', StoryController::class);

// Subscription
Route::controller(SubscriptionController::class)->group(function () {
    Route::patch('subscriptions/{subscription}/restore', 'restore');
    Route::delete('subscriptions/{subscription}/delete', 'forceDestroy');
});
Route::apiResource('subscriptions', SubscriptionController::class);

// Transaction
Route::controller(TransactionController::class)->group(function () {
    Route::patch('transactions/{transaction}/restore', 'restore');
    Route::delete('transactions/{transaction}/delete', 'forceDestroy');
});
Route::apiResource('transactions', TransactionController::class);

// Tip
Route::controller(TipController::class)->group(function () {
    Route::patch('tips/{tip}/restore', 'restore');
    Route::delete('tips/{tip}/delete', 'forceDestroy');
});
Route::apiResource('tips', TipController::class);

// Users
Route::controller(UserController::class)->group(function () {
    Route::get('my-profile', 'myProfile');
    Route::get('creators', 'creators');
    Route::get('creators/{user:username}', 'creator');
    Route::post('creators/{user:username}/update', 'update');
    Route::post('creators/{user:username}/update-profile-photo', 'updateProfilePhoto');
    Route::post('creators/{user:username}/update-background-photo', 'updateBackgroundPhoto');
    Route::post('creators/{user:username}/verify', 'verifyCreator');
});
Route::apiResource('users', UserController::class);

// Userlike
Route::controller(UserlikeController::class)->group(function () {
    Route::patch('userlikes/{userlike}/restore', 'restore');
    Route::delete('userlikes/{userlike}/delete', 'forceDestroy');
});
Route::apiResource('userlikes', UserlikeController::class);

// Userbomecreatorrequest
Route::controller(UserbecomecreatorrequestController::class)->group(function () {
    // Route::post('user-become-creators', 'store');
    Route::patch('user-become-creators/{userbecomecreatorrequest}/restore', 'restore');
    Route::delete('user-become-creators/{userbecomecreatorrequest}/delete', 'forceDestroy');
    Route::put('user-become-creators/{userbecomecreatorrequest}/approve', 'approve');
    Route::post('user-become-creators/reject', 'reject');
});
Route::apiResource('user-become-creators', UserbecomecreatorrequestController::class);

// Userverification
Route::controller(UserverificationController::class)->group(function () {
    // Route::post('user-verifications', 'store');
    Route::patch('user-verifications/{userverification}/restore', 'restore');
    Route::delete('user-verifications/{userverification}/delete', 'forceDestroy');
    Route::post('user-verifications/{userverification}/approve', 'approve');
    Route::post('user-verifications/reject', 'reject');
});
Route::apiResource('user-verifications', UserverificationController::class);

// Wallet
// Route::controller(WalletController::class)->group(function () {
//     Route::patch('wallets/{wallet}/restore', 'restore');
//     Route::delete('wallets/{wallet}/delete', 'forceDestroy');
//     Route::get('wallets/my-wallet', 'myWallet');
// });
// Route::apiResource('wallets', WalletController::class);
Route::get('wallets/{wallet:user_id}', [WalletController::class, 'show']);

// Walletfunding
Route::controller(WalletfundingController::class)->group(function () {
    Route::patch('walletfundings/{walletfunding}/restore', 'restore');
    Route::delete('walletfundings/{walletfunding}/delete', 'forceDestroy');
    Route::get('walletfundings/my-walletfunding', 'myWalletfunding');
});
Route::apiResource('walletfundings', WalletfundingController::class);
