<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nome'), 'has-success': fields.nome && fields.nome.valid }">
    <label for="nome" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.curso.columns.nome') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nome" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nome'), 'form-control-success': fields.nome && fields.nome.valid}" id="nome" name="nome" placeholder="{{ trans('admin.curso.columns.nome') }}">
        <div v-if="errors.has('nome')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nome') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('proposta'), 'has-success': fields.proposta && fields.proposta.valid }">
    <label for="proposta" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.curso.columns.proposta') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.proposta" v-validate="'required'" id="proposta" name="proposta" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('proposta')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('proposta') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('carga_horaria'), 'has-success': fields.carga_horaria && fields.carga_horaria.valid }">
    <label for="carga_horaria" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.curso.columns.carga_horaria') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.carga_horaria" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('carga_horaria'), 'form-control-success': fields.carga_horaria && fields.carga_horaria.valid}" id="carga_horaria" name="carga_horaria" placeholder="{{ trans('admin.curso.columns.carga_horaria') }}">
        <div v-if="errors.has('carga_horaria')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('carga_horaria') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('modo'), 'has-success': fields.modo && fields.modo.valid }">
    <label for="modo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.curso.columns.modo') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{-- <input type="text" v-model="form.modo" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('modo'), 'form-control-success': fields.modo && fields.modo.valid}" id="modo" name="modo" placeholder="{{ trans('admin.curso.columns.modo') }}"> --}}
        <multiselect
            v-model="form.modo"
            track-by="id"
            :options="{{ $modos->toJson() }}"
            :multiple="false"
            placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}"
            label="nome">
        </multiselect>
        <div v-if="errors.has('modo')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('modo') }}</div>
    </div>
</div>


