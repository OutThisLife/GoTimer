<?php

namespace Navigation;
use Request;

class NavHelper {
	public function isActive() {
		foreach (func_get_args() AS $p):
			$depth = 1;

			if (is_array($p)):
				$depth = key($p);
				$p = current($p);
			endif;

			if ($result = $this->tryPath($p, $depth))
				break;
		endforeach;

		return $result ? 'class=active' : '';
	}

	private function tryPath($path, $depth = 1) {
		return (
			Request::is($path)
			|| Request::segment($depth) === $path
		);
	}
}