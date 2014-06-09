<?php
class Trail extends Eloquent {
	protected $table = 'trails';
	protected $guarded = ['id'];

	public function client() {
		return $htis->belongsTo('Client', 'client_id', 'id');
	}

	public function nicetime() {
		return CarbonHelper::humanSeconds($this->time);
	}
}