<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Card;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\LoanController;
// =====================================
// Главная страница
// =====================================
Route::get('/', function () {
    return view('home');
});

// =====================================
// Аутентификация
// =====================================
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    $user = User::where('email', $credentials['email'])->first() ?? User::find(1);
    Auth::login($user);
    return redirect()->route('user.dashboard');
});

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    Auth::login($user);

    return redirect()->route('user.dashboard');
});

// =====================================
// Личный кабинет и защищённые маршруты
// =====================================
Route::middleware(['auth'])->prefix('user')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('user.logout');

    // Создание новой карты
    Route::post('/cards/create', function () {
        $user = Auth::user();

        $card = Card::create([
            'user_id' => $user->id,
            'number' => rand(1000000000000000, 9999999999999999),
            'status' => 'in_delivery',
            'balance' => 0, // начальный баланс
        ]);

        return redirect()->route('user.dashboard');
    })->name('user.cards.create');

    // Страница тестовой карты
    Route::get('/test-card/{card}', function (\App\Models\Card $card) {
        return view('test-card', compact('card'));
    })->name('user.test-card');

    // Пополнить карту
    Route::post('/test-card/{card}/deposit', function (\Illuminate\Http\Request $request, \App\Models\Card $card) {
        $amount = floatval($request->input('amount', 0));
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Сумма должна быть больше нуля');
        }

        $card->balance += $amount;
        $card->save();

        $card->transactions()->create([
            'type' => 'deposit',
            'amount' => $amount,
        ]);

        return redirect()->back()->with('success', "Карта пополнена на {$amount} ₽");
    })->name('user.test-card.deposit');

    // Потратить с карты
    Route::post('/test-card/{card}/spend', function (\Illuminate\Http\Request $request, \App\Models\Card $card) {
        $amount = floatval($request->input('amount', 0));
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Сумма должна быть больше нуля');
        }

        if ($amount > $card->balance) {
            return redirect()->back()->with('error', 'Недостаточно средств');
        }

        $card->balance -= $amount;
        $card->save();

        $card->transactions()->create([
            'type' => 'spend',
            'amount' => $amount,
        ]);

        return redirect()->back()->with('success', "С карты списано {$amount} ₽");
    })->name('user.test-card.spend');

    // =====================================
    // Кредиты (Loans)
    // =====================================
    Route::get('/loans/create/{card}', [LoanController::class, 'create'])
        ->name('user.loans.create');

    Route::post('/loans/store/{card}', [LoanController::class, 'store'])
        ->name('user.loans.store');
});
