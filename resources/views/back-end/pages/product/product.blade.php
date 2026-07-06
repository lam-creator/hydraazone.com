@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Product List')
@section('content')

    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h5 class="p-2 mb-0 mr-auto box-title">Product</h5>
                        <button type="button" class="btn btn-primary btn-sm DataAddButton">Add Product</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100 nowrap" id="dt-scroll-horizonal" style="width:100%">

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- END: Page content-->

    <div class="modal fade" id="DataAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="DataAddUpdate" action="{{ route('admin.product.insert') }}" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="id" id="hidden-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Add/Update</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputStatus">Category <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="category_id" required>
                                                <option value="" selected>-- Select Category --</option>
                                                @foreach ($CategoryLists as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputStatus">Unit <span class="text-danger">*</span></label>
                                            <select class="form-control" name="unit_id" required>
                                                <option value="" selected>-- Select Unit --</option>
                                                @foreach ($UnitLists as $Unit)
                                                    <option value="{{ $Unit->id }}">{{ $Unit->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Product Name" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputImage">Image <span class="text-danger">* Image size need
                                                    to be 300x400</span></label>
                                            <input class="form-control" type="file" name="image">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="gallery_images">Product Gallery <span class="text-muted">(Multiple Images)</span></label>
                                            <input class="form-control" type="file" name="gallery_images[]" id="gallery_images" multiple accept="image/*">
                                            <small class="text-muted">You can select multiple images for the product gallery</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div id="gallery-preview" class="mb-4">
                                            <!-- Gallery preview will be shown here -->
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label>Product Variants</label>
                                            <div id="variant-rows" class="border rounded p-3 bg-light"></div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="add-variant-row">Add Variant</button>
                                            <small class="text-muted d-block mt-1">Example: Color=Red, Size=M, etc.</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Sale Price <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="sale_price"
                                                placeholder="Sale Price" required>
                                            @error('sale_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Discount Price <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="discount_price" value="0">
                                            @error('discount_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputStatus">Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="status" required>
                                                <option value="" selected>Select status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="show_as">Show As <span class="text-danger">*</span></label>
                                            <select class="form-control" name="show_as" required>
                                                <option value="" selected>Select status</option>
                                                <option value="general">General</option>
                                                <option value="featured">Featured</option>
                                                <option value="upcoming">Upcoming</option>
                                            </select>
                                            @error('show_as')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Short Description </label>
                                            <textarea class="short_description form-control" name="short_description" placeholder="Short Description"
                                                row="2"></textarea>
                                            @error('short_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Long Description </label>
                                            <textarea class="long_description" name="long_description" placeholder="Long Description"></textarea>
                                            @error('long_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Additional Information </label>
                                            <textarea class="additional_info" name="additional_info" placeholder="Additional Information"></textarea>
                                            @error('additional_info')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Meta Title</label>
                                            <input class="form-control" type="text" name="meta_title"
                                                placeholder="Product SEO Title">
                                            @error('meta_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Meta Keywords</label>
                                            <input class="form-control" type="text" name="meta_keywords"
                                                placeholder="Product SEO keywords - use , for multiple">
                                            @error('meta_keywords')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="exampleInputName">Meta Description</label>
                                            <textarea class="form-control" name="meta_description" placeholder="Product SEO Description"></textarea>
                                            @error('meta_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

<!-- Page specific script -->

@push('script')
    <script>
        // Delete gallery image function - GLOBAL SCOPE
        function deleteGalleryImage(imageId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/admin/product-gallery/' + imageId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Deleted!", response.message, "success");
                                // Remove the image element without reloading
                                $('#existing-image-' + imageId).fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire("Error!", "Failed to delete image", "error");
                        }
                    });
                }
            });
        }

        $(function() {


            // Summernote
            $('.short_description').summernote({
                height: 100, // set editor height
                minHeight: 100, // set minimum height of editor
                maxHeight: 400, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });

            // Summernote
            $('.long_description').summernote({
                height: 200, // set editor height
                minHeight: 100, // set minimum height of editor
                maxHeight: 400, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });

            // Summernote
            $('.additional_info').summernote({
                height: 200, // set editor height
                minHeight: 100, // set minimum height of editor
                maxHeight: 400, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });


            $(document).on('click', '.DataAddButton', function() {
                $('#hidden-id').attr("disabled", "true");
                $('.modal-title').text('Add Product');
                $("#DataAdd").modal('show');
            });

            $('#DataAddUpdate').ajaxForm({
                error: formError,
                success: function(responseText, statusText, xhr, $form) {
                    formSuccess(responseText, statusText, xhr, $form);
                    $('#dt-scroll-horizonal').DataTable().draw(true);
                    $("#DataAdd").modal('hide');
                    $('#hidden-id').prop("disabled", false);
                },
                clearForm: true,
                resetForm: true
            });

            $('#dt-scroll-horizonal').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('admin.product.data') }}", // URL will change
                    type: 'GET',
                    cache: false,
                    data: function(d) {}
                },
                columns: [ // All columns will change
                    {
                        title: 'SL',
                        data: 'id',
                        name: 'id'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Category',
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        title: 'Sale Price',
                        data: 'sale_price',
                        name: 'sale_price'
                    },
                    {
                        title: 'Discount Amount',
                        data: 'discount_price',
                        name: 'discount_price'
                    },
                    {
                        title: 'Image',
                        data: 'image',
                        name: 'image'
                    },
                    {
                        title: 'Action',
                        data: 'action',
                        name: 'action'
                    }
                ],
            });

            $(document).on('click', '.tableDelete', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let Id = $(this).data('id');
                        $(this).ajaxSubmit({
                            data: {
                                "delete": Id
                            },
                            method: 'POST',
                            dataType: 'json',
                            url: "{{ route('admin.product.insert') }}" // URL will change
                                ,
                            success: function(responseText) {
                                // formSuccess(responseText, statusText, xhr, $form);
                                Swal.fire("Congratulations!", responseText.message,
                                    "success");
                                $('#dt-scroll-horizonal').DataTable().draw(true);
                            }
                        });
                        // Swal.fire("Congratulations!", responseText.message, "success");
                    } else {
                        Swal.fire("Congratulations!", "Your data is safe!", "success");
                    }
                });

            });

            $('#DataAdd').on('hidden.bs.modal', function() {
                // Only reset if adding new product, not if editing
                if ($('#hidden-id').attr("disabled") === "disabled") {
                    $("#DataAddUpdate").trigger("reset");
                    $('#gallery-preview').empty();
                    $('#gallery_images').val('');
                }
            });


            // Gallery Image Preview Handler
            $(document).on('change', '#gallery_images', function() {
                const files = this.files;
                let galleryPreview = $('#gallery-preview');

                if (files.length > 0) {
                    // Check if we already have existing gallery section
                    if (galleryPreview.find('.existing-gallery').length === 0) {
                        // Create a section for new images
                        if (galleryPreview.find('.new-gallery').length === 0) {
                            galleryPreview.append('<div class="new-gallery"><div class="row"><h6 class="col-12"><strong>New Images to Add</strong></h6></div></div>');
                        }
                    } else {
                        // Insert new gallery section before existing
                        if (galleryPreview.find('.new-gallery').length === 0) {
                            galleryPreview.find('.existing-gallery').before('<div class="new-gallery"><div class="row"><h6 class="col-12"><strong>New Images to Add</strong></h6></div></div>');
                        }
                    }

                    let newGalleryRow = galleryPreview.find('.new-gallery .row');

                    $.each(files, function(index, file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const fileId = 'file_' + Date.now() + '_' + index;
                            const imageHtml = `
                                <div class="col-md-3 col-sm-4 col-6 mb-3" id="${fileId}">
                                    <div class="position-relative">
                                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;" alt="Gallery Image">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 2px; right: 2px;" onclick="$('#${fileId}').remove();" title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                            newGalleryRow.append(imageHtml);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // Load existing gallery images when editing
            function loadExistingGalleryImages(productId) {
                $.ajax({
                    url: '/admin/product-gallery/' + productId,
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success' && response.images.length > 0) {
                            let galleryHtml = '<div class="existing-gallery"><div class="row"><h6 class="col-12"><strong>Existing Gallery Images</strong></h6>';

                            $.each(response.images, function(index, image) {
                                const imageUrl = '/uploads/product-gallery/' + image.image;
                                galleryHtml += `
                                    <div class="col-md-3 col-sm-4 col-6 mb-3" id="existing-image-${image.id}">
                                        <div class="position-relative">
                                            <img src="${imageUrl}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;" alt="Gallery Image">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 2px; right: 2px;" onclick="deleteGalleryImage(${image.id});" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                            });

                            galleryHtml += '</div></div>';
                            $('#gallery-preview').html(galleryHtml);
                        }
                    }
                });
            }

            function renderVariantRows(variants = []) {
                let container = $('#variant-rows');
                container.empty();

                if (variants.length === 0) {
                    variants = [{ type: '', value: '', price_adjustment: '', stock: '', sku: '', status: 'active' }];
                }

                variants.forEach(function(variant, index) {
                    container.append(`
                        <div class="row variant-row mb-2" data-index="${index}">
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" name="variants[${index}][type]" value="${variant.type || ''}" placeholder="Type">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" name="variants[${index}][value]" value="${variant.value || ''}" placeholder="Value">
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" class="form-control form-control-sm" name="variants[${index}][price_adjustment]" value="${variant.price_adjustment || 0}" placeholder="Price Adj.">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control form-control-sm" name="variants[${index}][stock]" value="${variant.stock || 0}" placeholder="Stock">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" name="variants[${index}][sku]" value="${variant.sku || ''}" placeholder="SKU">
                            </div>
                            <div class="col-md-1">
                                <select class="form-control form-control-sm" name="variants[${index}][status]">
                                    <option value="active" ${variant.status === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="inactive" ${variant.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-1 text-right">
                                <button type="button" class="btn btn-danger btn-sm remove-variant-row">×</button>
                            </div>
                        </div>
                    `);
                });
            }

            $(document).on('click', '#add-variant-row', function() {
                let index = $('#variant-rows .variant-row').length;
                $('#variant-rows').append(`
                    <div class="row variant-row mb-2" data-index="${index}">
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm" name="variants[${index}][type]" placeholder="Type">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm" name="variants[${index}][value]" placeholder="Value">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" class="form-control form-control-sm" name="variants[${index}][price_adjustment]" value="0" placeholder="Price Adj.">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-sm" name="variants[${index}][stock]" value="0" placeholder="Stock">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm" name="variants[${index}][sku]" placeholder="SKU">
                        </div>
                        <div class="col-md-1">
                            <select class="form-control form-control-sm" name="variants[${index}][status]">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-1 text-right">
                            <button type="button" class="btn btn-danger btn-sm remove-variant-row">×</button>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.remove-variant-row', function() {
                $(this).closest('.variant-row').remove();
            });

            renderVariantRows();

            $(document).on('click', '.tableEdit', function() {
                let Id = $(this).data('id');
                $('.modal-title').text('Update Product');
                $('#hidden-id').removeAttr("disabled");
                $('#hidden-id').val(Id);
                $(this).ajaxSubmit({
                    data: {
                        "id": Id
                    },
                    dataType: 'json',
                    method: 'GET',
                    url: "{{ route('admin.product.edit') }}" // URL will change
                        ,
                    success: function(responseText) {
                        $('input[name^="name"]').val(responseText.data.name);
                        $('select[name^="category_id"]').val(responseText.data.category_id);
                        $('select[name^="unit_id"]').val(responseText.data.unit_id);
                        $('input[name^="sale_price"]').val(responseText.data.sale_price);
                        $('input[name^="discount_price"]').val(responseText.data
                            .discount_price);
                        $('input[name^="meta_title"]').val(responseText.data.meta_title);
                        $('input[name^="meta_keywords"]').val(responseText.data.meta_keywords);
                        $('textarea[name^="meta_description"]').val(responseText.data
                            .meta_description);
                        $(".short_description").summernote('code', responseText.data
                            .short_description);
                        $(".long_description").summernote('code', responseText.data
                            .long_description);
                        $(".additional_info").summernote('code', responseText.data
                            .additional_info);
                        $('select[name^="status"]').val(responseText.data.status);
                        $('select[name^="show_as"]').val(responseText.data.show_as);

                        if (responseText.data.variants && responseText.data.variants.length) {
                            renderVariantRows(responseText.data.variants);
                        } else {
                            renderVariantRows();
                        }

                        // Load existing gallery images
                        loadExistingGalleryImages(Id);

                        $("#DataAdd").modal('show');
                    }
                });
            });


        });
    </script>
@endpush
