<?php

use App\Models\Bp;
use App\Models\Bts;
use App\Models\House;
use App\Models\Retailer;
use App\Models\Route;
use App\Models\Rso;
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
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignIdFor(House::class);
            $table->foreignIdFor(Rso::class);
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Rso::class, 'is_rso_code')->nullable();
            $table->foreignIdFor(Bp::class, 'is_bp_code')->nullable();
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->string('type')->default('telecom');
            $table->string('enabled')->default('Y');
            $table->string('sso')->default('Y');
            $table->string('itop_number')->unique()->index();
            $table->string('service_point')->nullable();
            $table->string('category')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_number')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('address');
            $table->string('nid')->nullable();
            $table->date('dob')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('bts_code')->nullable();
            $table->longText('description')->nullable();
            $table->string('remarks')->nullable();
            $table->json('others_operator')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retailers');
    }
};
