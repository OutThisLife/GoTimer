<?php
Validator::extend('alpha_spaces', function($attr, $value) {
	return preg_match('/^[\pL\s]+$/u', $value);
});