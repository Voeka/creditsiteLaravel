@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Тестовая карта: {{ $card->number }}</h1>
    <p><strong>Баланс:</strong> {{ number_format($card->balance, 2, '.', ' ') }} ₽</p>

    @if(session('error'))
        <p class="text-red-600">{{ session('error') }}</p>
    @endif

    {{-- Пополнение --}}
    <form action="{{ route('user.test-card.deposit', $card) }}" method="POST" class="my-4">
        @csrf
        <input type="number" name="amount" placeholder="Сумма для пополнения" class="border p-1 rounded">
        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Пополнить</button>
    </form>

    {{-- Трата --}}
    <form action="{{ route('user.test-card.spend', $card) }}" method="POST" class="my-4">
        @csrf
        <input type="number" name="amount" placeholder="Сумма для списания" class="border p-1 rounded">
        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Потратить</button>
    </form>

    <h2 class="text-xl font-semibold mt-6">История операций</h2>
    <ul>
        @foreach($card->transactions as $tx)
            <li>{{ $tx->created_at }} — {{ $tx->type }} — {{ number_format($tx->amount, 2, '.', ' ') }} ₽</li>
        @endforeach
    </ul>
</div>
@endsection
