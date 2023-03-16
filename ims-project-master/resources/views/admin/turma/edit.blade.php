@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.turma.actions.edit', ['name' => $turma->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <turma-form
                :action="'{{ $turma->resource_url }}'"
                :data="{{ $turma->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.turma.actions.edit', ['name' => $turma->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.turma.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </turma-form>

        </div>
    
</div>

@endsection