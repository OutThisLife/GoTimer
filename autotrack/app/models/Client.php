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

			if (
				!is_array($r['main'])
				|| empty($r['main'][$info['dirname']])
			):
				$mt = new stdClass();

				$mt->id = $t->id;
				$mt->time = 0;
				$mt->path = $info['dirname'];
				$mt->updated_at = $t->updated_at;

				$r['main'][$info['dirname']] = $mt;
			endif;

			$r[$info['dirname']][] = $t;
			$r['main'][$info['dirname']]->time += $t->time;
		endforeach;


		return $trails;
	}
}
