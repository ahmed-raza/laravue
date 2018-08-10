<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;
use App\User;

class Chat extends Model
{
	protected $fillable = [];
	public function messages() {
		return $this->hasMany(Message::class);
	}
	public function users() {
		return $this->belongsToMany(User::class);
	}
}
