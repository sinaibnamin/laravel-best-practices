@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">Package list</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Package</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php

        $d_none_member_class = '';
        if (get_user_role() == 'member') {
            $d_none_member_class = 'd-none';
        }

    @endphp


    <section class="content package-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Package name</th>
                                        <th>Description</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Duration</th>
                                        <th class="{{ $d_none_member_class }}">Status</th>
                                        <th class="{{ $d_none_member_class }}">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td id="package_{{ $package->id }}">{{ $package->name }}</td>
                                            <td style="text-wrap: wrap;min-width:250px;">

                                                @if ($package->description)
                                                    {{ $package->description }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td id="price_{{ $package->id }}" class="text-right">
                                                @if ($package->price == 0)
                                                    N/A
                                                @elseif ($package->discount > 0)
                                                    <del class="text-secondary">{{ $package->price }}</del>
                                                    <span
                                                        class="text-bold text-success h5">{{ $package->price - $package->discount }}</span>
                                                @else
                                                    <span class="text-bold h5">{{ $package->price }}</span>
                                                @endif
                                            </td>

                                            <td class="text-right">
                                                @php
                                                    $days = $package->duration;
                                                    $displayDuration = '';

                                                    if ($days == 0) {
                                                        $displayDuration = 'N/A';
                                                    } else {
                                                        $years = floor($days / 360);
                                                        $remainingDaysAfterYears = $days % 360;
                                                        $months = floor($remainingDaysAfterYears / 30);
                                                        $remainingDays = $remainingDaysAfterYears % 30;

                                                        if ($years > 0) {
                                                            $displayDuration .=
                                                                $years . ' year' . ($years > 1 ? 's' : '');
                                                        }
                                                        if ($months > 0) {
                                                            $displayDuration .=
                                                                ($displayDuration ? ' ' : '') .
                                                                $months .
                                                                ' month' .
                                                                ($months > 1 ? 's' : '');
                                                        }
                                                        if ($remainingDays > 0) {
                                                            $displayDuration .=
                                                                ($displayDuration ? ' and ' : '') .
                                                                $remainingDays .
                                                                ' day' .
                                                                ($remainingDays > 1 ? 's' : '');
                                                        }
                                                    }
                                                @endphp

                                                {{ $displayDuration }}
                                            </td>


                                            <td id="status_{{ $package->id }}" class="{{ $d_none_member_class }}">
                                                @if ($package->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($package->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($package->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($package->status == 'Trash')
                                                    <span class="badge bg-danger">Trash</span>
                                                @endif
                                            </td>
                                            <td class="{{ $d_none_member_class }}">

                                                @if (get_user_role() == 'admin')
                                                    <a class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Edit"
                                                        href="{{ url('/admin_panel/package/edit/' . $package->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </a>


                                                    @if ($package->status != 'Inactive')
                                                        <a class="btn btn-dark btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Inactive"
                                                            href="{{ url('/admin_panel/package/change_status/Inactive/' . $package->id) }}">
                                                            <i class="fa-solid fa-down"></i>
                                                        </a>
                                                    @endif


                                                    @if ($package->status != 'Active')
                                                        <a class="btn btn-success btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Active"
                                                            href="{{ url('/admin_panel/package/change_status/Active/' . $package->id) }}">
                                                            <i class="fa-solid fa-check"></i>
                                                        </a>
                                                    @endif


                                                    @if ($package->payments_count < 1)
                                                        <a class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Permanent delete"
                                                            href="javascript:void(0)"
                                                            onclick="deletefunction('{{ $package->id }}')">
                                                            <i class="fa-sharp fa-regular fa-trash"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    N/A
                                                @endif

                                            </td>


                                            <td class="d-none" id="delete_href_{{ $package->id }}">
                                                {{ url('/admin_panel/package/delete/' . $package->id) }}</td>

                                        </tr>
                                    @endforeach
                                    @if (count($packages) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('admin/pages/package/components/delete_modal')
@endsection


@section('pagejs')
    <script>
        menu_make_active('package-list')
        $role = '{{ get_user_role() }}'
        if ($role == 'member') {
            menu_parent_active('package')
        }


        $('[data-toggle="tooltip"]').tooltip()
    </script>
@endsection

@section('pagecss')
@endsection
