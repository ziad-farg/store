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
        Schema::create('profiles', function (Blueprint $table) {
            // Foreign key to users table as primary key
            $table->foreignId('user_id')
                ->primary()
                ->constrained()
                ->onDelete('cascade');

            // Personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender');

            // Address information
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->char('country', 5)->nullable();

            // Locale
            $table->char('locale', 20)->default('en')->nullable()->comment('User preferred language');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
