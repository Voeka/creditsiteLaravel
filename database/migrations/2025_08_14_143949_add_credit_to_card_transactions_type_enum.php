<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE card_transactions MODIFY type ENUM('deposit','spend') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Возвращаем enum к состоянию до добавления 'credit'
        DB::statement("ALTER TABLE card_transactions MODIFY type ENUM('deposit','spend') NOT NULL");
    }
};
