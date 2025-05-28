<?php

use App\Models\House;
use App\Models\Retailer;
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
        Schema::create('itopup_replaces', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(House::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Retailer::class);
            $table->string('sim_serial')->unique();
            $table->string('balance');
            $table->string('reason');
            $table->string('status')->default('pending');
            $table->string('remarks')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itopup_replaces');
    }
};
