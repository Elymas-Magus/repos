<div class="form-group row align-items-center" :class="{'has-danger': errors.has('aluno_id'), 'has-success': fields.aluno_id && fields.aluno_id.valid }">
    <label for="aluno_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno-turma.columns.aluno_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.aluno_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('aluno_id'), 'form-control-success': fields.aluno_id && fields.aluno_id.valid}" id="aluno_id" name="aluno_id" placeholder="{{ trans('admin.aluno-turma.columns.aluno_id') }}">
        <div v-if="errors.has('aluno_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('aluno_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('turma_id'), 'has-success': fields.turma_id && fields.turma_id.valid }">
    <label for="turma_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.aluno-turma.columns.turma_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.turma_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('turma_id'), 'form-control-success': fields.turma_id && fields.turma_id.valid}" id="turma_id" name="turma_id" placeholder="{{ trans('admin.aluno-turma.columns.turma_id') }}">
        <div v-if="errors.has('turma_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('turma_id') }}</div>
    </div>
</div>