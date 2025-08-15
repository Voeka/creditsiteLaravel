<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Получаем статус из GET-параметра (например ?card_status=active)
        $cardStatus = request()->get('card_status');
        $loanStatus = request()->get('loan_status');

        // Построение запросов для фильтрации
        $cardsQuery = $user->cards(); // метод hasMany для query builder
        $loansQuery = $user->loans()->with('card');

        if ($cardStatus) {
            $cardsQuery->where('status', $cardStatus);
        }

        if ($loanStatus) {
            $loansQuery->where('status', $loanStatus);
        }

        // Получаем коллекции после фильтрации
        $cards = $cardsQuery->get();
        $loans = $loansQuery->get();

        // Передаём данные в Blade шаблон
        return view('user.dashboard', compact('user', 'cards', 'loans', 'cardStatus', 'loanStatus'));
    }
}
