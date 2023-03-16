import AppForm from '../app-components/Form/AppForm';

Vue.component('aluno-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                registro_aluno:  '' ,
                data_nascimento:  '' ,
                fone:  '' ,
                email_responsavel:  '' ,
                ano_escolar:  '' ,
                nivel_escolaridade:  '' ,
                bol_nivel_concluido: true,
                first_name:  '' ,
                last_name:  '' ,
                email:  '' ,
                password:  '' ,
                activated:  true ,
                forbidden:  false ,
                language:  'en' ,
                turma: '',
            },
            datetimePickerConfig: {
              enableTime: true,
              time_24hr: true,
              enableSeconds: true,
              dateFormat: 'Y-m-d H:i:S',
              altInput: true,
              altFormat: 'd/m/Y H:i',
              locale: null
            },
        }
    },

});
