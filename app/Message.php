<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Chat;

class Message extends Model
{
	protected $fillable = ['sender_id', 'receiver_id', 'chat_id', 'message'];
	public function chat() {
		return $this->belongsTo(Chat::class);
	}
}
