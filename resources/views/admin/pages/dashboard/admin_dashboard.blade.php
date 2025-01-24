@extends('admin.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            @include('admin/pages/dashboard/components/counters/admin_counter')
            @include('admin/pages/dashboard/components/announcement/announcement_section')
            @include('admin/pages/dashboard/components/routine/gym_routine')
           
          


        </div>
    </section>
@endsection

@section('pagecss')
@endsection
@section('pagejs')
    <script>
        menu_parent_active('dashboard')
    </script>
@endsection
