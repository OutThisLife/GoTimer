<?php

use \Carbon\Carbon;

class CarbonHelper {
	public static function humanDiff(Carbon $t) {
		$diffInDays = $t->diffInDays(Carbon::now());

		if ($diffInDays === 0) $res = 'Today';
		else $res = $t->diffForHumans();

		return $res;
	}

	public static function humanSeconds($seconds) {
		$h = floor($seconds / 3600);
		$m = ($seconds / 60) % 60;
		$s = $seconds % 60;

		return sprintf("%01dhr %01dm %01ds", $h, $m, $s);
	}
}