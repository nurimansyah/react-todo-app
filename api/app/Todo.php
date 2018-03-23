<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	/**
	 * Attributes
	 */
	protected $fillable = [
		'description', 'done'
	];
}