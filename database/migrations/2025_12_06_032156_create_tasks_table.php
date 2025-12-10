<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Task thuộc về user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Task thuộc về project
            $table->foreignId('project_id')->constrained('project')->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');

            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            $table->string('assignee')->nullable();
            $table->integer('progress')->default(0);

            // JSON fields
            $table->json('tags')->nullable();
            $table->json('subtasks')->nullable();
            $table->json('dependencies')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
