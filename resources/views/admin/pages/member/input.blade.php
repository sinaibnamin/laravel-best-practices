@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('admin_panel.member.store');
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.member.update', [$member->id]);
        }
        if (isset($user_mode) && $user_mode == 'member') {
            $current_user_mode = 'member';
            $action_url = route('member_panel.profile.update');
        }
        $get_user_role = get_user_role();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        member profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member</a></li>
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
                                    @php
                                        $ph_num_disable = '';
                                        if ($current_user_mode == 'member') {
                                            $ph_num_disable = 'disabled';
                                        }
                                        if ($edit_mode && $get_user_role == 'operator') {
                                            $ph_num_disable = 'disabled';
                                        }
                                    @endphp
                                    <label>Phone number <code>*</code> </label>
                                    <input required value="{{ old('phone_number', $member->phone_number ?? '') }}"
                                        name="phone_number" class="form-control" placeholder="01673790862" type="text"
                                        {{ $ph_num_disable }}>
                                </div>

                                <div
                                    class="form-group col-12 col-md-6 
                                 {{ $current_user_mode == 'member' ? 'd-none' : '' }}
                                ">
                                    <label>Password <code>{{ !$edit_mode ? '*' : '' }}</code> <small>( minimun 5 character,
                                            maximum 20 character )</small>
                                        <span class="text-info">
                                            {{ $edit_mode ? 'password already set, you can leave this field empty. if you type password agin then password will change for this user' : '' }}</span>

                                    </label>
                                    <input {{ $edit_mode ? '' : 'required' }} name="password" id="pass_field" type="text"
                                        class="form-control 
                                          {{ $edit_mode ? 'border-info' : '' }}
                                        "
                                        value="{{ old('password') }}" placeholder="Your password" minlength="5"
                                        maxlength="20">
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <label>Full name <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }}
                                        value="{{ old('full_name', $member->full_name ?? '') }}" name="full_name"
                                        type="text" class="form-control" placeholder="Your full name">
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <label>Email</label>
                                    <input
                                        value="{{ old('email', $member->email ?? '') }}" name="email" type="email"
                                        class="form-control" placeholder="Your email">
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label>NID or Birth Certificate number</label>
                                    <input value="{{ old('nid', $member->nid ?? '') }}"
                                        name="nid" type="text" class="form-control"
                                        placeholder="Your NID or Birth Certificate number">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Address</label>
                                    <input 
                                        value="{{ old('address', $member->address ?? '') }}" name="address" type="text"
                                        class="form-control" placeholder="Your address">
                                </div>
                                {{-- <div class="form-group col-12 col-md-4 col-lg-3">
                                    <label>Date of birth <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    <input {{ $edit_mode ? 'required' : '' }}
                                        value="{{ old('date_of_birth', $member->date_of_birth ?? '') }}"
                                        name="date_of_birth" type="date" class="form-control"
                                        placeholder="Your date of birth">
                                </div> --}}
                                <div class="form-group col-12 col-md-4 col-lg-3">
                                    <label>Date of birth <code> {{ $edit_mode ? '*' : '' }}</code></label>
                                    @php
                                        $datevalue = old('date_of_birth', isset($member->date_of_birth) ? \Carbon\Carbon::parse($member->date_of_birth)->format('d/m/Y') : '')
                                    @endphp
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input  {{ $edit_mode ? 'required' : '' }}
                                        value="{{ $datevalue }}" 
                                        type="text" 
                                        class="form-control datetimepicker-input" name="date_of_birth"
                                            data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate"
                                            data-toggle="datetimepicker" placeholder="Your date of birth">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-4 col-lg-3">
                                    <label>Gender</label>
                                    <select name='gender' class="form-control">
                                        <option value="">Select gender</option>
                                        <option {{ old('gender', $member->gender ?? '') == 'Male' ? 'selected' : '' }}
                                            value="Male">Male</option>
                                        <option {{ old('gender', $member->gender ?? '') == 'Female' ? 'selected' : '' }}
                                            value="Female">Female</option>
                                        <option {{ old('gender', $member->gender ?? '') == 'Other' ? 'selected' : '' }}
                                            value="Other">Other</option>

                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Emergency contact person name<small>(
                                            if you are injured somehow, then whom
                                            should we call? )</small> </label>
                                    <input
                                        value="{{ old('emergency_contact_name', $member->emergency_contact_name ?? '') }}"
                                        name="emergency_contact_name" type="text" class="form-control"
                                        placeholder="Your emergency contact person name">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Emergency contact person relation
                                        <small>( what is the relation with your
                                            Emergency contact person? )</small> </label>
                                    <input
                                        value="{{ old('emergency_contact_relationship', $member->emergency_contact_relationship ?? '') }}"
                                        name="emergency_contact_relationship" type="text" class="form-control"
                                        placeholder="father, brother, mother etc.">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Emergency contact person phone number
                                        <small>( 11 digit )</small> </label>
                                    <input 
                                        value="{{ old('emergency_contact_phone', $member->emergency_contact_phone ?? '') }}"
                                        name="emergency_contact_phone" type="number" class="form-control"
                                        placeholder="01673790862">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Fitness Goal</label>
                                    <input value="{{ old('fitness_goals', $member->fitness_goals ?? '') }}"
                                        name="fitness_goals" type="text" class="form-control"
                                        placeholder="Weight Loss, Muscle Gain, General Fitness, Endurance Training, Flexibility and Mobility, Sport-Specific Training, Rehabilitation and Injury Prevention, Body Toning, Stress Relief/Mental Health etc. ">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Blood Group</label>
                                    <input value="{{ old('blood_group', $member->blood_group ?? '') }}"
                                        name="blood_group" type="text" class="form-control" placeholder="B+, A-">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Profession</label>
                                    <input value="{{ old('profession', $member->profession ?? '') }}" name="profession"
                                        type="text" class="form-control" placeholder="Student, Job holder">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Weight</label>
                                    <input value="{{ old('weight', $member->weight ?? '') }}" name="weight"
                                        type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Height</label>
                                    <input value="{{ old('height', $member->height ?? '') }}" name="height"
                                        type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Neck</label>
                                    <input value="{{ old('neck', $member->neck ?? '') }}" name="neck" type="text"
                                        class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Shoulder</label>
                                    <input value="{{ old('shoulder', $member->shoulder ?? '') }}" name="shoulder"
                                        type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Chest</label>
                                    <input value="{{ old('chest', $member->chest ?? '') }}" name="chest"
                                        type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Abdomen</label>
                                    <input value="{{ old('abdomen', $member->abdomen ?? '') }}" name="abdomen"
                                        type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Waist</label>
                                    <input value="{{ old('waist', $member->waist ?? '') }}" name="waist"
                                        type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2">
                                    <label>Marital status</label>
                                    <input value="{{ old('marital_status', $member->marital_status ?? '') }}"
                                        name="marital_status" type="text" class="form-control"
                                        placeholder="Married, Unmarried">
                                </div>

                                @php
                                    $validity_disable = '';
                                    if ($edit_mode && $get_user_role == 'operator') {
                                        $validity_disable = 'disabled';
                                    }

                                    $validity_d_none = '';
                                    if ($get_user_role == 'member') {
                                        $validity_d_none = 'd-none';
                                    }
                                    if ($edit_mode == false) {
                                        $validity_d_none = 'd-none';
                                    }
                                @endphp

                                <div class="form-group col-6 col-md-4 col-lg-3 col-xl-2 {{ $validity_d_none }}">
                                    <label>Validity</label>
                                    <input {{ $validity_disable }} value="{{ old('validity', $member->validity ?? '') }}"
                                        name="validity" type="date" class="form-control" placeholder="">
                                </div>





                                <div class="form-group col-12">
                                    <label>Your medical condition <small>(max 500 character)</small> </label>
                                    <textarea maxlength="500" name="medical_conditions_details" type="text" class="form-control"
                                        placeholder="Your medical condition details" id="" cols="30" rows="3">{{ old('medical_conditions_details', $member->medical_conditions_details ?? '') }}</textarea>
                                </div>

                                @include('admin/partials/helpers/image_input', [
                                    'label_name' => 'Member',
                                    'max_size' => 10000000,
                                    'input_name' => 'image',
                                    'edit_variable' => $member ?? null,
                                    'edit_image_path' => asset('site_images/uploaded/member_images/'),
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


@section('pagecss')
    <link rel="stylesheet" href="/admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endsection

@section('pagejs')
    <script src="/admin_assets/plugins/moment/moment.min.js"></script>

    <script src="/admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


    <script>
        const current_user_mode = '{{ $current_user_mode }}'
        const edit_mode = '{{ $edit_mode }}'

        if (edit_mode) {

            if (current_user_mode == 'admin') {
                menu_parent_active('member')
            }
            if (current_user_mode == 'member') {
                menu_parent_active('setting')
            }

        } else {
            menu_make_active('member-create')
        }
    </script>

    <script>
        // Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY' // Set format to dd/mm/yyyy
        });
    </script>
@endsection
