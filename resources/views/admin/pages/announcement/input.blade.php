@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('admin_panel.announcement.store');
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.announcement.update', ['id' => $announcement->id]);
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        announcement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Announcement</a></li>
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


                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>Announcement type</label>
                                    <select id="announcementType" name='type' class="form-control" required>
                                        <option value="">Select type</option>
                                        <option {{ old('type', $announcement->type ?? '') == 'danger' ? 'selected' : '' }}
                                            value="danger">danger</option>
                                        <option {{ old('type', $announcement->type ?? '') == 'warning' ? 'selected' : '' }}
                                            value="warning">warning</option>
                                        <option {{ old('type', $announcement->type ?? '') == 'info' ? 'selected' : '' }}
                                            value="info">info</option>
                                        <option {{ old('type', $announcement->type ?? '') == 'success' ? 'selected' : '' }}
                                            value="success">success</option>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>Priority</label>
                                    <input value="{{ old('priority', $announcement->priority ?? '') }}" name="priority"
                                        type="number" class="form-control" placeholder="1 or 2 or 3">
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>Status</label>
                                    <select name='status' class="form-control" required>
                                        <option value="">Select status</option>
                                        <option
                                            {{ old('status', $announcement->status ?? '') == 'Active' ? 'selected' : '' }}
                                            value="Active">Active</option>
                                        <option
                                            {{ old('status', $announcement->status ?? '') == 'Inactive' ? 'selected' : '' }}
                                            value="Inactive">Inactive</option>
                                    </select>
                                </div>


                                <div class="form-group col-12">
                                    <label>Headline</label>
                                    <input value="{{ old('headline', $announcement->headline ?? '') }}" name="headline"
                                        type="text" class="form-control" placeholder="announcement headline" required>
                                </div>

                                <div class="form-group col-12">
                                    <label>Description <small>(max 500 character)</small> </label>
                                    <textarea maxlength="500" name="description" type="text" class="form-control" placeholder="announcement detail"
                                        id="" cols="30" rows="3" required>{{ old('description', $announcement->description ?? '') }}</textarea>
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
        .announcement-amount-digits {
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection


@section('pagejs')
    <script>
        const edit_mode = '{{ $edit_mode }}'

        if (edit_mode) {
            menu_parent_active('announcement')
        } else {
            menu_make_active('announcement-create')
        }
    </script>



    <script>
        const announcementTypeSelect = document.getElementById('announcementType');

        // Function to update background color based on selected option
        function updateSelectBackground() {
            // Remove all background classes
            announcementTypeSelect.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-success');

            // Get the selected type
            const selectedType = announcementTypeSelect.value;

            // Add the corresponding class based on selected type
            if (selectedType) {
                announcementTypeSelect.classList.add(`bg-${selectedType}`);
            }
        }

        // Listen for changes on the select element
        announcementTypeSelect.addEventListener('change', updateSelectBackground);

        // Call the function on page load to set the initial background color
        updateSelectBackground();
    </script>

    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
@endsection
