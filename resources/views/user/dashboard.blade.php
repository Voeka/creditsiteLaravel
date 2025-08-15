@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Личный Кабинет</h1>

        {{-- Кнопки выхода и заказа карты --}}
        <div class="flex gap-2">
            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Выйти
                </button>
            </form>

            <form method="POST" action="{{ route('user.cards.create') }}">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Заказать карту
                </button>
            </form>
        </div>
    </div>

    {{-- Карты пользователя --}}
    <h2 class="text-2xl font-semibold mb-4">Ваши карты</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($cards as $card)
            @php
                $statusColors = [
                    'creating' => 'text-gray-600',
                    'in_delivery' => 'text-yellow-600',
                    'active' => 'text-green-600',
                    'blocked' => 'text-red-600',
                    'expired' => 'text-gray-500',
                ];
                $balance = $card->balance;
            @endphp

            <div class="p-4 border rounded shadow hover:shadow-lg transition">
                <p><strong>Номер карты:</strong> {{ $card->number ?? '-' }}</p>
                <p><strong>Баланс:</strong> {{ number_format($balance, 2, '.', ' ') }} ₽</p>
                <p><strong>Статус:</strong>
                    <span class="{{ $statusColors[$card->status] ?? 'text-gray-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $card->status)) }}
                    </span>
                </p>

                {{-- Кнопка тестирования карты --}}
                <br>
                <div class="mt-2">
                    <a href="{{ route('user.test-card', $card) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Тестировать карту
                    </a>
                </div>

                {{-- Кнопка взять кредит (только если карта active) --}}
                @if($card->status === 'active')
                    <br>
                    <div class="mt-2">
                        <a href="{{ route('user.loans.create', $card) }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                            Взять кредит
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p>У вас пока нет карт.</p>
        @endforelse
    </div>

    {{-- Кредиты пользователя --}}
    <h2 class="text-2xl font-semibold my-4">Ваши кредиты</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($loans as $loan)
            @php
                $loanStatusColors = [
                    'pending' => 'text-yellow-600',
                    'active' => 'text-green-600',
                    'closed' => 'text-gray-500',
                    'overdue' => 'text-red-600',
                ];
            @endphp

            <div class="p-4 border rounded shadow hover:shadow-lg transition">
                <p><strong>Сумма:</strong> {{ number_format($loan->amount, 0, '.', ' ') }} ₽</p>
                <p><strong>Срок:</strong> {{ $loan->term }} мес.</p>
                <p><strong>Статус:</strong>
                    <span class="{{ $loanStatusColors[$loan->status] ?? 'text-gray-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $loan->status)) }}
                    </span>
                </p>
                <p><strong>Карта:</strong> {{ $loan->card->number ?? '-' }}</p>
            </div>
        @empty
            <p>У вас пока нет кредитов.</p>
        @endforelse
    </div>
</div>
@endsection
