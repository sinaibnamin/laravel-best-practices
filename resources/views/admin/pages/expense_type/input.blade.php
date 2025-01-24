@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;

        $action_url = route('admin_panel.expense_type.store');
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.expense_type.update', ['id' => $expense_type->id]);
        }

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        Expense type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Expense type</a></li>
                        <li class="breadcrumb-item active">{{ $edit_mode ? 'Edit' : 'Create' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        <form action="{{ $action_url }}" method="post" enctype="multipart/form-data" autocomplete="off">

                            @csrf
                            <div class="card-body row">

                                <div class="form-group col-12 col-md-6">
                                    <label>Expense type title</label>
                                    <input required value="{{ old('title', $expense_type->title ?? '') }}" name="title"
                                        type="text" class="form-control" placeholder="Utility bill">
                                </div>
                             
                             
                                <div class="form-group col-12 col-md-6">
                                    <label>Description</label>
                                    <input value="{{ old('description', $expense_type->description ?? '') }}" name="description"
                                        type="text" class="form-control"
                                        placeholder="here is the description of expense type">
                                </div>
                              
                                <div class="form-group  col-12 col-md-6">
                                    <label>Status</label>
                                    <select name='status' class="form-control" required>
                                        <option value="">Select status</option>
                                        <option
                                            {{ old('status', $expense_type->status ?? 'Active') == 'Active' ? 'selected' : '' }}
                                            value="Active">Active</option>
                                        <option
                                            {{ old('status', $expense_type->status ?? 'Active') == 'Inactive' ? 'selected' : '' }}
                                            value="Inactive">Inactive</option>
                                    </select>
                                </div>


                            </div>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('pagecss')
    <!-- Select2 -->

@endsection


@section('pagejs')
 
<script>
    const edit_mode = '{{ $edit_mode }}'

    if (edit_mode) {
        menu_parent_active('expense_type')
    } else {
        menu_make_active('expense_type-create')
    }
</script>




  
@endsection
