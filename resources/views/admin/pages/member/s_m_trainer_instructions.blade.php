@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Trainer Instructions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member</a></li>
                        <li class="breadcrumb-item active">Trainer Instructions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content member-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="direct-chat-messages">

                                @if ($member->status != 'Active')
                                <div class="text-danger text-bold">Please activate your account to see trainers instructions</div>
                                @endif

                                @if ($member->status == 'Active')

                                @foreach ($instructions as $instruction)
                                    <div class="direct-chat-msg mb-4">
                                        <div class="direct-chat-infos clearfix">
                                            <span
                                                class="direct-chat-name float-left">{{ $instruction->trainer->full_name ?? 'Trainer' }}</span>
                                            <span class="direct-chat-timestamp float-right">
                                                {{ \Carbon\Carbon::parse($instruction->created_at)->format('F d, Y / g:i A') }}
                                            </span>

                                        </div>


                                        @php
                                            $trainer_img_url = asset('/') . 'site_images/statics/super_user_dummy.jpg';
                                            if (isset($instruction->trainer->image) && $instruction->trainer->image) {
                                                $trainer_img_url =
                                                    asset('/') .
                                                    'site_images/uploaded/trainer_images/' .
                                                    $instruction->trainer->image;
                                            }
                                        @endphp

                                        <img class="direct-chat-img" src="{{ $trainer_img_url }}" alt="message user image">




                                        <div class="direct-chat-text">
                                            {{ $instruction->description }}
                                        </div>
                                    </div>
                                @endforeach

                                @if (count($instructions) == 0)
                                    <div class="text-danger text-bold">You have no instruction yet</div>
                                @endif



                            
                                @endif

                                


                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('pagejs')
    <script>
        menu_parent_active('trainer-instructions')
    </script>
@endsection

@section('pagecss')
    <style>

    </style>
@endsection
