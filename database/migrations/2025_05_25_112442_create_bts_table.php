<?php

use App\Models\House;
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
        Schema::create('bts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignIdFor(House::class);

            // Identification fields
            $table->string('site_id')->unique();
            $table->string('bts_code')->unique();

            // Location fields
            $table->string('site_type');
            $table->string('thana');
            $table->string('district');
            $table->string('division');
            $table->text('bts_address');
            $table->string('urban_rural');

            // Geographical coordinates
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);

            // Network fields
            $table->string('network_mode');
            $table->string('archetype');

            // On-air dates
            $table->date('2g_onair_date')->nullable();
            $table->date('3g_onair_date')->nullable();
            $table->date('4g_onair_date')->nullable();

            // Operational fields
            $table->string('priority');

            // Indexes for better performance
            $table->index('site_id');
            $table->index('bts_code');
            $table->index('district');
            $table->index('division');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bts');
    }
};
