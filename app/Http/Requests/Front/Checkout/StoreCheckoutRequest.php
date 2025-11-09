<?php

namespace App\Http\Requests\Front\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $order_status = array_map(fn ($c) => $c->value, OrderStatus::cases());
        // $payment_status = array_map(fn ($c) => $c->value, PaymentStatus::cases());
        // $payment_method = array_map(fn ($c) => $c->value, PaymentMethod::cases());

        return [
            // 'status' => ['required', 'integer', Rule::in($order_status)],
            // 'payment_status' => ['required', 'integer', Rule::in($payment_status)],
            // 'payment_method' => ['required', 'integer', Rule::in($payment_method)],
            'addr' => ['sometimes', 'array'],
            'addr.*.first_name' => ['required_with:addr', 'string', 'max:255'],
            'addr.*.last_name' => ['nullable', 'string', 'max:255'],
            'addr.*.email' => ['nullable', 'email', 'max:255'],
            'addr.*.phone' => ['string', 'max:25'],
            'addr.*.street_address' => ['string', 'max:255'],
            'addr.*.city' => ['string', 'max:255'],
            'addr.*.post_code' => ['nullable', 'string', 'max:205'],
            'addr.*.state' => ['nullable', 'string', 'max:255'],
            'addr.*.country' => ['string', 'max:50'],
        ];
    }
}
