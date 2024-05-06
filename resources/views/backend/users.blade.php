@extends('layouts.backend')

@section('title', 'Users')

@section('content')

<x-notification></x-notification>

    <div class="table-container">
        <x-breadcrumb page_name="Users" button_title="User" create=true></x-breadcrumb>

        <form action="{{ route('admin.users.filter') }}" method="POST" class="filter-form">
            @csrf
            <div class="row align-items-center">
                <div class="col-3 position-relative">
                    <input type="text" class="form-control name" name="name" value="{{ $name }}" placeholder="Name">
                </div>

                <div class="col-3 position-relative">
                    <input type="text" class="form-control email" name="email" value="{{ $email }}" placeholder="Email">
                </div>

                <div class="col-3 position-relative">
                    <select class="filter-single-dropdown role" name="role">
                        <option value="all" {{ $role == 'all' ? "selected" : "" }}>Select Role</option>
                        <option value="admin" {{ $role == 'admin' ? "selected" : "" }}>Admin</option>
                        <option value="customer" {{ $role == 'customer' ? "selected" : "" }}>Customer</option>
                    </select>
                </div>

                <div class="col-3 d-flex justify-content-between">
                    <input type="submit" class="btn filter-search-button" value="SEARCH">
                    <input type="submit" class="btn filter-reset-button" name="reset" value="RESET">
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-pagination_form items="{{ $items }}"></x-pagination_form>

                        <table class="table table-striped" id="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Profile Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{!! $user->profile_image !!}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{!! $user->role !!}</td>
                                            <td>{!! $user->status !!}</td>
                                            <td>{!! $user->action !!}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" style="text-align: center;">No data available in table</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{ $users->appends(compact('items'))->links("pagination::bootstrap-5") }}
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Create -->
        <div class="modal fade create-modal" id="create-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">Add User</h1>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">First Name<span class="asterisk">*</span></label>
                                    <input class="form-control first_name" type="text" name="first_name" value="{{ old('first_name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Last Name<span class="asterisk">*</span></label>
                                    <input class="form-control last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Email<span class="asterisk">*</span></label>
                                    <input class="form-control email" type="email" name="email" value="{{ old('email') }}" required>
                                    <x-input_error field="email"></x-input_error>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input class="form-control profile_image" type="file" name="profile_image">
                                    <x-input_error field="profile_image"></x-input_error>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Role<span class="asterisk">*</span></label>
                                    <select class="form-control form-select role" name="role" value="{{ old('role') }}" required>
                                        <option value="" {{ old('role') == '' ? 'selected' : '' }}>Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Password<span class="asterisk">*</span></label>
                                    <input class="form-control password" type="password" name="password" required>
                                    <x-input_error field="password"></x-input_error>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Confirm Password<span class="asterisk">*</span></label>
                                    <input class="form-control password_confirmation" type="password" name="password_confirmation" required>
                                    <x-input_error field="password_confirmation"></x-input_error>
                                </div>

                                <x-create_data></x-create_data>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- View -->
        <div class="modal fade view-modal" id="view-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">View User</h1>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input class="form-control first_name" type="text" name="first_name" readonly>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input class="form-control last_name" type="text" name="last_name" readonly>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control email" type="email" name="email" readonly>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-control form-select role" name="role" readonly>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <img alt="Profile Image" class="modal-image old_profile_image_div">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit -->
        <div class="modal fade edit-modal" id="edit-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">Edit User</h1>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">First Name<span class="asterisk">*</span></label>
                                    <input class="form-control first_name" type="text" name="first_name" value="{{ old('first_name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Last Name<span class="asterisk">*</span></label>
                                    <input class="form-control last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Email<span class="asterisk">*</span></label>
                                    <input class="form-control email" type="email" name="email" value="{{ old('email') }}" required>
                                    <x-input_error field="email"></x-input_error>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Role<span class="asterisk">*</span></label>
                                    <select class="form-control form-select role" name="role" value="{{ old('role') }}" required>
                                        <option value="" {{ old('role') == '' ? 'selected' : '' }}>Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <img alt="Profile Image" class="modal-image old_profile_image_div">
                                    <input type="hidden" class="form-control old_profile_image" name="old_profile_image">

                                    <div class="mt-2">
                                        <label class="form-label">Profile Image</label>
                                        <input type="file" class="form-control new_profile_image" name="new_profile_image">
                                        <x-input_error field="new_profile_image"></x-input_error>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control password" type="password" name="password">
                                    <x-input_error field="password"></x-input_error>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control password_confirmation" type="password" name="password_confirmation">
                                    <x-input_error field="password_confirmation"></x-input_error>
                                </div>

                                <x-edit_data></x-edit_data>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete -->
        <div class="modal fade delete-modal" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete User</h5>
                    </div>
                    <div class="modal-body">
                        <p class="modal-message">Are you sure you want to delete?</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn form-btn close-btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn form-btn" title="Delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.table-container .view').on('click', function() {
                let value = $(this).attr('id');
                let view_url = '{{ route("admin.users.show", ":value") }}';
                view_url = view_url.replace(':value', value);

                $('.view-modal form')[0].reset();

                $.ajax({
                    url: view_url,
                    method: 'GET',
                    success: function(data) {
                        $('.view-modal .first_name').val(data['first_name']);
                        $('.view-modal .last_name').val(data['last_name']);
                        $('.view-modal .email').val(data['email']);
                        $('.view-modal .phone').val(data['phone']);

                        if(data['profile_image'] != null) {
                            $('.view-modal .old_profile_image_div').attr('src', "{{ asset('/storage/profile_images') }}/" + data['profile_image']);
                        }
                        else {
                            $('.view-modal .old_profile_image_div').attr('src', "{{ asset('/storage/no_image.jpg') }}");
                        }
                        
                        $('.view-modal .role').val(data['role']);
                        $('.view-modal .status').val(data['status']);
                        $('.view-modal').modal('show');
                    },
                    error: function() {
                        alert('Error getting data!');
                    }
                });
            });

            $('.table-container .edit').on('click', function() {
                let value = $(this).attr('id');
                let edit_url = '{{ route("admin.users.edit", ":value") }}';
                let update_url = '{{ route("admin.users.update", ":value") }}';
                edit_url = edit_url.replace(':value', value);
                update_url = update_url.replace(':value', value);

                $('.edit-modal form')[0].reset();

                $.ajax({
                    url: edit_url,
                    method: 'GET',
                    success: function(data) {
                        $('.edit-modal .first_name').val(data['first_name']);
                        $('.edit-modal .last_name').val(data['last_name']);
                        $('.edit-modal .email').val(data['email']);
                        $('.edit-modal .phone').val(data['phone']);

                        if(data['profile_image'] != null) {
                            $('.edit-modal .old_profile_image').val(data['profile_image']);
                            $('.edit-modal .old_profile_image_div').attr('src', "{{ asset('/storage/profile_images') }}/" + data['profile_image']);
                        }
                        else {
                            $('.edit-modal .old_profile_image').val();
                            $('.edit-modal .old_profile_image_div').attr('src', "{{ asset('/storage/no_image.jpg') }}");
                        }
                        
                        $('.edit-modal .role').val(data['role']);
                        $('.edit-modal .status').val(data['status']);

                        $('.edit-modal').modal('show');
                        $('.edit-modal form').attr('action', update_url);
                    },
                    error: function() {
                        alert('Error getting data!');
                    }
                });
            });

            $('.table-container .delete').on('click', function() {
                let id = $(this).attr('id');
                let url = "{{ route('admin.users.destroy', [':id']) }}";
                delete_url = url.replace(':id', id);

                $('.delete-modal form').attr('action', delete_url);
                $('.delete-modal').modal('show');
            });
            
            $(".table-container .pagination-form select").change(function () {
                window.location = "{!! $users->url(1) !!}&items=" + this.value; 
            });
        });
    </script>
@endpush