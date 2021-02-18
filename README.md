# Project Info

## Budge Goes Here

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thetestcoder/laravel-razorpay.svg?style=flat-square)](https://packagist.org/packages/thetestcoder/laravel-razorpay)
[![Build Status](https://img.shields.io/travis/thetestcoder/laravel-razorpay/master.svg?style=flat-square)](https://travis-ci.org/thetestcoder/laravel-razorpay)
[![Quality Score](https://img.shields.io/scrutinizer/g/thetestcoder/laravel-razorpay.svg?style=flat-square)](https://scrutinizer-ci.com/g/thetestcoder/laravel-razorpay)
[![Total Downloads](https://img.shields.io/packagist/dt/thetestcoder/laravel-razorpay.svg?style=flat-square)](https://packagist.org/packages/thetestcoder/laravel-razorpay)

> This package is under development so please use at your own risk

## Installation

You can install the package via composer:

```bash
composer require thetestcoder/laravel-razorpay
```

## Usage

``` env
RAZORPAY_API_KEY=your-api-key
RAZORPAY_API_SECRET=your-api-secret

```

### In Blade file

``` php

 {!! \TheTestCoder\LaravelRazorpay\LaravelRazorpayFacade::paymentButton(
    1000,
    "Pay 10 Rupees",
    "The Test Coder",
    "Order Value From Test Coder"
    )
     !!}
     
  // or
  
  {{ \TheTestCoder\LaravelRazorpay\LaravelRazorpayFacade::paymentButton(
        1000,
        "Pay 10 Rupees",
        "The Test Coder",
        "Order Value From Test Coder"
        [$id] # extra params for routes
        )
    }}

```

### Routes

``` php

Route::get('pay', 'YourController@payView')->name('pay.view');

// Payment Request
Route::post('payment', 'YourController@payment')->name('payment'); // if you change name('your custom name')

// please add extra .env value ===>  RAZORPAY_PAYMENT_ROUTE_NAME=your-route-name 

// or 

Route::post('payment/{param}', 'YourController@payment')->name('payment');


```

### YourController

``` php

public function payView()
    {
        return view('payment-page');
    }

    public function payment(Request $request)
    {
        return LaravelRazorpayFacade::payment($request)
                        ->capture()
                        ->redirectToRouteName('payment');
    }
    
    # also can do like this
    public function payment(Request $request)
    {
        $razorpay = LaravelRazorpayFacade::payment($request)->capture();
    
        return $razorpay->redirectIf($razorpay->payment->error_code === null, function () {
            return redirect()->back();
        });
    }

```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email thetestcoder@gmail.com instead of using the issue tracker.

## Credits

- [The Test Coder](https://github.com/thetestcoder)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
