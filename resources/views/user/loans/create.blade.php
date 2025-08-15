@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Оформить кредит для карты {{ $card->number }}</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.loans.store', $card) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Сумма кредита</label>
            <input type="number" name="amount" class="border p-2 w-full" required min="1000" step="1">
        </div>
        <div>
            <label class="block">Срок (в месяцах)</label>
            <input type="number" name="term" class="border p-2 w-full" required>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
            Отправить заявку
        </button>
    </form>
</div>
@endsection
