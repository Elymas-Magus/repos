<div class="form-group row align-items-center" :class="{'has-danger': errors.has('titulo'), 'has-success': fields.titulo && fields.titulo.valid }">
    <label for="titulo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.publicacao.columns.titulo') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.titulo" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('titulo'), 'form-control-success': fields.titulo && fields.titulo.valid}" id="titulo" name="titulo" placeholder="{{ trans('admin.publicacao.columns.titulo') }}">
        <div v-if="errors.has('titulo')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('titulo') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('conteudo'), 'has-success': fields.conteudo && fields.conteudo.valid }">
    <label for="conteudo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.publicacao.columns.conteudo') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.conteudo" v-validate="'required'" id="conteudo" name="conteudo" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('conteudo')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('conteudo') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('bol_permitir_comentario'), 'has-success': fields.bol_permitir_comentario && fields.bol_permitir_comentario.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="bol_permitir_comentario" type="checkbox" v-model="form.bol_permitir_comentario" v-validate="''" data-vv-name="bol_permitir_comentario"  name="bol_permitir_comentario_fake_element">
        <label class="form-check-label" for="bol_permitir_comentario">
            {{ trans('admin.publicacao.columns.bol_permitir_comentario') }}
        </label>
        <input type="hidden" name="bol_permitir_comentario" :value="form.bol_permitir_comentario">
        <div v-if="errors.has('bol_permitir_comentario')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bol_permitir_comentario') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('bol_agendar'), 'has-success': fields.bol_agendar && fields.bol_agendar.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="bol_agendar" type="checkbox" v-model="form.bol_agendar" v-validate="''" data-vv-name="bol_agendar"  name="bol_agendar_fake_element">
        <label class="form-check-label" for="bol_agendar">
            {{ trans('admin.publicacao.columns.bol_agendar') }}
        </label>
        <input type="hidden" name="bol_agendar" :value="form.bol_agendar">
        <div v-if="errors.has('bol_agendar')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bol_agendar') }}</div>
    </div>
</div>

<div v-if="form.bol_agendar" class="form-group row align-items-center" :class="{'has-danger': errors.has('data_inicio'), 'has-success': fields.data_inicio && fields.data_inicio.valid }">
    <label for="data_inicio" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.publicacao.columns.data_inicio') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.data_inicio" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('data_inicio'), 'form-control-success': fields.data_inicio && fields.data_inicio.valid}" id="data_inicio" name="data_inicio" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('data_inicio')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('data_inicio') }}</div>
    </div>
</div>


