<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTestDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the test database
        DB::statement('CREATE DATABASE IF NOT EXISTS testing');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the test database
        DB::statement('DROP DATABASE IF EXISTS testing');
    }
}
