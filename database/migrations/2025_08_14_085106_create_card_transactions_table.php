<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_transactions', function (Blueprint $table) {
            $table->id();
            
            // Ссылка на карту
            $table->foreignId('card_id')
                  ->constrained()
                  ->cascadeOnDelete();
            
            // Тип транзакции: пополнение или списание
            $table->enum('type', ['deposit', 'spend']);
            
            // Сумма транзакции
            $table->decimal('amount', 12, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_transactions');
    }
};
