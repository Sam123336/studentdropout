<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dropColumn('author');
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('author')->nullable();
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};