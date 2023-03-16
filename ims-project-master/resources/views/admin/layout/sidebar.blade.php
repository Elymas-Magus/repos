<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.blog') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/publicacaos') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.publicacao.title') }}</a></li>


            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.administracao') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/alunos') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.aluno.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/cursos') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.curso.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/turmas') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.turma.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/disciplinas') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.disciplina.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/aluno-turmas') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.aluno-turma.title') }}</a></li>

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('ava/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('ava/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
