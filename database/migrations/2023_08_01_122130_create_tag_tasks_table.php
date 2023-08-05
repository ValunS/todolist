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
        Schema::create('tag_tasks', function (Blueprint $table) {
            $table->id();

            //FK
            $table->unsignedBigInteger("task_id");
            $table->index("task_id");
            $table->foreign("task_id", "tag_task_task_fk")->on("tasks")->references("id");

            //FK
            $table->unsignedBigInteger("tag_id");
            $table->index("tag_id");
            $table->foreign("tag_id", "tag_task_tag_fk")->on("tags")->references("id");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_tasks');
    }
};
