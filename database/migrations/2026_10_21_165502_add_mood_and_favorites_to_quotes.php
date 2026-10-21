<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
// Add mood column to quotes table
Schema::table('quotes', function (Blueprint $table) {
$table->string('mood', 20)->nullable();
});

// Create favorites table
Schema::create('quote_user_favorites', function (Blueprint $table) {
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('quote_id')->constrained()->cascadeOnDelete();
$table->timestamps();

$table->primary(['user_id', 'quote_id']);
});
}

public function down(): void
{
Schema::dropIfExists('quote_user_favorites');

Schema::table('quotes', function (Blueprint $table) {
$table->dropColumn('mood');
});
}
};