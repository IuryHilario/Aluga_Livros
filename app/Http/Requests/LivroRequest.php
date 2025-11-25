<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
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
        return [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'editor' => 'nullable|string|max:255',
            'ano_publicacao' => 'required|integer|min:1000|max:' . date('Y'),
            'quantidade' => 'required|integer|min:0',
            'capa' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O titulo é obrigatório',
            'autor.required' => 'O autor é obrigatório',
            'ano_publicacao.required' => 'O ano de publicação é obrigatório',
            'quantidade.required' => 'A quantidade é obrigatório',

            'titulo.string' => 'O titulo tem que ser escrito',
            'autor.string' => 'O autor tem que ser escrito',
            'editor.string' => 'O editor tem que ser escrito',
            'ano_publicacao.integer' => 'O ano de publicação tem que ser número inteiro',
            'quantidade.integer' => 'A quantidade tem que ser número inteiro',
            'capa.image' => 'Capa tem que ser uma imagem',

            'ano_publicacao.min' => 'Ano de publicação no minimo no ano de :min',
            'quantidade.min' => 'Quantidade minima :min',

            'titulo.max' => 'Máximo de :max caracteres',
            'autor.max' => 'Máximo de :max caracteres',
            'editor.max' => 'Máximo de :max caracteres',
            'ano_publicacao.max' => 'No máximo no ano de :max',
            'capa.max' => 'Tamanho de máximo de :max B',
        ];
    }
}
