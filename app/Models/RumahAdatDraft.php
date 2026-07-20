<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahAdatDraft extends Model
{
	protected $table = 'rumah_adat_drafts';
	protected $primaryKey = 'id_draft';
	protected $fillable = ['judul', 'step_current', 'payload'];

	protected $casts = [
		'payload' => 'array',
		'step_current' => 'integer',
	];
}