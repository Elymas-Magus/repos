import AppForm from '../app-components/Form/AppForm';

Vue.component('curso-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nome:  '' ,
                proposta:  '' ,
                carga_horaria:  '' ,
                modo:  '' ,

            }
        }
    }

});
