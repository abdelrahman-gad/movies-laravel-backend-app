<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
	use HasFactory;

	protected $guarded = ['id', 'created_at', 'updated_at'];
	protected $casts = ['category_id' => 'integer'];

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}
}
