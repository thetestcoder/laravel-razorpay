<?php

namespace TheTestCoder\LaravelRazorpay;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Razorpay\Api\Api;
use Razorpay\Api\Payment;
use TheTestCoder\LaravelRazorpay\Exceptions\PaymentCaptureException;

class LaravelRazorpay
{
    /**
     * @var Api
     */
    private Api $api;

    /**
     * For Current Payment
     */
    public Payment $payment;

    /**
     * LaravelRazorpay constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @param float $amount
     * @param string $btn_text
     * @param string $name
     * @param string $description
     * @return \Illuminate\Contracts\View\View
     */
    public function paymentButton(
        float $amount,
        string $btn_text,
        string $name,
        string $description
    ):
    \Illuminate\Contracts\View\View
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'amount' => $amount,
            'btn_text' => $btn_text,
        ];

        return View::make(
            "laravel-razorpay::pay-button",
            $data
        );
    }

    public function payment(Request $request): LaravelRazorpay
    {
        $this->payment = $this
            ->api
            ->payment
            ->fetch($request->razorpay_payment_id);

        return $this;
    }

    public function capture()
    {
        $this->payment = $this
            ->api
            ->payment
            ->fetch($this->payment->id)->capture(
                [
                    'amount' => $this->payment->amount,
                ]
            );
        throw_unless($this->payment->captured, new PaymentCaptureException());

        return $this;
    }

    public function redirectToRouteName(string $routeName): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($routeName);
    }

    public function redirectTo(callable $redirect)
    {
        return $redirect();
    }


}
