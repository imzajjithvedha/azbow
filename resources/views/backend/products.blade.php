@extends('layouts.backend')

@section('title', 'Products')

@section('content')

<x-notification></x-notification>

    <div class="table-container">
        <x-breadcrumb page_name="Products" button_title="Product" create=true></x-breadcrumb>

        <form action="{{ route('admin.products.filter') }}" method="POST" class="filter-form">
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">In Stock</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($products) > 0)
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->product_id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->in_stock }}</td>
                                            <td>{!! $product->status !!}</td>
                                            <td>{!! $product->action !!}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No data available in table</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{ $products->appends(compact('items'))->links("pagination::bootstrap-5") }}
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Create -->
        <div class="modal fade create-modal" id="create-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">Add Product</h1>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Name<span class="asterisk">*</span></label>
                                    <input class="form-control name" type="text" name="name" value="{{ old('name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Category<span class="asterisk">*</span></label>
                                    <select class="form-control form-select category" name="category" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Description<span class="asterisk">*</span></label>
                                    <textarea class="form-control textarea description" name="description" value="{{ old('description') }}" rows="5" required>{{ old('description') }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Directions<span class="asterisk">*</span></label>
                                    <textarea class="editor" name="directions"></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Image<span class="asterisk">*</span></label>
                                    <input class="form-control image" type="file" name="image" required>
                                    <x-input_error field="image"></x-input_error>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Price<span class="asterisk">*</span></label>
                                    <input class="form-control price" type="text" name="price" value="{{ old('price') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">In Stock<span class="asterisk">*</span></label>
                                    <input class="form-control in_stock" type="number" step="1" name="in_stock" value="{{ old('in_stock') }}" required>
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
                        <h1 class="modal-title">View Product</h1>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control name" type="text" readonly>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-control form-select category" readonly>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control textarea description" name="description" rows="5" readonly></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Directions</label>
                                    <textarea class="editor" name="directions"></textarea>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <input class="form-control price" type="text" readonly>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">In Stock</label>
                                    <input class="form-control in_stock" type="number" step="1" readonly>
                                </div>

                                <div class="col-12 mb-3">
                                    <img alt="Image" class="modal-image old_image_div">
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
                        <h1 class="modal-title">Edit Product</h1>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Name<span class="asterisk">*</span></label>
                                    <input class="form-control name" type="text" name="name" value="{{ old('name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Category<span class="asterisk">*</span></label>
                                    <select class="form-control form-select category" name="category" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Description<span class="asterisk">*</span></label>
                                    <textarea class="form-control textarea description" name="description" value="{{ old('description') }}" rows="5" required>{{ old('description') }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Directions<span class="asterisk">*</span></label>
                                    <textarea class="editor" name="directions"></textarea>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Price<span class="asterisk">*</span></label>
                                    <input class="form-control price" type="text" name="price" value="{{ old('price') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">In Stock<span class="asterisk">*</span></label>
                                    <input class="form-control in_stock" type="number" step="1" name="in_stock" value="{{ old('in_stock') }}" required>
                                </div>

                                <div class="col-12 mb-3">
                                    <img alt="Image" class="modal-image old_image_div">
                                    <input type="hidden" class="form-control old_image" name="old_image">

                                    <div class="mt-2">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control new_image" name="new_image">
                                        <x-input_error field="new_image"></x-input_error>
                                    </div>
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
                        <h5 class="modal-title">Delete Product</h5>
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
                let view_url = '{{ route("admin.products.show", ":value") }}';
                view_url = view_url.replace(':value', value);

                $('.view-modal form')[0].reset();

                $.ajax({
                    url: view_url,
                    method: 'GET',
                    success: function(data) {
                        $('.view-modal .name').val(data['name']);
                        $('.view-modal .category').val(data['category']);
                        $('.view-modal .description').val(data['description']);
                        editors[1].setData(data['directions']);
                        $('.view-modal .price').val(data['price']);
                        $('.view-modal .in_stock').val(data['in_stock']);
                        $('.view-modal .status').val(data['status']);

                        if(data['image'] != null) {
                            $('.view-modal .old_image_div').attr('src', "{{ asset('/storage/product_images') }}/" + data['image']);
                        }
                        else {
                            $('.view-modal .old_image_div').attr('src', "{{ asset('/storage/no_image.jpg') }}");
                        }

                        $('.view-modal').modal('show');
                    },
                    error: function() {
                        alert('Error getting data!');
                    }
                });
            });

            $('.table-container .edit').on('click', function() {
                let value = $(this).attr('id');
                let edit_url = '{{ route("admin.products.edit", ":value") }}';
                let update_url = '{{ route("admin.products.update", ":value") }}';
                edit_url = edit_url.replace(':value', value);
                update_url = update_url.replace(':value', value);

                $('.edit-modal form')[0].reset();

                $.ajax({
                    url: edit_url,
                    method: 'GET',
                    success: function(data) {
                        $('.edit-modal .name').val(data['name']);
                        $('.edit-modal .category').val(data['category']);
                        $('.edit-modal .description').val(data['description']);
                        editors[2].setData(data['directions']);
                        $('.edit-modal .price').val(data['price']);
                        $('.edit-modal .in_stock').val(data['in_stock']);
                        $('.edit-modal .status').val(data['status']);

                        if(data['image'] != null) {
                            $('.edit-modal .old_image').val(data['image']);
                            $('.edit-modal .old_image_div').attr('src', "{{ asset('/storage/product_images') }}/" + data['image']);
                        }
                        else {
                            $('.edit-modal .old_image').val();
                            $('.edit-modal .old_image_div').attr('src', "{{ asset('/storage/no_image.jpg') }}");
                        }

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
                let url = "{{ route('admin.products.destroy', [':id']) }}";
                delete_url = url.replace(':id', id);

                $('.delete-modal form').attr('action', delete_url);
                $('.delete-modal').modal('show');
            });
            
            $(".table-container .pagination-form select").change(function () {
                window.location = "{!! $products->url(1) !!}&items=" + this.value; 
            });
        });
    </script>
@endpush