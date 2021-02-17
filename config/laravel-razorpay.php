<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /**
     * api_key is required and you can your own key from razorpay account
     */
    "api_key" => env("RAZORPAY_API_KEY", ""),


    /**
     * api_secret is required and you can your own key from razorpay account
     */
    "api_secret" => env("RAZORPAY_API_SECRET", ""),


    /**
     * if you want to change payment submission URI for form you just change in env
     */
    "payment_submission_route_name" => env("RAZORPAY_PAYMENT_ROUTE_NAME", "payment"),

    /**
     * if you want to add your custom logo just add your image path with filename
     */
    "logo_path" => env("RAZORPAY_PAYMENT_LOGO_PATH", ""),

    /**
     * Payment box theme color
     */
    "theme_color" => env("RAZORPAY_PAYMENT_THEME_COLOR", "#343a40"),
];
