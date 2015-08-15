<?php

function setActive($path, $active = 'active') {
	return Request::is($path) ? $active : '';
}