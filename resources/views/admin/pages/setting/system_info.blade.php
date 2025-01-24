@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $action_url = route('admin_panel.setting.system_info.update');

        $system_logo = asset('/') . 'site_images/statics/system_logo.png';
        $system_icon = asset('/') . 'site_images/statics/system_icon.jpg';

        $system_info_img_folder = asset('/') . 'site_images/uploaded/system_info/';

        $system_logo = $system_info->system_logo ? $system_info_img_folder . $system_info->system_logo : $system_logo;

        $system_icon = $system_info->system_icon ? $system_info_img_folder . $system_info->system_icon : $system_icon;

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">System Information</h1>                
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item active">System Info</li>
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
                                    <label>Site name</label>
                                    <input required value="{{ $system_info->system_name ?? '' }}" name="system_name"
                                        type="text" class="form-control" placeholder="system name">
                                </div>

                                <div class="form-group row align-items-center">
                                    <div class="col">
                                        <label>Site logo <small>( 200px by 200px )</small> </label>
                                        <input type="file" class="form-control h-unset" name="system_logo">
                                    </div>
                                    <div class="col-auto">

                                        <img class="site-logo-placeholder" src="{{ $system_logo }}" alt="">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <div class="col">
                                        <label>Site icon <small>( 50px by 50px )</small> </label>
                                        <input type="file" class="form-control h-unset" name="system_icon">
                                    </div>
                                    <div class="col-auto">

                                        <img class="site-icon-placeholder" src="{{ $system_icon }}" alt="">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label>Print header </label>
                                    <textarea style="min-height: 400px" id="editor2" name="print_header">{!! $system_info->print_header ?? '' !!}</textarea>
                                </div>


                            </div>


                            <div class="card-footer">
                                <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pagecss')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
    <style>
        .site-icon-placeholder {
            max-width: 33px;
            max-height: 33px;
        }

        .site-logo-placeholder {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
@endsection


@section('pagejs')
    <script>
        menu_make_active('setting-system_info');
    </script>
    <!-- CKEditor 5 -->
    <script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
        }
    }
    </script>


    <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font,
            Table,
            TableToolbar,
            TableCellProperties,
            SourceEditing,
            List,
            Link,
            Alignment
        } from 'ckeditor5';

        document.querySelectorAll('#editor, #editor2').forEach(editorElement => {
            ClassicEditor
                .create(editorElement, {
                    plugins: [
                        Essentials,
                        Paragraph,
                        Bold,
                        Italic,
                        Font,
                        Table,
                        TableToolbar,
                        TableCellProperties,
                        SourceEditing,
                        List,
                        Link,
                        Alignment
                    ],
                    toolbar: [
                        'undo', 'redo', '|',
                        'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify', '|',
                        'insertTable', 'tableCellProperties', '|',
                        'numberedList', 'bulletedList', '|',
                        'link', '|',
                        'sourceEditing'
                    ],
                    fontSize: {
                        options: [
                            '8px',
                            '10px',
                            '12px',
                            '14px',
                            '16px',
                            '18px',
                            '24px',
                            '36px',
                            '48px'
                        ],
                        supportAllValues: true // Enables custom font size entry
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells', '|',
                            'tableCellProperties'
                        ]
                    },
                    alignment: {
                        options: ['left', 'center', 'right', 'justify']
                    }
                })
                .then(editor => {
                    console.log('Editor initialized for', editorElement);
                })
                .catch(error => {
                    console.error('Error initializing editor for', editorElement, error);
                });
        });
    </script>
@endsection
