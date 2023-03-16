<?php

namespace App\Http\Requests\Admin\Aluno;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreAluno extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.aluno.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'registro_aluno' => ['required', 'string'],
            'data_nascimento' => ['required', 'date'],
            'fone' => ['nullable', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'turma' => ['nullable', 'array'],
            'email' => ['required', Rule::unique('admin_users', 'email'), 'string'],
            'password' => ['required', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],
            'email_responsavel' => ['nullable', 'string'],
            'ano_escolar' => ['nullable', 'integer'],
            'nivel_escolaridade' => ['required', 'array'],
            'bol_nivel_concluido' => ['required', 'boolean'],
            'forbidden' => ['nullable', 'boolean'],
            'activated' => ['nullable', 'boolean'],
            'language' => ['required', 'string'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getModifiedData(): array
    {
        $data = $this->only(collect($this->rules())->keys()->all());
        if (!Config::get('admin-auth.activation_enabled')) {
            $data['activated'] = true;
        }
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }
}
