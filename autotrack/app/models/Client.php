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
			$base = $this->getBase($info['dirname']);

			# Add to main group - these are the rows that are clickable to show sub-children
			if (!is_array($r['main']) || empty($r['main'][$base])):
				$mt = new stdClass();

				$mt->id = $t->id;
				$mt->time = 0;
				$mt->path = $base;
				$mt->updated_at = $t->updated_at;

				$r['main'][$base] = $mt;
			endif;

			$r['main'][$base]->time += $t->time;

			# Default full list.
			if (!empty($r[$base][$t->path]))
				$r[$base][$t->path]->time += $t->time;

			else
				$r[$base][$t->path] = $t;
		endforeach;

		return $trails;
	}

	private function getBase($dir) {
		return preg_replace('/(.*' . $this->name . '.*?\\\\{1}.*?)\\\\{1}(.*)$/i', '$1', $dir);
	}
}
