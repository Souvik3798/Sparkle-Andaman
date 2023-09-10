<?php

use App\Models\Customers;
use App\Models\Category;
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
        Schema::create('custom_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customers::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('cid');
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('days');
            $table->integer('nights');
            $table->string('name');
            $table->longText('description');
            $table->integer('cost');
            $table->string('image')->nullable();
            $table->json('inclusions');
            $table->json('exclusions');
            $table->json('iternity');
            $table->json('rooms');
            $table->json('cruz');
            $table->json('vehicle');
            $table->json('addons');
            $table->boolean('voucher')->default(false);
            $table->integer('margin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_packages');
    }
};
