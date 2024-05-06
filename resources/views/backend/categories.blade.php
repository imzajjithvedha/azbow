@extends('layouts.backend')

@section('title', 'Categories')

@section('content')

<x-notification></x-notification>

    <div class="table-container">
        <x-breadcrumb page_name="Categories" button_title="Category" create=true></x-breadcrumb>

        <form action="{{ route('admin.categories.filter') }}" method="POST" class="filter-form">
            @csrf
            <div class="row align-items-center">
                <div class="col-9 position-relative">
                    <input type="text" class="form-control name" name="name" value="{{ $name }}" placeholder="Name">
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($categories) > 0)
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{!! $category->status !!}</td>
                                            <td>{!! $category->action !!}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" style="text-align: center;">No data available in table</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{ $categories->appends(compact('items'))->links("pagination::bootstrap-5") }}
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Create -->
        <div class="modal fade create-modal" id="create-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">Add Category</h1>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Name<span class="asterisk">*</span></label>
                                    <input class="form-control name" type="text" name="name" value="{{ old('name') }}" required>
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
                        <h1 class="modal-title">View Category</h1>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control name" type="text" name="name" readonly>
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
                        <h1 class="modal-title">Edit Category</h1>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Name<span class="asterisk">*</span></label>
                                    <input class="form-control name" type="text" name="name" value="{{ old('name') }}" required>
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
                        <h5 class="modal-title">Delete Category</h5>
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
                let view_url = '{{ route("admin.categories.show", ":value") }}';
                view_url = view_url.replace(':value', value);

                $('.view-modal form')[0].reset();

                $.ajax({
                    url: view_url,
                    method: 'GET',
                    success: function(data) {
                        $('.view-modal .name').val(data['name']);
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
                let edit_url = '{{ route("admin.categories.edit", ":value") }}';
                let update_url = '{{ route("admin.categories.update", ":value") }}';
                edit_url = edit_url.replace(':value', value);
                update_url = update_url.replace(':value', value);

                $('.edit-modal form')[0].reset();

                $.ajax({
                    url: edit_url,
                    method: 'GET',
                    success: function(data) {
                        $('.edit-modal .name').val(data['name']);
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
                let url = "{{ route('admin.categories.destroy', [':id']) }}";
                delete_url = url.replace(':id', id);

                $('.delete-modal form').attr('action', delete_url);
                $('.delete-modal').modal('show');
            });
            
            $(".table-container .pagination-form select").change(function () {
                window.location = "{!! $categories->url(1) !!}&items=" + this.value; 
            });
        });
    </script>
@endpush