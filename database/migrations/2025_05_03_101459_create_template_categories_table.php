<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnTraits;
use App\Models\TemplateCategory;

return new class extends Migration
{
    use SoftDeletes, AuditColumnTraits;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('template_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->default(0);
            $table->string('name');
            $table->string('slug')->unique();
            $table->tinyInteger('status')->default(TemplateCategory::STATUS_ACTIVE)->comment(TemplateCategory::STATUS_ACTIVE . ' = Active, ' . TemplateCategory::STATUS_INACTIVE . ' = Inactive');
            $table->timestamps();
            $table->softDeletes();

            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_categories');
    }
};
