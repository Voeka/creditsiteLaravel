@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 space-y-12">

    {{-- ===== Hero-блок ===== --}}
    <section class="relative bg-blue-600 text-white rounded-lg overflow-hidden shadow-lg p-12 flex flex-col items-center justify-center text-center animate-fadeIn">
        <h1 class="text-5xl font-bold mb-4">KreditBank</h1>
        <p class="text-xl mb-6">Быстрое оформление кредитов на карту с курьерской доставкой и полным управлением через личный кабинет.</p>
        <a href="{{ route('user.dashboard') }}" class="bg-white text-blue-600 font-semibold px-6 py-3 rounded shadow hover:bg-gray-100 transition">
            В личный кабинет
        </a>
        {{-- Лёгкая анимация движения пузырьков --}}
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="animate-bubble absolute w-6 h-6 bg-white rounded-full opacity-20 top-10 left-1/4"></div>
            <div class="animate-bubble absolute w-8 h-8 bg-white rounded-full opacity-15 top-32 left-3/4"></div>
            <div class="animate-bubble absolute w-4 h-4 bg-white rounded-full opacity-10 top-1/2 left-1/2"></div>
        </div>
    </section>

    {{-- ===== История компании ===== --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Наша история</h2>
        <p class="text-gray-700">
            Компания "KreditBank" работает с 2023 года. Мы выдали более 10 000 кредитов и продолжаем развивать сервис для удобства клиентов.
        </p>
    </section>

    {{-- ===== Калькулятор кредита ===== --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Калькулятор кредита</h2>
        <form id="loan-calculator" class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border rounded shadow">
            <div>
                <label class="block font-medium mb-1">Сумма кредита, ₽</label>
                <input type="number" id="amount" class="border p-2 rounded w-full" value="10000" min="1000">
            </div>
            <div>
                <label class="block font-medium mb-1">Срок, мес.</label>
                <input type="number" id="term" class="border p-2 rounded w-full" value="12" min="1">
            </div>
            <div class="flex flex-col justify-end">
                <button type="button" id="calculate" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
                    Рассчитать
                </button>
            </div>

            <div class="md:col-span-3 mt-4 text-center">
                <p class="text-lg">Ежемесячный платёж: <span id="monthlyPayment" class="font-bold">0 ₽</span></p>
                <p class="text-gray-600">Процентная ставка: 20% годовых</p>
            </div>
        </form>
    </section>

    {{-- ===== Основные преимущества ===== --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Почему выбирают нас</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 border rounded shadow text-center hover:shadow-lg transition">
                <h3 class="font-bold mb-2">Быстро</h3>
                <p>Оформление кредита за 5 минут.</p>
            </div>
            <div class="p-4 border rounded shadow text-center hover:shadow-lg transition">
                <h3 class="font-bold mb-2">Удобно</h3>
                <p>Кредит сразу на карту с курьерской доставкой.</p>
            </div>
            <div class="p-4 border rounded shadow text-center hover:shadow-lg transition">
                <h3 class="font-bold mb-2">Прозрачно</h3>
                <p>Все условия и платежи видны в личном кабинете.</p>
            </div>
        </div>
    </section>

</div>

{{-- ===== Скрипт калькулятора ===== --}}
<script>
document.getElementById('calculate').addEventListener('click', function() {
    const amount = parseFloat(document.getElementById('amount').value);
    const term = parseInt(document.getElementById('term').value);
    const rate = 0.20; // 20% годовых

    const monthlyRate = rate / 12;
    const monthlyPayment = amount * (monthlyRate / (1 - Math.pow(1 + monthlyRate, -term)));

    document.getElementById('monthlyPayment').innerText = Math.round(monthlyPayment).toLocaleString('ru-RU') + ' ₽';
});
</script>

{{-- ===== Tailwind анимации пузырьков ===== --}}
<style>
@keyframes bubble {
    0% { transform: translateY(0); opacity: 0.2; }
    50% { opacity: 0.4; }
    100% { transform: translateY(-200px); opacity: 0; }
}
.animate-bubble {
    animation: bubble 6s infinite ease-in;
}
.animate-fadeIn {
    animation: fadeIn 1s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
@endsection
