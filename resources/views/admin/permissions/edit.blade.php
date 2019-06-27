@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑权限
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'patch']) !!}

                        {!! Form::hidden('role_id', $role->id) !!} 

                        @include('admin.roles.fields', ['permissions' => $permissions, 'role' => $role, 'selectedPermissions' => $selectedPermissions])

                   {!! Form::close() !!}

               </div>
           </div>
       </div>
   </div>
@endsection

