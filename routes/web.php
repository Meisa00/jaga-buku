<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ExcelReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController;

Route::get('/konsultasi', ConsultationController::class)->name('consultation.index');
Route::post('/konsultasi/chat', ChatbotController::class)->name('consultation.chat');
Route::get('/paket', [PlanController::class, 'index'])->name('plans.index');
Route::post('/midtrans/notifikasi', [PlanController::class, 'notification'])->name('midtrans.notification');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/pengguna', UserProfileController::class)->name('users.profile');
    Route::get('/transaksi/riwayat', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transaksi', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transaksi', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transaksi/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transaksi/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/kategori', CategoryController::class)->name('categories.index');
    Route::post('/kategori', [CategoryController::class, 'store'])
        ->middleware('plan.feature:unlimited_categories')->name('categories.store');
    Route::get('/laporan', ReportController::class)->name('reports.index');
    Route::get('/laporan/excel', ExcelReportController::class)
        ->middleware('plan.feature:excel_export')->name('reports.excel');
    Route::post('/langganan', [PlanController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::get('/langganan', [PlanController::class, 'show'])->name('subscriptions.show');
    Route::get('/langganan/{subscription}/checkout', [PlanController::class, 'checkout'])->name('subscriptions.checkout');
    Route::delete('/langganan/pending', [PlanController::class, 'cancel'])->name('subscriptions.cancel');
});
