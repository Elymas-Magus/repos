import AppForm from '../app-components/Form/AppForm';

Vue.component('turma-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nome:  '' ,
                curso:  '' ,
                activated:  true ,

            }
        }
    }

});
