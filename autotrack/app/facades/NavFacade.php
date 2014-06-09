<?php
class NavFacade extends \Illuminate\Support\Facades\Facade {
	protected static function getFacadeAccessor() {
		return 'Nav';
	}
}