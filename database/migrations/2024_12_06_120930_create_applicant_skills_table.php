<?php

use App\Models\Applicant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicant_skills', function (Blueprint $table) {
            $table->id('applicant_skill_id');

            $table->foreignIdFor(Applicant::class, 'applicant_id')
                ->constrained('applicants', 'applicant_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->longText('skill');
            $table->timestamps();
            $table->index([DB::raw('skill(255)')], 'applicant_skills_skill_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_skills');
    }
};
