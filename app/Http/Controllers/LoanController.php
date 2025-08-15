<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth; // Removed unused import

class LoanController extends Controller
{
    public function create(Card $card)
    {
        return view('user.loans.create', compact('card'));
    }

    public function store(Request $request, Card $card)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'term' => 'required|integer|min:1',
        ]);

        // Создаём кредит
        $loan = $card->loans()->create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'amount'  => $data['amount'],
            'term'    => $data['term'],
            'status'  => 'active',
        ]);

        // Пополняем баланс карты на сумму кредита
        $card->balance += $data['amount'];
        $card->save();

        // Создаём транзакцию для истории
        $card->transactions()->create([
            'type'   => 'deposit',
            'amount' => $data['amount']

        ]);

        return redirect()->route('user.dashboard')->with('success', 'Заявка на кредит оформлена, баланс карты пополнен');
    }



}
