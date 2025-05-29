<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    /**
     * https://livewire.laravel.com/docs/forms#submitting-a-form
     * https://livewire.laravel.com/docs/forms#adding-validation
     * https://github.com/LaravelLegends/pt-br-validator
     *
     * ATENÇÃO: O form request não funciona do livewire
     */
//    #[Rule('required|email|unique:users,email')]

    #[Rule('required|email')]
    public $email = "";

    #[Rule('required|min:3|max:255')]
    public $name = "Rosivaldo da Silva";

    #[Rule('nullable|min:3|cpf')]
    public $cpf = "04693902470";
}
