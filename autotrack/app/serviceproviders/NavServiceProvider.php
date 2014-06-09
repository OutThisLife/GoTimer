<?php
class NavServiceProvider extends \Illuminate\Support\ServiceProvider {
	public function register() {
		$this->app->bind('Nav', function() {
			return new Navigation\NavHelper;
		});
	}
}