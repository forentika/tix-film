<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SpotlightController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\DashboardController;
use App\Models\Cinema;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserProfileController;
use App\Models\Movie;
use App\Models\Spotlight;


Route::get('/', function () {
    $movies = Movie::where('status', 'now_showing')->latest()->take(5)->get();
    $spotlights = Spotlight::where('is_active', true)->latest()->take(3)->get();

    return view('welcome', compact('movies', 'spotlights'));
})->name('welcome');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');

    // Route Update Data Profile (Nama & Email)
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');

    // Route Update Password
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('user.profile.password');

    Route::get('/movie/{movie}', [MovieController::class, 'show'])->name('movie.show');
    Route::get('/home', function () {
        $movies = App\Models\Movie::where('status', 'now_showing')->latest()->get();
        $comingSoon = App\Models\Movie::where('status', 'coming_soon')->latest()->get();
        $banners = App\Models\Spotlight::where('is_active', true)->latest()->get();
        $cities = Cinema::select('city')->distinct()->pluck('city');
        $currentCity = session('city', $cities->first() ?? 'JAKARTA');
        return view('home.index', compact('movies', 'comingSoon', 'banners', 'cities', 'currentCity'));
    })->name('user.home');
    Route::get('/booking/seats/{showtime}', [BookingController::class, 'selectSeats'])->name('booking.seats');
    Route::post('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::get('/booking/summary/{booking_code}', [BookingController::class, 'summary'])->name('booking.summary');
    Route::post('/payment/process', [PaymentController::class, 'createInvoice'])->name('payment.process');
    Route::get('/payment/finish', [PaymentController::class, 'finishCb'])->name('payment.finish');
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('tickets.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');
    Route::resource('movies', MovieController::class);
    Route::resource('users', UserController::class);
    Route::resource('spotlights', SpotlightController::class);
    Route::resource('cinemas', CinemaController::class);
    Route::resource('studios', StudioController::class);
    Route::resource('showtimes', ShowtimeController::class);
    Route::get('/admin/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
