<div class="form-group row align-items-center" :class="{'has-danger': errors.has('registro_aluno'), 'has-success': fields.registro_aluno && fields.registro_aluno.valid }">
    <label for="registro_aluno" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno.columns.registro_aluno') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.registro_aluno" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('registro_aluno'), 'form-control-success': fields.registro_aluno && fields.registro_aluno.valid}" id="registro_aluno" name="registro_aluno" placeholder="{{ trans('admin.aluno.columns.registro_aluno') }}">
        <div v-if="errors.has('registro_aluno')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('registro_aluno') }}</div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.admin-user.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" id="first_name" name="first_name" placeholder="{{ trans('admin.admin-user.columns.first_name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="last_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.admin-user.columns.last_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.last_name" v-validate="'required'" @input="validate($event)" class="form-control" id="last_name" name="last_name" placeholder="{{ trans('admin.admin-user.columns.last_name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.admin-user.columns.email') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.email" v-validate="'required|email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.admin-user.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
    <label for="password" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.admin-user.columns.password') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.password" v-validate="'min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.admin-user.columns.password') }}" ref="password">
        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
    <label for="password_confirmation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.admin-user.columns.password_repeat') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.password_confirmation" v-validate="'confirmed:password|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('admin.admin-user.columns.password') }}" data-vv-as="password">
        <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password_confirmation') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('data_nascimento'), 'has-success': fields.data_nascimento && fields.data_nascimento.valid }">
    <label for="data_nascimento" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno.columns.data_nascimento') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.data_nascimento" :config="datetimePickerConfig" v-validate="'required'" class="flatpickr" :class="{'form-control-danger': errors.has('data_nascimento'), 'form-control-success': fields.data_nascimento && fields.data_nascimento.valid}" id="data_nascimento" name="data_nascimento" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('data_nascimento')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('data_nascimento') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('fone'), 'has-success': fields.fone && fields.fone.valid }">
    <label for="fone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno.columns.fone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.fone" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('fone'), 'form-control-success': fields.fone && fields.fone.valid}" id="fone" name="fone" placeholder="{{ trans('admin.aluno.columns.fone') }}">
        <div v-if="errors.has('fone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('fone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email_responsavel'), 'has-success': fields.email_responsavel && fields.email_responsavel.valid }">
    <label for="email_responsavel" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno.columns.email_responsavel') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.email_responsavel" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email_responsavel'), 'form-control-success': fields.email_responsavel && fields.email_responsavel.valid}" id="email_responsavel" name="email_responsavel" placeholder="{{ trans('admin.aluno.columns.email_responsavel') }}">
        <div v-if="errors.has('email_responsavel')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email_responsavel') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nivel_escolaridade'), 'has-success': fields.nivel_escolaridade && fields.nivel_escolaridade.valid }">
    <label for="nivel_escolaridade" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno.columns.nivel_escolaridade_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect
            v-model="form.nivel_escolaridade"
            track-by="id"
            :options="{{ $niveis_escolaridade->toJson() }}"
            :multiple="false"
            placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}"
            label="nome">
        </multiselect>
        <div v-if="errors.has('nivel_escolaridade')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nivel_escolaridade') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('turma'), 'has-success': fields.turma && fields.turma.valid }">
    <label for="turma" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.disciplina.columns.turma_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{-- <input type="text" v-model="form.turma_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('turma_id'), 'form-control-success': fields.turma_id && fields.turma_id.valid}" id="turma_id" name="turma_id" placeholder="{{ trans('admin.disciplina.columns.turma_id') }}"> --}}
        <multiselect
            v-model="form.turma"
            track-by="id"
            :options="{{ $turmas->toJson() }}"
            :multiple="false"
            placeholder="{{ trans('admin.forms.select_turmas') }}"
            label="nome">
        </multiselect>
        <div v-if="errors.has('turma')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('turma') }}</div>
    </div>
</div>

<div class="form-group row" :class="{'has-danger': errors.has('bol_nivel_concluido'), 'has-success': fields.bol_nivel_concluido && fields.bol_nivel_concluido.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="bol_nivel_concluido" type="checkbox" v-model="form.bol_nivel_concluido" v-validate="''" data-vv-name="bol_nivel_concluido"  name="bol_nivel_concluido_fake_element">
        <label class="form-check-label" for="bol_nivel_concluido">
            {{ trans('admin.admin-user.columns.bol_nivel_concluido') }}
        </label>
        <input type="hidden" name="bol_nivel_concluido" :value="form.bol_nivel_concluido">
        <div v-if="errors.has('bol_nivel_concluido')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bol_nivel_concluido') }}</div>
    </div>
</div>

<div v-if="!form.bol_nivel_concluido" class="form-group row align-items-center" :class="{'has-danger': errors.has('ano_escolar'), 'has-success': fields.ano_escolar && fields.ano_escolar.valid }">
    <label for="ano_escolar" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno.columns.ano_escolar') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ano_escolar" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ano_escolar'), 'form-control-success': fields.ano_escolar && fields.ano_escolar.valid}" id="ano_escolar" name="ano_escolar" placeholder="{{ trans('admin.aluno.columns.ano_escolar') }}">
        <div v-if="errors.has('ano_escolar')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ano_escolar') }}</div>
    </div>
</div>

<div class="form-group row" :class="{'has-danger': errors.has('activated'), 'has-success': fields.activated && fields.activated.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="activated" type="checkbox" v-model="form.activated" v-validate="''" data-vv-name="activated"  name="activated_fake_element">
        <label class="form-check-label" for="activated">
            {{ trans('admin.admin-user.columns.activated') }}
        </label>
        <input type="hidden" name="activated" :value="form.activated">
        <div v-if="errors.has('activated')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('activated') }}</div>
    </div>
</div>

<div class="form-group row" :class="{'has-danger': errors.has('forbidden'), 'has-success': fields.forbidden && fields.forbidden.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="forbidden" type="checkbox" v-model="form.forbidden" v-validate="''" data-vv-name="forbidden"  name="forbidden_fake_element">
        <label class="form-check-label" for="forbidden">
            {{ trans('admin.admin-user.columns.forbidden') }}
        </label>
        <input type="hidden" name="forbidden" :value="form.forbidden">
        <div v-if="errors.has('forbidden')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('forbidden') }}</div>
    </div>
</div>


