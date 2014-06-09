<?php
class Client extends Eloquent {
	protected $table = 'clients';
	protected $guarded = ['id'];
	public static $rules = [
		'name' => 'required|alpha_spaces|min:3',
	];

	public function trails() {
		return $this->hasMany('Trail')->orderBy('created_at', 'desc');
	}

	public function organizedTrails() {
		$trails = [];

		foreach ($this->trails AS &$t):
			$r =& $trails[CarbonHelper::humanDiff($t->created_at)];
			$info = pathinfo($t->path);
			$base = preg_replace('/(.*' . $this->name . '.*?\\\\{1}.*?)\\\\{1}(.*)$/i', '$1', $info['dirname']);

			if (
				!is_array($r['main'])
				|| empty($r['main'][$base])
			):
				$mt = new stdClass();

				$mt->id = $t->id;
				$mt->time = 0;
				$mt->path = $base;
				$mt->updated_at = $t->updated_at;

				$r['main'][$base] = $mt;
			endif;

			$r[$base][] = $t;
			$r['main'][$base]->time += $t->time;
		endforeach;

		return $trails;
	}
}
