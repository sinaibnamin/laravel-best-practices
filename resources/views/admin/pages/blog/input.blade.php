@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $action_url = route('admin.blog.store');       
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin.blog.update', [$blog->id]);
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Blog Category</a></li>
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

                        <form action="{{ $action_url }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Blog title</label>
                                    <input value="{{ old('name_en', $blog->name_en ?? '') }}" name="name_en"
                                        type="text" class="form-control" placeholder="Blog title">
                                </div>
                              
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name='status' class="form-control">
                                        <option {{ old('status', $blog->status ?? '') === 1 ? 'selected' : '' }}
                                            value="1">Active</option>
                                        <option {{ old('status', $blog->status ?? '') === 0 ? 'selected' : '' }}
                                            value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Files</label>
                                    <input accept="image/png, image/jpg, image/jpeg, image/gif" type="file" name="filepond[]"  multiple />
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
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
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
    const edit_mode = '{{$edit_mode ?? false}}';

    if(edit_mode){
        menu_parent_active('blog')
    }else{
        menu_make_active('blog-create')
    }
    
</script>


@endsection
