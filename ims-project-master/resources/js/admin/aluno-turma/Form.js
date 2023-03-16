import AppForm from '../app-components/Form/AppForm';

Vue.component('aluno-turma-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                aluno_id:  '' ,
                turma_id:  '' ,
                bol_current:  false ,
                data_matricula:  '' ,
                
            }
        }
    }

});