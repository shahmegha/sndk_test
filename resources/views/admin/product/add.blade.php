<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(ucFirst($mode).' Products') }}
        </h2> 
    </x-slot>
     
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        @if ($message = Session::get('success'))
                            <div class="text-sm text-green-600">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="text-sm text-red-600">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="product_form" method="post" action="{{ route('admin.product.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            <x-text-input id="mode" name="mode" :value="$mode" type="hidden" />
                            <x-text-input id="product_image_delete" name="product_image_delete"  type="hidden" />
                            <x-text-input id="mode" name="id" :value="!empty($product)?$product->id:''" type="hidden" />
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select class="mt-1 block w-full" id="category_id" name="category_id" required>
                                    <option value="">Select category</option>
                                    @if (!empty($categories))
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}"  @if ($category->id == old('category_id', !empty($product)?$product->category_id:''))selected="selected" @endif>{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>
                            <div id='sub_category_div' class="hide">
                                <x-input-label for="sub_category_id" :value="__('Sub Category')" />
                                <select class="mt-1 block w-full" id="sub_category_id" name="sub_category_id" >
                                    <option value="">Select sub category</option>
                                    @if (!empty($sub_categories))
                                        @foreach ($sub_categories as $category)
                                            <option value="{{$category->id}}" data-option-category='{{$category->parent_category_id}}'   @if ($category->id == old('sub_category_id', !empty($product)?$product->sub_category_id:''))selected="selected" @endif>{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('sub_category_id')" />
                            </div>
                            <div>
                                <x-input-label for="product_name" :value="__('Name')" />
                                <x-text-input id="product_name" name="product_name" :value="old('product_name',!empty($product)?$product->name:'')" type="text" class="mt-1 block w-full"  required autofocus autocomplete="product_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('product_name')" />
                            </div>
                            <div>
                                <x-input-label for="regular_price" :value="__('Regular Price')" />
                                <x-text-input id="regular_price" name="regular_price" :value="old('regular_price',!empty($product)?$product->regular_price:'')" type="number" class="mt-1 block w-full"  required autofocus autocomplete="regular_price"  step=".01" min='0'/>
                                <x-input-error class="mt-2" :messages="$errors->get('regular_price')" />
                            </div>
                            <div>
                                @if(!empty($product) && !empty($product->product_thumbnail))
                                    <div class="mb-5">
                                     <x-input-label for="product_images" :value="__('Product Thumbnail')" />
                                    <img src="{{ asset('uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$product->product_thumbnail)}}" alt="alt" />
                                   
                                    </div>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="product_images" :value="__('Product Images')" />
                                <x-text-input id="product_images" name="product_images[]"  type="file" class="mt-1 block w-full"  accept="image/png, image/jpeg, image/jpg" multiple/>
                                <x-input-error class="mt-2" :messages="$errors->get('product_images')" />
                            </div>
                            
                            <div>
                                @if(!empty($product) && !empty($product->productImages))
                                    @foreach ($product->productImages as $key => $image)
                                    @if(!$image->is_thumbnail )
                                    <div class="mb-5 product_image_single product_image_single_{{$image->id}}">
                                    <img src="{{ asset('uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'original'.DIRECTORY_SEPARATOR.$image->name)}}" alt="alt" />
                                    
                                    <x-secondary-button class="image_single_delete" data-product-image-id="{{$image->id}}" >{{ __('Delete') }}</x-secondary-button>
                                    </div>
                                    @endif
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <x-input-label for="attribute_fields_button" :value="__('Product Attributes')" />
                                <x-secondary-button id="attribute_fields_button" >{{ __('Add More') }}</x-secondary-button>
                            </div>
                            <div id="attribute_fields_group">
                                @if(!empty($product) && !empty($product->productAttributes))
                                    @foreach ($product->productAttributes as $key => $attr)
                                    <div class="mb-5 attribute_single attribute_single_{{$key+1}}">
                                        <x-text-input name="product_attribute[{{$key}}][id]"  type="hidden" class="mt-1 block w-full attribute_single_id" max="255" value="{{$attr->id}}"/>
                                        <div class="w-20 ">
                                            <x-input-label  :value="__('Size')" />
                                            <x-text-input name="product_attribute[{{$key}}][size]"  type="text" class="mt-1 block w-full attribute_single_size" max="255" required value="{{$attr->size}}"/>
                                        </div>
                                        <div class="w-20 ">
                                            <x-input-label :value="__('Price')" />
                                            <x-text-input name="product_attribute[{{$key}}][price]"  type="number" class="mt-1 block w-full attribute_single_price"  step="0.01" min="0" required value="{{$attr->price}}"/>
                                        </div>
                                        <div class="w-20 ">
                                            <x-secondary-button class="attribute_single_delete" data-product-attr-no="{{$key+1}}" >{{ __('Delete') }}</x-secondary-button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                <div class="mb-5 attribute_single attribute_single_1">
                                    <x-text-input name="product_attribute[0][id]"  type="hidden" class="mt-1 block w-full" max="255" />
                                    <div class="w-20">
                                        <x-input-label  :value="__('Size')" />
                                        <x-text-input name="product_attribute[0][size]"  type="text" class="mt-1 block w-full" max="255" required/>
                                    </div>
                                    <div class="w-20">
                                        <x-input-label :value="__('Price')" />
                                        <x-text-input name="product_attribute[0][price]"  type="number" class="mt-1 block w-full"  step="0.01" min="0" required/>
                                    </div>
                                    <div class="w-20">
                                        <x-secondary-button class="attribute_single_delete" data-product-attr-no="1" >{{ __('Delete') }}</x-secondary-button>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('js/additional-methods.min.js')}}"></script>
    <script src="{{ asset('js/admin/product_add_edit.js')}}"></script>
</x-admin-layout>
