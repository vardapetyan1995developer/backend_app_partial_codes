<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();

            $table->string('country')->nullable();
            $table->string('city');
            $table->string('street');
            $table->string('postcode');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->foreign('contact_id')->references('id')->on('contacts')->nullOnDelete();
            $table->foreign('worker_id')->references('id')->on('workers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
