@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $action_url = route('admin_panel.setting.system_schedule.update');
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gymnasium Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item active">Schedule</li>
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
                                    <label>Gym schedule</label>
                                    <textarea style="min-height: 400px" id="editor" name="routine">{!! $system_schedule ?? '' !!}</textarea>
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
@endsection

@section('pagejs')
    <script>
        menu_parent_active('gym_schedule')
    </script>

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
                        options: [ 'left', 'center', 'right', 'justify' ]
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
