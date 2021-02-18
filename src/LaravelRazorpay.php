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
     * @param array $params
     * @return \Illuminate\Contracts\View\View
     */
    public function paymentButton(
        float $amount,
        string $btn_text,
        string $name,
        string $description,
        array $params = []
    ):
    \Illuminate\Contracts\View\View
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'amount' => $amount,
            'btn_text' => $btn_text,
            'params' => $params,
        ];

        return View::make(
            "laravel-razorpay::pay-button",
            $data
        );
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function payment(Request $request): self
    {
        $this->payment = $this
            ->api
            ->payment
            ->fetch($request->razorpay_payment_id);

        return $this;
    }

    /**
     * @return $this
     * @throws \Throwable
     */
    public function capture(): self
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

    /**
     * @param string $routeName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRouteName(string $routeName): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($routeName);
    }

    /**
     * @param callable $redirect
     * @return mixed
     */
    public function redirectTo(callable $redirect)
    {
        return $redirect();
    }

    /**
     * @param bool $expression
     * @param string $routeName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRouteIf(bool $expression, string $routeName): \Illuminate\Http\RedirectResponse
    {
        if ($expression) {
            return $this->redirectToRouteName($routeName);
        }
    }

    /**
     * @param bool $expression
     * @param callable $redirect
     * @return mixed
     */
    public function redirectIf(bool $expression, callable $redirect)
    {
        if ($expression) {
            return $this->redirectTo($redirect);
        }
    }
}
