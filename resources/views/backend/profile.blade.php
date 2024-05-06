@extends('layouts.backend')

@section('title', 'Profile')

@section('content')

<x-notification></x-notification>
    
    <div class="table-container">

        <x-breadcrumb page_name="Profile"></x-breadcrumb>

        <form action="{{ route('admin.profile.update', $user) }}" method="POST" class="static-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-4 mb-3">
                    <label class="form-label">First Name<span class="asterisk">*</span></label>
                    <input class="form-control first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Last Name<span class="asterisk">*</span></label>
                    <input class="form-control last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Email<span class="asterisk">*</span></label>
                    <input class="form-control email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    <x-input_error field="email"></x-input_error>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Old Password</label>
                    <input class="form-control old_password" type="password" name="old_password">
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">New Password</label>
                    <input class="form-control new_password" type="password" name="new_password" onChange="onChange()">
                </div>  

                <div class="col-4 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control confirm_password" type="password" name="confirm_password" onChange="onChange()">
                </div>

                <div class="col-12 mb-5">
                    <label class="form-label">Profile Image</label>

                    @if($user->profile_image != null)
                        <img src="{{ asset('storage/profile_images/'. $user->profile_image) }}" alt="Profile Image" class="modal-image">
                        <input type="hidden" name="old_profile_image" value="{{ $user->profile_image }}">

                        <div class="mt-2">
                            <input type="file" class="form-control" id="new_profile_image" name="new_profile_image">
                            <x-input_error field="new_profile_image"></x-input_error>
                        </div>
                    @else
                        <input type="file" class="form-control" id="new_profile_image" name="new_profile_image">
                        <x-input_error field="new_profile_image"></x-input_error>
                    @endif
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn form-btn" onclick="updateForm()">Update</button>
                </div>
            </div>
        </form>
    </div>

@endsection


@push('after-scripts')
    <script>
        $('.old_password').on('change', function() {
            if($(this).val() != '') {
                $('.new_password').attr('required', true);
                $('.confirm_password').attr('required', true);
            }
            else {
                $('.new_password').removeAttr('required');
                $('.confirm_password').removeAttr('required');
            }
        });
    </script>

    <script>
        function onChange() {
            const password = document.querySelector('input[name=new_password]');
            const confirm = document.querySelector('input[name=confirm_password]');

            if(confirm.value != '' || password.value != '') {
                $('.old_password').attr('required', true);

                if(confirm.value === password.value) {
                    confirm.setCustomValidity('');
                }
                else {
                    confirm.setCustomValidity('Passwords do not match');
                }
            }
            else {
                $('.old_password').removeAttr('required');
                confirm.setCustomValidity('');
            }
        }
    </script>
@endpush