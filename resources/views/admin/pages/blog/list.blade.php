@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog list</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Blog</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>thumb</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                        <tr>
                                            <td id="blog_name_{{ $blog->id }}">
                                                {{ $blog->title }}                                         
                                            </td>
                                            <td id="blog_priority_{{ $blog->id }}">
                                                {{ $blog->thumb }}
                                            </td>

                                            <td id="blog_status_{{ $blog->id }}">
                                                @if ($blog->status == '0')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($blog->status == '1')
                                                    <span class="badge bg-success">Approved</span>
                                                @endif
                                                @if ($blog->status == '2')
                                                    <span class="badge bg-dark">Rejected</span>
                                                @endif
                                                @if ($blog->status == '3')
                                                    <span class="badge bg-warning">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="d-none" id="blog_delete_url_{{ $blog->id }}">
                                                {{ url('/admin/blog/delete/' . $blog->id) }}</td>
                                            <td>

                                                @if (get_user_role() == 'admin')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ url('/admin/blog/design/' . $blog->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Design
                                                    </a>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ url('/admin/blog/images/' . $blog->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Images
                                                    </a>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ url('/admin/blog/edit/' . $blog->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                    <a onclick="deletefunction('{{ $blog->id }}')"
                                                        class="btn btn-danger btn-sm" href="javascript:void(0)">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Delete
                                                    </a>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($blogs) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{-- <div class="pagination-wrapper">
                                {{ $blogs->links() }}
                            </div> --}}

                        </div>
                        <!-- /.card-body -->



                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- modal  --}}
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deletemodalLabel">Are You Sure To Delete?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Blog title</td>
                                <td id="modal_blog_name"></td>
                            </tr>
                            <tr>
                                <td>Priority</td>
                                <td id="modal_blog_priority"></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td id="modal_blog_status"></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a id="modal_blog_href" href="#" class="btn btn-danger">Delete permanently</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script>
        function deletefunction(id) {
            $('#modal_blog_name').text($('#blog_name_' + id).text())
            $('#modal_blog_priority').text($('#blog_priority_' + id).text())
            $('#modal_blog_status').html($('#blog_status_' + id).html())
            $('#modal_blog_href').attr("href", $('#blog_delete_url_' + id).text())
            $('#deletemodal').modal('show')
        }
    </script>


    <script>
        menu_make_active('blog-list')
    </script>
@endsection
