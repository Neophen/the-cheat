<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cheat_sheets', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->string('img')->nullable();
      $table->json('options')->nullable();
      $table->boolean('approved')->default(false);
      $table->boolean('is_public')->default(true);

      $table->foreignId('user_id')
        ->nullable()
        ->constrained()
        ->onDelete('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('cheat_sheets');
  }
};
