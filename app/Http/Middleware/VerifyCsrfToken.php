<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    // ...
	    'wechat',
        //'/getRootSlug/*',
        '/notify_wechcat_pay',
        '/api/refundUploadImage/*',
        '/api/switchRefundUploadImage/*',
        '/zcjy/ajax/uploads',
        '/paysapi_return',
        '/paysapi_notify',
        'mini_notify',
        '/mini_event/*'

	];
}
