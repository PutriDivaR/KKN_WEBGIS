<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('rumah_adat_drafts', function (Blueprint $table) {
			$table->bigIncrements('id_draft');
			$table->string('judul', 150)->nullable();
			$table->unsignedTinyInteger('step_current')->default(1);
			$table->json('payload')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('rumah_adat_drafts');
	}
};