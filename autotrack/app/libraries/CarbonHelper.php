<?php

use \Carbon\Carbon;

class CarbonHelper {
	public static function humanDiff(Carbon $t) {
		$d = $t->diffForHumans();
		$hours = $t->diffInHours();
		$days = $t->diffInDays();

		if ($hours >= 12 && $hours <= 24) $d = 'Yesterday';
		elseif ($days === 0) $d = 'Today';

		return $d;
	}

	public static function humanSeconds($seconds) {
		$h = floor($seconds / 3600);
		$m = ($seconds / 60) % 60;
		$s = $seconds % 60;

		return sprintf("%01dhr %01dm %01ds", $h, $m, $s);
	}
}