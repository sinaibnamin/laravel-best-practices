@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Instruction list</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Instruction</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        $action_url = route('admin_panel.instruction.list');
        $current_page_mode = 'admin';
        $panel_url_prefix = 'admin_panel';
        if (get_user_role() == 'trainer') {
            $action_url = route('trainer_panel.instruction.list');
            $current_page_mode = 'trainer';
            $panel_url_prefix = 'trainer_panel';
        }
    @endphp

    <section class="content instruction-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4">
                                    <label>Member name</label>
                                    <select name='member_id' class="form-control select2" style="width: 100%;">
                                        <option value="">Select member</option>
                                        @foreach ($members as $member)
                                            <option {{ old('member_id') == $member->id ? 'selected' : '' }}
                                                {{ request()->get('member_id') == $member->id ? 'selected' : '' }}
                                                value="{{ $member->id }}">{{ $member->full_name }} (phone:
                                                {{ $member->phone_number }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($current_page_mode == 'admin')
                                    <div class="form-group mb-0 col-12 col-md-6 col-lg-4">
                                        <label>Trainer name</label>
                                        <select name='trainer_id' class="form-control select2" style="width: 100%;">
                                            <option value="">Select trainer</option>
                                            @foreach ($trainers as $trainer)
                                                <option {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}
                                                    {{ request()->get('trainer_id') == $trainer->id ? 'selected' : '' }}
                                                    value="{{ $trainer->id }}">{{ $trainer->full_name }} (phone:
                                                    {{ $trainer->phone_number }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-12 col-md-6 col-lg-3 col-xl-2">
                                    <button type="submit" class="btn btn-primary mt-3"><i class="fa-regular fa-filter"></i>
                                        Filter</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Trainer</th>
                                        <th style="max-width: 100%">Description</th>
                                        <th>time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($instructions as $instruction)
                                        <tr>
                                            <td id="member_{{ $instruction->id }}">
                                                @php
                                                    $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                                                    if (optional($instruction->member)->image) {
                                                        $member_img_url =
                                                            asset('/') .
                                                            'site_images/uploaded/member_images/' .
                                                            $instruction->member->image;
                                                    }
                                                @endphp

                                                
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2" style="height: max-content;width: max-content;">
                                                        <img src="{{ $member_img_url }}" alt="Product 1"
                                                            class="table-round-image">
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div style="text-wrap: wrap;">
                                                            {{ $instruction->member->full_name ?? 'not found' }}

                                                        </div>
                                                        <div>
                                                            {{ $instruction->member->uniq_id ?? 'not found' }}
                                                        </div>
                                                    </div>
                                                </div>


                                            </td>
                                            <td>
                                                @php
                                                    $trainer_img_url =
                                                        asset('/') . 'site_images/statics/super_user_dummy.jpg';
                                                    if (optional($instruction->trainer)->image) {
                                                        $trainer_img_url =
                                                            asset('/') .
                                                            'site_images/uploaded/trainer_images/' .
                                                            $instruction->trainer->image;
                                                    }
                                                @endphp



                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2" style="height: max-content;width: max-content;">
                                                        <img src="{{ $trainer_img_url }}" alt="Product 1"
                                                            class="table-round-image">
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div style="text-wrap: wrap;">
                                                            {{ $instruction->trainer->full_name ?? 'Trainer' }}
                                                        </div>
                                                        <div>
                                                            {{ $instruction->trainer->phone_number ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td id="instruction_{{ $instruction->id }}"
                                                style="text-wrap: wrap;min-width:250px;">
                                                {{ $instruction->description }}
                                            </td>

                                            <td>
                                                {!! \Carbon\Carbon::parse($instruction->created_at)->format('F d, Y') !!} <br />
                                                {!! \Carbon\Carbon::parse($instruction->created_at)->format('g:i A') !!}
                                            </td>




                                            <td>
                                                @if (get_user_role() == 'admin' || get_user_role() == 'trainer')
                                                    <a class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Edit"
                                                        href="{{ url('/' . $panel_url_prefix . '/instruction/edit/' . $instruction->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </a>

                                                    <a class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Permanent delete"
                                                        href="javascript:void(0)"
                                                        onclick="deletefunction('{{ $instruction->id }}')">
                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                    @else 
                                                    N/A
                                                @endif

                                            </td>

                                            <td class="d-none" id="delete_href_{{ $instruction->id }}">
                                                {{ url('/' . $panel_url_prefix . '/instruction/delete/' . $instruction->id) }}
                                            </td>

                                        </tr>
                                    @endforeach
                                    @if (count($instructions) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {{ $instructions->appends($_GET)->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin/pages/instruction/components/delete_modal')
@endsection


@section('pagejs')
    <script>
        const current_page_mode = '{{ $current_page_mode }}'

        if (current_page_mode == 'trainer') {
            menu_make_active('instruction-list')
        }

        if (current_page_mode == 'admin') {
            menu_make_active('instruction-list')
        }

        $('[data-toggle="tooltip"]').tooltip()
    </script>

    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
@endsection

@section('pagecss')
    <!-- Select2 -->
    <link rel="stylesheet" href="/admin_assets/plugins/select2/css/select2.min.css">
@endsection
