@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('trainer_panel.instruction.store');

        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('trainer_panel.instruction.update', [$instruction->id]);
        }

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        instruction</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Instruction</a></li>
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
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Member name</label>
                                    <select required name="member_id" class="form-control select2" style="width: 100%;">
                                        <option value="">Select member</option>
                                        @foreach ($members as $member)
                                        @php
                                            $selected = old('member_id', $instruction->member_id ?? '') == $member->id ? 'selected' : '';
                                            $disbled_class = $member->status == 'Active' ? '' : 'disabled';
                                            $disbled_text = $member->status == 'Active' ? '' : '(not active)';
                                        @endphp

                                            <option value="{{ $member->id }}"
                                                {{ $selected }} 
                                                {{ $disbled_class }}
                                                >
                                                {{ $member->full_name }} (phone:
                                                {{ $member->phone_number }}) {{$disbled_text}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Write instruction for him</label>
                                    <textarea required class="form-control" name="description" id="" cols="30" rows="5">{{ old('description', $instruction->description ?? '') }}</textarea>
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
    <link rel="stylesheet" href="/admin_assets/plugins/select2/css/select2.min.css">
    <style>
        .instruction-amount-digits {
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection


@section('pagejs')
    <script>

         const edit_mode = '{{ $edit_mode }}'
       
        if (edit_mode) {

            menu_parent_active('instruction')

        } else {
            menu_make_active('instruction-create')
        }
    </script>


    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
@endsection
