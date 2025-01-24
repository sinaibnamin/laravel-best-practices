@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($trash_page)
                        <h1 class="m-0 text-danger">Member trash list</h1>
                    @else
                        <h1 class="m-0">Member list</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member category</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">

                    @php
                        $action_url = route('admin_panel.member.index');
                        if ($trash_page) {
                            $action_url = route('admin_panel.member.trashlist');
                        }
                    @endphp
                    {{-- filter form  --}}

                    <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                        <div class="card-body row align-items-end">

                            <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                <label>Full name</label>
                                <input value="{{ request()->get('full_name') }}" name="full_name" type="text"
                                    class="form-control" placeholder="full name">
                            </div>
                            <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                <label>Phone number</label>
                                <input value="{{ request()->get('phone_number') }}" name="phone_number" type="text"
                                    class="form-control" placeholder="0167379....">
                            </div>



                            <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                <label>Member status</label>
                                <select name='status' class="form-control">
                                    <option value="all">All</option>

                                    <option {{ request()->get('status') == 'Pending' ? 'selected' : '' }} value="Pending">
                                        Pending</option>
                                    <option {{ request()->get('status') == 'Active' ? 'selected' : '' }} value="Active">
                                        Active</option>
                                    <option {{ request()->get('status') == 'Inactive' ? 'selected' : '' }} value="Inactive">
                                        Inactive</option>

                                </select>
                            </div>


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



    <section class="content member-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th style="min-width: 150px; max-width:250px;">Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($members as $member)
                                        <tr>
                                            <td id="photo_{{ $member->id }}" >
                                                <div class="table-round-image"
                                                    @if ($member->image) style="background: url({{ asset('/') }}site_images/uploaded/member_images/{{ $member->image }});"
                                                @else
                                                style="background: url({{ asset('/') }}site_images/statics/profile_avatar.jpg);" @endif>
                                                </div>
                                            </td>
                                            <td class="" style="text-wrap:wrap;" id="name_{{ $member->id }}">
                                                {{ $member->full_name }}
                                            </td>
                                            <td id="age_{{ $member->id }}">
                                                @php
                                                    $dob = \Carbon\Carbon::parse($member->date_of_birth);
                                                    $now = \Carbon\Carbon::now();

                                                    // Calculate the age in years and months
                                                    $years = $dob->diffInYears($now);
                                                    $months = $dob->copy()->addYears($years)->diffInMonths($now);
                                                @endphp

                                                {{ $years . ' years, ' . $months . ' months' }}
                                            </td>
                                            <td >
                                                {{ $member->gender }}
                                            </td>
                                            <td id="phone_{{ $member->id }}">
                                                {{ $member->phone_number }}
                                            </td>

                                            <td id="status_{{ $member->id }}">
                                                @if ($member->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($member->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($member->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($member->status == 'Trash')
                                                    <span class="badge bg-danger">Trash</span>
                                                @endif
                                            </td>

                                          
                                            <td>
                                                <a class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View"
                                                    href="{{ url('/admin_panel/member/show/' . $member->id) }}">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                </a>
                                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"
                                                    href="{{ url('/admin_panel/member/edit/' . $member->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                                @if ($member->status != 'Inactive')
                                                    <a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Inactive"
                                                        href="{{ url('/admin_panel/member/make_inactive/' . $member->id) }}">
                                                        <i class="fa-solid fa-down"></i>
                                                    </a>
                                                @endif
                                                @if ($member->status != 'Pending')
                                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Pending"
                                                        href="{{ url('/admin_panel/member/make_pending/' . $member->id) }}">
                                                        <i class="fa-solid fa-down"></i>
                                                    </a>
                                                @endif

                                                @if ($member->status != 'Active')
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Active"
                                                        href="{{ url('/admin_panel/member/make_active/' . $member->id) }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                @endif
                                                @if ($member->status != 'Trash')
                                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Trash"
                                                        href="{{ url('/admin_panel/member/make_trash/' . $member->id) }}">
                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                @endif

                                                @if (get_user_role() == 'admin' && $member->status == 'Trash')
                                                    <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Permanent delete"
                                                    href="javascript:void(0)"
                                                    onclick="deletefunction('{{ $member->id }}')"
                                                    >
                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                @endif


                                            </td>


                                            <td class="d-none" id="member_delete_url_{{ $member->id }}">
                                                {{ url('/admin_panel/member/delete/' . $member->id) }}</td>


                                        </tr>
                                    @endforeach
                                    @if (count($members) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {{ $members->appends($_GET)->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.pages.member.components.delete_modal')

@endsection


@section('pagejs')
    <script>
        const trash_page = '{{ $trash_page }}'
        $('[data-toggle="tooltip"]').tooltip()

        if (trash_page) {
            menu_make_active('member-trashlist')
        } else {
            menu_make_active('member-list')
        }
    </script>
@endsection

@section('pagecss')
   
@endsection
