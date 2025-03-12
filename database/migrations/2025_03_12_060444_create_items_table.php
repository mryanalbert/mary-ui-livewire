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
        Schema::create('items', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('item_pr')->unique()->nullable(false);
            $table->string('item_name');
            $table->decimal('item_qty', 8, 2);
            $table->foreignId('item_unit_id')->references('unit_id')->on('units')->onDelete('restrict');
            $table->enum('item_priority', ['Emergency', 'Urgent', 'Normal', 'Programmed']);
            $table->text('item_attachment');
            $table->text('item_note');
            $table->foreignId('item_status_id')->references('status_id')->on('statuses')->onDelete('restrict');
            $table->integer('item_created_by');
            $table->timestamp('item_created_at')->useCurrent()->nullable(false);
            $table->string('item_requestor');
            $table->string('item_to_be_appr_by');
            $table->integer('item_log_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
