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
        Schema::create('todolists_tasks', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("full_text")->default("")->nullable();
            $table->string("img_src")->default(null)->nullable();
            $table->boolean("completed")->default(0);

            $table->timestamps();
            $table->softDeletes();

            //FK
            $table->unsignedBigInteger("user_id")->nullable();

            $table->index("user_id", "todolist_tasks_user_idx");
            $table->foreign("user_id", "todolist_tasks_user_fk")->on("users")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todolist_tasks');
    }
};
