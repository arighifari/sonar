<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prog_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('');
            $table->string('url')->default('')->unique();
            $table->text('content')->nullable();
            $table->text('summary')->nullable();
            $table->integer('article_ts')->default(0);
            $table->date('published_date')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prog_tests');
    }
}
