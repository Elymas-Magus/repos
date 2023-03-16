<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'aluno' => [
        'title' => 'Alunos',

        'actions' => [
            'index' => 'Alunos',
            'create' => 'New Aluno',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'registro_aluno' => 'Registro aluno',
            'data_nascimento' => 'Data nascimento',
            'fone' => 'Fone',
            'email_responsavel' => 'Email responsavel',
            'ano_escolar' => 'Ano escolar',
            'nivel_escolaridade_id' => 'Nivel escolaridade',
            
        ],
    ],

    'curso' => [
        'title' => 'Cursos',

        'actions' => [
            'index' => 'Cursos',
            'create' => 'New Curso',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'nome' => 'Nome',
            'proposta' => 'Proposta',
            'carga_horaria' => 'Carga horaria',
            'modo_id' => 'Modo',
            
        ],
    ],

    'turma' => [
        'title' => 'Turmas',

        'actions' => [
            'index' => 'Turmas',
            'create' => 'New Turma',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'nome' => 'Nome',
            'curso_id' => 'Curso',
            'activated' => 'Activated',
            
        ],
    ],

    'disciplina' => [
        'title' => 'Disciplinas',

        'actions' => [
            'index' => 'Disciplinas',
            'create' => 'New Disciplina',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'nome' => 'Nome',
            'turma_id' => 'Turma',
            'professor_id' => 'Professor',
            'activated' => 'Activated',
            
        ],
    ],

    'aluno-turma' => [
        'title' => 'Aluno Turma',

        'actions' => [
            'index' => 'Aluno Turma',
            'create' => 'New Aluno Turma',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'aluno_id' => 'Aluno',
            'turma_id' => 'Turma',
            'bol_current' => 'Bol current',
            'data_matricula' => 'Data matricula',
            
        ],
    ],

    'publicacao' => [
        'title' => 'Publicacao',

        'actions' => [
            'index' => 'Publicacao',
            'create' => 'New Publicacao',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'conteudo' => 'Conteudo',
            'criado_por' => 'Criado por',
            'qtd_views' => 'Qtd views',
            'bol_permitir_comentario' => 'Bol permitir comentario',
            'bol_agendar' => 'Bol agendar',
            'data_inicio' => 'Data inicio',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];