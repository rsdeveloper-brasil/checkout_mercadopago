<?php

namespace App\Livewire;

use App\Enums\CheckoutStepsEnum;
use App\Exceptions\PaymentException;
use App\Livewire\Forms\AddressForm;
use App\Livewire\Forms\UserForm;
use App\Services\CheckoutService;
use Livewire\Component;

class Checkout extends Component
{
    /** posso usar como controller */

    public array $cart = [];
    public int $step = CheckoutStepsEnum::INFORMATION->value;
    public int|null $method = null;
    public UserForm $user;
    public AddressForm $address;

    /**
     * clico de vida inicia com o mount()
     */
    public function mount(CheckoutService $checkoutService)
    {
        $this->cart = $checkoutService->loadCart();
        $this->user->email = config('payment.mercadopago.buyer_email');
    }

    public function findAddress()
    {
        $this->address->findAddress();
    }

    public function submitInformationStep()
    {
        $this->user->validate();
        $this->address->validate();
        $this->step = CheckoutStepsEnum::SHIPPING->value;
    }

    public function submitShippingStep()
    {
        $this->step = CheckoutStepsEnum::PAYMENT->value;
    }

    /** os dados do cartão chega por aqui... */
    public function creditCardPayment(CheckoutService $checkoutService, $data)
    {
        try {
            $checkoutService->creditCardPayment($data);
        } catch (PaymentException $e) {
            $this->addError('payment', $e->getMessage());
        } catch (\Exception $ec) {
            $this->addError('payment', $ec->getMessage());
        }
    }

    public function pixOrBankSlipPayment(CheckoutService $checkoutService, $data)
    {
        dd($data);
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
