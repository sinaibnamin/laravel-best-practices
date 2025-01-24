@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')



    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog Images</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Blog </a></li>
                        <li class="breadcrumb-item active">images</li>
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

                        <form action="{{ route('admin.blog.images.store', [$blog->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Files</label>
                                    <input accept="image/png, image/jpg, image/jpeg, image/gif" type="file"
                                        name="filepond[]" multiple />
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        <div class="card-body">

                            <div class="blog-images">
                                @if ($blog->images)
                                    @foreach (json_decode($blog->images) as $image)
                                        {{-- <img src="{{ url('/') }}/site_images/uploaded/blog_images/{{ $image }}"
                                        alt=""> --}}
                                        <div class="blog-image"
                                            style="background:url({{ url('/') }}/site_images/uploaded/blog_images/{{ $image }}) no-repeat center ">
                                            <a href="{{ url('/admin/blog/image/delete/' . $blog->id . '/' . $image) }}" class="delete-icon">
                                                <i class="fa-regular fa-trash"></i>
                                            </a>
                                        </div>
                                    @endforeach
                            </div>
                        @else
                            <p class="text-danger"> no image here!</p>
                            @endif




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('pagecss')
    <style>
        .blog-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .blog-image {
            position: relative;
            width: 250px;
            height: 250px;
            background-size: cover !important;
        }

        .blog-image .delete-icon {
            position: absolute;
            width: max-content;
            height: max-content;
            padding: 4px 8px;
            border-radius: 5px;
            top: 10px;
            right: 10px;
            background: #dc3546;
            color: #fff;
        }
        .blog-image .delete-icon i{
            font-size: 15px;
        }
    </style>


    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endsection
@section('pagejs')
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>


    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>




    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateSize,
            FilePondPluginFileEncode,
            FilePondPluginFileValidateType
        );



        // get a reference to the input element
        const inputElement = document.querySelector('input[type="file"]');

        // create a FilePond instance at the input element location
        const pond = FilePond.create(inputElement, {
            maxFiles: 30,
            allowBrowse: true,
            maxFileSize: '1MB',
            acceptedFileTypes: ["image/png, image/jpg, image/jpeg, image/gif"],
        });
    </script>



    <script>
        const edit_mode = '{{ $edit_mode ?? false }}';

        if (edit_mode) {
            menu_parent_active('blog')
        } else {
            menu_make_active('blog-create')
        }
    </script>
@endsection
