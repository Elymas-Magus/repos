import AppForm from '../app-components/Form/AppForm';

Vue.component('publicacao-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titulo:  '' ,
                conteudo:  '' ,
                bol_permitir_comentario:  true ,
                bol_agendar:  false ,
                data_inicio:  '' ,

            }
        }
    }

});
