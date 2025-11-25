<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $id;
    public $name;
    public $labelNome;
    public $type;
    public $placeHolder;
    public $required;
    public $value;

    public function __construct(
        $name = null,
        $id = null,
        $labelNome = null,
        $type = 'text',
        $placeHolder = null,
        $value = null,
        $required = false,
    ) {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->labelNome = $labelNome;
        $this->type = $type;
        $this->placeHolder = $placeHolder;
        $this->value = $value;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.form.input');
    }
}
