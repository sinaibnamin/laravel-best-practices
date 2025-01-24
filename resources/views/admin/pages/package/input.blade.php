@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;

        $action_url = route('admin_panel.package.store');
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.package.update', ['id' => $package->id]);
        }

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        Package</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Package</a></li>
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

                        <form action="{{ $action_url }}" method="post" enctype="multipart/form-data" autocomplete="off">

                            @csrf
                            <div class="card-body row">

                                <div class="form-group col-12 col-md-6">
                                    <label>Package Name</label>
                                    <input required value="{{ old('name', $package->name ?? '') }}" name="name"
                                        type="text" class="form-control" placeholder="Example: 2 Months with treadmil">
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label>Price <small>( in taka )</small></label>
                                    <input required value="{{ old('price', $package->price ?? 0) }}" name="price"
                                        type="number" class="form-control payment-price-digits" placeholder=""
                                        onkeydown="return event.key !== 'e'" step="1" min="0">
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label>Discount <small>( in taka )</small></label>
                                    <input required value="{{ old('discount', $package->discount ?? 0) }}" name="discount"
                                        type="number" class="form-control payment-price-digits" placeholder=""
                                        onkeydown="return event.key !== 'e'" step="1" min="0">
                                </div>

                                <div class="form-group  col-12">
                                    <label>Description</label>
                                    <input value="{{ old('description', $package->description ?? '') }}" name="description"
                                        type="text" class="form-control"
                                        placeholder="Example: Suitable for fat loss in two months">
                                </div>
                                <div class="form-group  col-12 col-md-6">
                                    <label>Duration <small>( in days )</small> </label>
                                    <input required value="{{ old('duration', $package->duration ?? 0) }}" name="duration"
                                        type="number" class="form-control">
                                    <small id="calculateText" class="form-text text-primary text-bold"></small>
                                </div>
                                <div class="form-group  col-12 col-md-6">
                                    <label>Status</label>
                                    <select name='status' class="form-control" required>
                                        <option value="">Select status</option>
                                        <option
                                            {{ old('status', $package->status ?? 'Active') == 'Active' ? 'selected' : '' }}
                                            value="Active">Active</option>
                                        <option
                                            {{ old('status', $package->status ?? 'Active') == 'Inactive' ? 'selected' : '' }}
                                            value="Inactive">Inactive</option>
                                    </select>
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
    <!-- Select2 -->

    <style>
        .payment-price-digits {
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection


@section('pagejs')
 
<script>
    const edit_mode = '{{ $edit_mode }}'

    if (edit_mode) {
        menu_parent_active('package')
    } else {
        menu_make_active('package-create')
    }
</script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const durationInput = document.querySelector('input[name="duration"]');
            const calculateText = document.getElementById('calculateText');

            // Function to update the #calculateText based on input value
            function updateCalculateText() {
                const days = parseInt(durationInput.value, 10);

                if (!durationInput.value) {
                    calculateText.style.display = 'none';
                } else {
                    calculateText.style.display = 'block';

                    // Calculate years, months, and remaining days based on 360 days in a year
                    const years = Math.floor(days / 360);
                    const remainingDaysAfterYears = days % 360;
                    const months = Math.floor(remainingDaysAfterYears / 30);
                    const remainingDays = remainingDaysAfterYears % 30;

                    // Build the display text based on the values
                    let text = '';
                    if (years > 0) {
                        text += `${years} year${years > 1 ? 's' : ''}`;
                    }
                    if (months > 0) {
                        text += (text ? ' ' : '') + `${months} month${months > 1 ? 's' : ''}`;
                    }
                    if (remainingDays > 0) {
                        text += (text ? ' ' : '') + `${remainingDays} day${remainingDays > 1 ? 's' : ''}`;
                    }

                    calculateText.innerText = text;
                }
            }




            // Initial check on page load
            updateCalculateText();

            // Update on input change
            durationInput.addEventListener('input', updateCalculateText);
        });
    </script>
@endsection
