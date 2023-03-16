<?php

namespace App\Http\Requests\Admin\Aluno;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAluno extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.aluno.edit', $this->aluno);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'registro_aluno' => ['sometimes', 'string'],
            'data_nascimento' => ['sometimes', 'date'],
            'fone' => ['nullable', 'string'],
            'email_responsavel' => ['nullable', 'string'],
            'ano_escolar' => ['nullable', 'integer'],
            'nivel_escolaridade' => ['sometimes', 'array'],
            'bol_nivel_concluido' => ['required', 'boolean'],
            'first_name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'turma' => ['sometimes', 'array'],
            'email' => ['sometimes', 'email', Rule::unique('admin_users', 'email')->ignore($this->aluno->user->getKey(), $this->aluno->user->getKeyName()), 'string'],
            'password' => ['sometimes', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
