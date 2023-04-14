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
        Schema::table('users', function(Blueprint $table) {
            $table->removeColumn('name');
            $table->string('address')->after('password');
            $table->string('firstname')->after('id');
            $table->string('lastname')->after('firstname');
            $table->string('phone')->before('password');
            $table->boolean('admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
