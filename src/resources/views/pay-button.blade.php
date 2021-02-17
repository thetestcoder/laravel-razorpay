<form action="{{route(config('laravel-razorpay.payment_submission_route_name'))}}" method="POST">
    <script src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ config('laravel-razorpay.api_key') }}"
            data-amount="{{$amount}}"
            data-buttontext="{{$btn_text}}"
            data-name="{{$name}}"
            data-description="{{$description}}"
            data-image="{{config('laravel-razorpay.logo_path')}}"
            data-theme.color="{{config('laravel-razorpay.theme_color')}}">
    </script>
    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
</form>
