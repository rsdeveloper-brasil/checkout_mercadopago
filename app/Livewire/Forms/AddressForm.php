<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AddressForm extends Form
{
    #[Rule('required|string|max:9', message: 'Cep inválido')]
    public $zipcode = "57580-000";

    #[Rule('required|string|max:255')]
    public $address = "Rua Liberalina Amaral";

    #[Rule('required|string|max:255')]
    public $city = "Major Isidoro";

    #[Rule('required|string|max:2')]
    public $state = "AL";

    #[Rule('required|string|max:255')]
    public $district = "Centro";

    #[Rule('required|string|max:255')]
    public $number = "228";

    #[Rule('nullable|string|max:255')]
    public $complement = "Casa";

    public function findAddress()
    {
        $zipcode = preg_replace('/[^0-9]/im', '', $this->zipcode);
        $url = "https://viacep.com.br/ws/{$this->zipcode}/json/";
        $address = Http::get($url)->object();

        if (!$address || (isset($address->erro) && $address->erro)) {
            $this->addError('address.zipcode', 'Cep Inválido');
            return;
        }

        $this->address = $address->logradouro;
        $this->city = $address->localidade;
        $this->state = $address->uf;
        $this->district = $address->bairro;
    }
}
