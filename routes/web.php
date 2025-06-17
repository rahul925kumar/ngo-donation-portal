<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonarController;
use App\Http\Controllers\FeedbackOrComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecieptController;
use App\Http\Controllers\CelebrationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReceiptsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});
Route::get('/register-test', function () {
   
    return view('register');
});
Route::get('/donorinfo-test', function () {
   
    return view('donorinfo');
});

// Auth::routes(['register' => false]);
Auth::routes();
Route::redirect('/home', '/dashboard');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Your existing login route
    Route::post('/login/check-user-send-otp', [AuthController::class, 'checkUserAndSendOtp'])->name('login.check-user-send-otp');
    Route::post('/login/verify-otp-login', [AuthController::class, 'verifyOtpAndLogin'])->name('login.verify-otp-login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
    Route::post('/profile-settings', [HomeController::class, 'profileSetting']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('donor')->group(function () {
        Route::get('/donations', [DonarController::class, 'donations'])->name('donations.index');
        Route::get('/80G-donations', [DonarController::class, 'eightyGDonations'])->name('donations.eightyGDonations');
        Route::get('/monthly-donations', [DonarController::class, 'getMonthlyDdonations'])->name('monthlyDonations');
        Route::get('/consolidated-receipt', [DonarController::class, 'getConsolidatedReceipt'])->name('consolidated-receipt');
        Route::get('/feedback-and-complaints', [FeedbackOrComplaintController::class, 'index'])->name('feedbacks');
        Route::apiResource('feedbacks', FeedbackOrComplaintController::class);
        Route::get('online-donation', [DonarController::class, 'onlineDonation'])->name('online-donation');
        Route::get('MyReferences', [DonarController::class, 'getMyReferences'])->name('MyReferences');
        Route::get('RefferenceRegistration', [DonarController::class, 'getRefferenceRegistration'])->name('getRefferenceRegistration');
        Route::post('RefferenceRegistration', [DonarController::class, 'saveRefferenceRegistration'])->name('saveRefferenceRegistration');
        Route::post('delete-reference', [DonarController::class, 'deleteRefferenceRegistration'])->name('deleteRefferenceRegistration');
        Route::post('/password/update', [AuthController::class, 'update'])->name('password.update');
    });
    // Route::prefix('admin')->group(function () {
    //     Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    //     Route::get('/complaints/category', [DonarController::class, 'getFeedBackComplaints'])->name('admin.feedbacks');
    //     Route::get('/feedback-and-complaints', [DonarController::class, 'getFeedBackComplaints'])->name('admin.feedbacks');
    // });
    
    // Celebration Routes
    Route::get('/celebrations', [CelebrationController::class, 'index'])->name('celebrations.index');
    Route::get('/celebrations/create', [CelebrationController::class, 'create'])->name('celebrations.create');
    Route::post('/celebrations', [CelebrationController::class, 'store'])->name('celebrations.store');
    Route::get('/celebrations/{celebration}/edit', [CelebrationController::class, 'edit'])->name('celebrations.edit');
    Route::put('/celebrations/{celebration}', [CelebrationController::class, 'update'])->name('celebrations.update');
    Route::delete('/celebrations/{celebration}', [CelebrationController::class, 'destroy'])->name('celebrations.destroy');
});
Route::get('/reciept/{amount}/pdf', [RecieptController::class, 'generateRecieptPdf'])->name('reciept.pdf');
Route::get('reciept', function(){
    return view('donars.donation-reciept');
});

// Consolidated Receipts Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/consolidated-receipts', [DonarController::class, 'consolidatedReceipts'])->name('donations.consolidated-receipts');
    Route::post('/consolidated-receipt', [DonarController::class, 'generateConsolidatedReceipt'])->name('donations.consolidated-receipt');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::post('/users', [AdminController::class, 'addUser'])->name('admin.users.store');
        Route::get('/users/{user_id}/donation/{donation_id}', [RecieptController::class, 'sngleDownloadReciept'])->name('admin.users.receipts.download');
        Route::post('/users/reciepts/bullk-download', [RecieptController::class, 'bulkDownloadReciept'])->name('admin.users.receipts.download.bulk');
        // Donations Management
        Route::get('/donations', [AdminController::class, 'donations'])->name('admin.donations');
        Route::get('/reciepts', [ReceiptsController::class, 'index'])->name('admin.reciepts');
        Route::post('/reciepts', [ReceiptsController::class, 'store'])->name('admin.receipts.store');
        Route::get('/reciepts/delete/{id}', [ReceiptsController::class, 'destroy'])->name('admin.receipts.delete');
        // Celebrations Management
        Route::get('/celebrations', [AdminController::class, 'celebrations'])->name('admin.celebrations');
        Route::delete('/celebrations/{celebration}', [AdminController::class, 'deleteCelebration'])->name('admin.celebrations.delete');
        Route::get('/download-reciept/{id}', [RecieptController::class, 'generateManualRecieptPdf'])->name('admin.receipts.download');
        Route::post('/send-password/{user}', [AdminController::class, 'sendPassword'])->name('admin.sendpassword.user');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/change-password', [AdminController::class, 'changePassword'])->name('admin.password');
    });
});
