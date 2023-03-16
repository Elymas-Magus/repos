<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Aluno::class, static function (Faker\Generator $faker) {
    return [
        'registro_aluno' => $faker->sentence,
        'data_nascimento' => $faker->dateTime,
        'fone' => $faker->sentence,
        'email_responsavel' => $faker->sentence,
        'ano_escolar' => $faker->randomNumber(5),
        'nivel_escolaridade_id' => $faker->randomNumber(5),
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Curso::class, static function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,
        'proposta' => $faker->text(),
        'carga_horaria' => $faker->randomNumber(5),
        'modo_id' => $faker->randomNumber(5),
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Turma::class, static function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,
        'curso_id' => $faker->randomNumber(5),
        'activated' => $faker->boolean(),
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Disciplina::class, static function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,
        'turma_id' => $faker->sentence,
        'professor_id' => $faker->randomNumber(5),
        'activated' => $faker->boolean(),
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\AlunoTurma::class, static function (Faker\Generator $faker) {
    return [
        'aluno_id' => $faker->sentence,
        'turma_id' => $faker->sentence,
        'bol_current' => $faker->boolean(),
        'data_matricula' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Publicacao::class, static function (Faker\Generator $faker) {
    return [
        'titulo' => $faker->sentence,
        'conteudo' => $faker->text(),
        'criado_por' => $faker->randomNumber(5),
        'qtd_views' => $faker->randomNumber(5),
        'bol_permitir_comentario' => $faker->boolean(),
        'bol_agendar' => $faker->boolean(),
        'data_inicio' => $faker->dateTime,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
