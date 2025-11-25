<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Settings;

class UsuarioRequest extends FormRequest
{
    private int $maxLoans;

    public function __construct()
    {
        parent::__construct();
        $settings = Settings::getAllSettings();
        $this->maxLoans = $settings['max_loans_per_user'] ?? 3;
    }

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
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'nullable|string|max:20',
            'max_emprestimos' => 'nullable|integer|min:1|max:' . $this->maxLoans,
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Informe um e-mail válido',
            'max_emprestimos.max' => 'O número máximo de empréstimos não pode exceder ' . $this->maxLoans,
        ];
    }
}
