<?php

use App\Models\House;
use App\Models\User;
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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('code')->unique()->index();
            $table->string('name')->index();
            $table->string('cluster')->nullable();
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('proprietor_name')->nullable();
            $table->string('contact_number')->unique()->nullable();
            $table->string('poc_name')->nullable();
            $table->string('poc_number')->unique()->nullable();
            $table->string('lifting_date');
            $table->string('status')->default('active');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('house_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(House::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
