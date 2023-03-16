import AppForm from '../app-components/Form/AppForm';

Vue.component('disciplina-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nome:  '' ,
                turma:  '' ,
                professor:  '' ,
                curso: '' ,
                lancar_para: '',
                lancar_para_turma: '',
                lancar_para_curso: '',
                activated:  true ,

            }
        }
    },
    watch: {
        'form.lancar_para': {
            handler: function () {
                var _this = this;
                if (_this.form.lancar_para === 'lancar_para_turma') {
                    _this.form.lancar_para_turma = true;
                    _this.form.lancar_para_curso = false;
                } else if (_this.form.lancar_para === 'lancar_para_curso') {
                    _this.form.lancar_para_turma = false;
                    _this.form.lancar_para_curso = true;
                }
            },
        },
    }

});
