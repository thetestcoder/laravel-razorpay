<?php

namespace TheTestCoder\LaravelRazorpay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thetestcoder\LaravelRazorpay\LaravelRazorpay
 */
class LaravelRazorpayFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-razorpay';
    }
}
