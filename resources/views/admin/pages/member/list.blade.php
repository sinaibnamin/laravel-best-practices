@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($archive_page)
                        <h1 class="m-0 text-danger">Member archive list</h1>
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

    <section class="content member-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        @php
                            $action_url = route('admin_panel.member.index');
                            if ($archive_page) {
                                $action_url = route('admin_panel.member.archivelist');
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
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2 col-xxl-1">
                                    <label>Uniq ID</label>
                                    <input value="{{ request()->get('uniq_id') }}" name="uniq_id" type="text"
                                        class="form-control" placeholder="Uniq ID">
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Phone number</label>
                                    <input value="{{ request()->get('phone_number') }}" name="phone_number" type="text"
                                        class="form-control" placeholder="0167379....">
                                </div>

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2 col-xxl-1 {{$archive_page ? 'd-none' : ''}}">
                                    <label>Member status</label>
                                    <select name='status' class="form-control">
                                        <option value="all">All</option>

                                        <option {{ request()->get('status') == 'Pending' ? 'selected' : '' }}
                                            value="Pending">
                                            Pending</option>
                                        <option {{ request()->get('status') == 'Active' ? 'selected' : '' }} value="Active">
                                            Active</option>
                                       
                                        <option {{ request()->get('status') == 'Expire' ? 'selected' : '' }}
                                            value="Expire">
                                            Expire</option>

                                    </select>
                                </div>

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Validity from</label>
                                    <input value="{{ request()->get('validity_from') }}" name="validity_from" type="date"
                                        class="form-control" placeholder="Inquery no">
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Validity to</label>
                                    <input value="{{ request()->get('validity_to') }}" name="validity_to" type="date"
                                        class="form-control" placeholder="Inquery no">
                                </div>


                                <div class="col-12 col-md-6 col-lg-3 col-xl-2 col-xxl-1">
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
                                        <th style="min-width: 150px; max-width:250px;">Member</th>
                                        <th>Unique ID</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Validity</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($members as $member)
                                        <tr>
                                            <td id="photo_{{ $member->id }}">

                                                @php
                                                    $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                                                    if ($member->image) {
                                                        $member_img_url =
                                                            asset('/') .
                                                            'site_images/uploaded/member_images/' .
                                                            $member->image;
                                                    }
                                                @endphp

                                                <a href="{{ url('/admin_panel/member/show/' . $member->id) }}" class="table-user-row-info">
                                                    <div class="img-wrapper">
                                                        <img src="{{ $member_img_url }}"
                                                            alt="Product 1" class="table-round-image">
                                                    </div>
                                                    <div class="right-part">
                                                        <div class="name">
                                                            {{$member->full_name}}
                                                        </div>
                                                        <div class="id">
                                                            <small>Uique ID: {{$member->uniq_id}}</small>
                                                        </div>
                                                  
                                                    </div>
                                                </a>
                                            </td>
                                            <td  id="uniq_id_{{ $member->id }}">
                                                {{ $member->uniq_id }}
                                            </td>
                                       
                                            <td id="age_{{ $member->id }}">
                                                @php
                                                    $dob = \Carbon\Carbon::parse($member->date_of_birth);
                                                    $now = \Carbon\Carbon::now();

                                                    // Calculate the age in years and months
                                                    $years = $dob->diffInYears($now);
                                                @endphp

                                                {{ $years . ' years' }}
                                            </td>
                                         
                                            <td>
                                                {{ $member->gender }}
                                            </td>
                                          
                                            <td id="phone_{{ $member->id }}">
                                                {{ $member->phone_number }}
                                            </td>
                                            <td>
                                                @if ($member->validity)
                                                    {{ \Carbon\Carbon::parse($member->validity)->format('M d, Y') }}
                                                @else
                                                    N/A
                                                @endif

                                            </td>

                                            <td id="status_{{ $member->id }}">
                                                @if ($member->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($member->status == 'Approve')
                                                    <span class="badge bg-warning">Approve</span>
                                                @endif
                                                @if ($member->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($member->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($member->status == 'Archive')
                                                    <span class="badge bg-secondary">Archive</span>
                                                @endif
                                                @if ($member->status == 'Expire')
                                                    <span class="badge bg-danger">Expire</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="View"
                                                    href="{{ url('/admin_panel/member/show/' . $member->id) }}">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                </a>
                                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"
                                                    href="{{ url('/admin_panel/member/edit/' . $member->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                               


                                                @if ($member->status != 'Active' && $member->status != 'Pending')
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Active"
                                                        href="{{ url('/admin_panel/member/change_status/Active/' . $member->id) }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                @endif
                                                @if ($member->status == 'Pending' || $member->status == 'Inactive' || $member->status == 'Archive')
                                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Approve"
                                                        href="{{ url('/admin_panel/member/change_status/Approve/' . $member->id) }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                @endif
                                                @if ($member->status != 'Archive')
                                                    <a class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Archive"
                                                        href="{{ url('/admin_panel/member/change_status/Archive/' . $member->id) }}">
                                                        <i class="fa-regular fa-inbox"></i>

                                                    </a>
                                                @endif

                                                @if (get_user_role() == 'admin' && $member->status == 'Archive')
                                                    <a class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Permanent delete"
                                                        href="javascript:void(0)"
                                                        onclick="deletefunction('{{ $member->id }}')">
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
        const archive_page = '{{ $archive_page }}'
        $('[data-toggle="tooltip"]').tooltip()

        if (archive_page) {
            menu_make_active('member-archivelist')
        } else {
            menu_make_active('member-list')
        }
    </script>
@endsection

@section('pagecss')
@endsection
