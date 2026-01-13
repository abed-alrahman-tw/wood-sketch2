<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('service_type')->nullable();
            $table->date('preferred_date');
            $table->string('preferred_time_range');
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->text('address_text')->nullable();
            $table->string('postcode')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->boolean('is_outside_service_area')->default(false);
            $table->enum('status', ['pending', 'approved', 'declined', 'rescheduled'])->default('pending');
            $table->date('proposed_date')->nullable();
            $table->string('proposed_time_range')->nullable();
            $table->text('admin_notes')->nullable();
            $table->dateTime('approved_start_at')->nullable();
            $table->dateTime('approved_end_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
