@extends('admin.master')
@section('content')

@include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Siteinfo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Siteinfo</a></li>
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

                        <form action="{{ route('admin.site_info.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label >Website title</label>
                                    <input name="site_title" type="text" class="form-control" placeholder="Site Title"
                                    value="{{$siteinfo->site_title}}">
                                </div>
                               
                                <div class="form-group">
                                    <label >Website Description</label>
                                    <input name="site_description" type="text" class="form-control" placeholder="site_description"
                                        value="{{ $siteinfo->site_description }}">
                                </div>
                                <div class="form-group">
                                    <label >Website Headline</label>
                                    <input name="site_headline_en" type="text" class="form-control" placeholder="site_headline_en"
                                        value="{{ $siteinfo->site_headline_en }}">
                                </div>
                                <div class="form-group">
                                    <label >Website Headline Bangla</label>
                                    <input name="site_headline_bn" type="text" class="form-control" placeholder="site_headline_bn"
                                        value="{{ $siteinfo->site_headline_bn }}">
                                </div>
                                <div class="form-group">
                                    <label >Website SubHeadline</label>
                                        <textarea class="form-control" name="site_subheadline_en" id="" cols="30" rows="4">{{ $siteinfo->site_subheadline_en }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label >Website SubHeadline Bangla</label>
                                        <textarea class="form-control" name="site_subheadline_bn" id="" cols="30" rows="4">{{ $siteinfo->site_subheadline_bn }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label >Website foot note</label>
                                    <input name="site_footnote_en" type="text" class="form-control" placeholder="site_footnote_en"
                                        value="{{ $siteinfo->site_footnote_en }}">
                                </div>
                                <div class="form-group">
                                    <label >Website foot note Bangla</label>
                                    <input name="site_footnote_bn" type="text" class="form-control" placeholder="site_footnote_bn"
                                        value="{{ $siteinfo->site_footnote_bn }}">
                                </div>
                                <div class="form-group">
                                    <label >Facebook Link</label>
                                    <input name="site_facebook" type="text" class="form-control" placeholder="site_facebook"
                                        value="{{ $siteinfo->site_facebook }}">
                                </div>
                                <div class="form-group">
                                    <label >Twitter Link</label>
                                    <input name="site_twitter" type="text" class="form-control" placeholder="site_twitter"
                                        value="{{ $siteinfo->site_twitter }}">
                                </div>
                                <div class="form-group">
                                    <label >Instagram Link</label>
                                    <input name="site_instagram" type="text" class="form-control" placeholder="site_instagram"
                                        value="{{ $siteinfo->site_instagram }}">
                                </div>
                                <div class="form-group">
                                    <label >Linkedin Link</label>
                                    <input name="site_linkedin" type="text" class="form-control" placeholder="site_linkedin"
                                        value="{{ $siteinfo->site_linkedin }}">
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
    <script src="https://cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
  
    <script>
        menu_make_active('site_info-edit')
    </script>
@endsection
