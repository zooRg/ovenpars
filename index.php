<?php
/*
 * This file is part of MODX Revolution.
 *
 * Copyright (c) MODX, LLC. All Rights Reserved.
 *
 * For complete copyright and license information, see the COPYRIGHT and LICENSE
 * files found in the top-level directory of this distribution.
 */

$tstart= microtime(true);

/* define this as true in another entry file, then include this file to simply access the API
 * without executing the MODX request handler */
if (!defined('MODX_API_MODE')) {
    define('MODX_API_MODE', false);
}

/* include custom core config and define core path */
@include(dirname(__FILE__) . '/config.core.php');
if (!defined('MODX_CORE_PATH')) define('MODX_CORE_PATH', dirname(__FILE__) . '/core/');

/* include the modX class */
if (!@include_once (MODX_CORE_PATH . "model/modx/modx.class.php")) {
    $errorMessage = 'Site temporarily unavailable';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}

/* start output buffering */
ob_start();

/* Create an instance of the modX class */
$modx= new modX();
if (!is_object($modx) || !($modx instanceof modX)) {
    ob_get_level() && @ob_end_flush();
    $errorMessage = '<a href="setup/">MODX not installed. Install now?</a>';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}

/* Set the actual start time */
$modx->startTime= $tstart;

/* Initialize the default 'web' context */
$modx->initialize('web');

/* execute the request handler */
if (!MODX_API_MODE) {
    $modx->handleRequest();
}
?>
<script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
<div class="swiper-container">
	<div class="swiper-wrapper">
		<div class="swiper-slide">
			<div class="swiper-slide__img">
				<img src="https://media.lpgenerator.ru/images/553005/sloj-0-1_0wNtpEe.png" alt="">
			</div>
		</div>
		<div class="swiper-slide">
			<div class="swiper-slide__img">
				<img src="https://media.lpgenerator.ru/images/553005/sloj-0-1_0wNtpEe.png" alt="">
			</div>
		</div>
	</div>
	<!-- Add Arrows -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
</div>
<script>
	var swiper = new Swiper('.swiper-container', {
		autoHeight: true,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});
</script>
<style>
	.swiper-slide__img img,
	.swiper-slide__img,
	.swiper-slide {
		max-width: 320px;
		max-height: 320px;
	}
	.swiper-button-next,
	.swiper-button-prev {
		color: #ff1f55 !important;
	}
</style>