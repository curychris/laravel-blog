<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');  // Kolom untuk isi komentar
            $table->foreignId('blog_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel blogs
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
