@extends('admin.master')
@section('content')

    @if (session('success'))
        <div class="content-header pb-0">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible mb-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5 class="mb-0"><i class="icon fas fa-check"></i> {{ session('success') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="content-header pb-0">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible mb-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Siteimage</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Siteimage</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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

                        <form action="{{ route('admin.siteimage.update') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="form-group col-6">
                                        <label>Site Logo <small>(max: 50KB, dimension 180x50 px | PNG)</small> </label>
                                        <div class="custom-file">
                                            <input name="sitelogo" type="file" class="form-control h-unset"
                                                id="customFile">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="curr-img">
                                            @if (!$siteimage->sitelogo)
                                                <img class="" src="{{ asset('images') }}/siteimage/logo.png"
                                                    alt="">
                                            @else
                                                <img class=""
                                                    src="{{ asset('images') }}/siteimage/{{ $siteimage->sitelogo }}"
                                                    alt="">
                                            @endif
                                        </div>
                                    </div>
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

@section('pagejs')
  
    <script>
        menu_make_active('siteinfo-image')
    </script>
@endsection
