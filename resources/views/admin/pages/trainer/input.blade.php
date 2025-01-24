@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('admin_panel.trainer.store');
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.trainer.update', [$trainer->id]);
        }
        if (isset($user_mode) && $user_mode == 'trainer') {
            $current_user_mode = 'trainer';
            $action_url = route('trainer_panel.profile.update');
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        trainer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Trainer</a></li>
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
                                    <label>Phone number <code>*</code> <small>( 11 digit )</small> </label>
                                    <input required value="{{ old('phone_number', $trainer->phone_number ?? '') }}"
                                        name="phone_number" class="form-control" placeholder="01673790862" type="text"
                                        {{ $current_user_mode == 'trainer' ? 'disabled' : '' }}>
                                </div>

                                <div
                                    class="form-group col-12 col-md-6 
                                {{ $current_user_mode == 'trainer' ? 'd-none' : '' }}
                               ">
                                    <label>Password <code>{{ !$edit_mode ? '*' : '' }}</code> <small>( minimun 5 character, maximum 20 character )</small>
                                        <span class="text-info">
                                            {{ $edit_mode ? 'password already set, you can leave this field empty. if you type password agin then password will change for this user' : '' }}</span>

                                    </label>
                                    <input {{ $edit_mode ? '' : 'required' }} value="" name="password" id="pass_field"
                                        type="text"
                                        class="form-control 
                                         {{ $edit_mode ? 'border-info' : '' }}
                                       "
                                        placeholder="Your password" minlength="5" maxlength="20">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Full name <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }} value="{{ old('full_name', $trainer->full_name ?? '') }}" name="full_name"
                                        type="text" class="form-control" placeholder="Your full name">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Address <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }} value="{{ old('address', $trainer->address ?? '') }}" name="address"
                                        type="text" class="form-control" placeholder="Your address">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Email <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }} value="{{ old('email', $trainer->email ?? '') }}" name="email" type="email"
                                        class="form-control" placeholder="Your email">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>NID or Birth Certificate number <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }} value="{{ old('nid', $trainer->nid ?? '') }}" name="nid" type="text"
                                        class="form-control" placeholder="Your NID or Birth Certificate number">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Date of birth <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }} value="{{ old('date_of_birth', $trainer->date_of_birth ?? '') }}"
                                        name="date_of_birth" type="date" class="form-control"
                                        placeholder="Your date of birth">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Gender <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <select {{ $edit_mode ? 'required' : '' }} name='gender' class="form-control">
                                        <option value="">Select gender</option>
                                        <option {{ old('gender', $trainer->gender ?? '') == 'Male' ? 'selected' : '' }}
                                            value="Male">Male</option>
                                        <option {{ old('gender', $trainer->gender ?? '') == 'Female' ? 'selected' : '' }}
                                            value="Female">Female</option>
                                        <option {{ old('gender', $trainer->gender ?? '') == 'Other' ? 'selected' : '' }}
                                            value="Other">Other</option>

                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Emergency contact person name <code> {{ $edit_mode ? '*' : '' }}</code> <small>( if you are injured somehow, then whom
                                            should we call? )</small> </label>
                                    <input {{ $edit_mode ? 'required' : '' }}
                                        value="{{ old('emergency_contact_name', $trainer->emergency_contact_name ?? '') }}"
                                        name="emergency_contact_name" type="text" class="form-control"
                                        placeholder="Your emergency contact person name">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Emergency contact person relation <code> {{ $edit_mode ? '*' : '' }}</code> <small>( what is the relation with your
                                            Emergency contact person? )</small> </label>
                                    <input {{ $edit_mode ? 'required' : '' }}
                                        value="{{ old('emergency_contact_relationship', $trainer->emergency_contact_relationship ?? '') }}"
                                        name="emergency_contact_relationship" type="text" class="form-control"
                                        placeholder="example: father, brother, mother etc.">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Emergency contact person phone number  <code> {{ $edit_mode ? '*' : '' }}</code> <small>( 11 digit )</small> </label>
                                    <input {{ $edit_mode ? 'required' : '' }}
                                        value="{{ old('emergency_contact_phone', $trainer->emergency_contact_phone ?? '') }}"
                                        name="emergency_contact_phone" type="number" class="form-control"
                                        placeholder="01673790862">
                                </div>






                                @include('admin/partials/helpers/image_input', [
                                    'label_name' => 'Trainer',
                                    'input_name' => 'image',
                                    'edit_variable' => $trainer ?? null,
                                    'edit_image_path' => asset('site_images/uploaded/trainer_images/'),
                                ])









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



@section('pagejs')
    <script>
        const current_user_mode = '{{ $current_user_mode }}'
        const edit_mode = '{{ $edit_mode }}'

      
        if (edit_mode) {

            if (current_user_mode == 'admin') {
                menu_parent_active('trainer')
            }
            if (current_user_mode == 'trainer') {
                menu_parent_active('setting')
            }


        } else {
            menu_make_active('trainer-create')
        }
    </script>
@endsection
