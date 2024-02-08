<x-admin-layout>
    <x-slot name="header">
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <x-nav-link  :href="route('admin.product.add')" :active="request()->routeIs('admin.category.add')">
                {{ __('Add Product') }}
            </x-nav-link>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <section>
                        @if ($message = Session::get('success'))
                            <div class="text-sm text-green-600">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-bordered" width='100%'>
                            <tr>
                                <th style='text-align:left;' width='40%'>Name</th>
                                <th style='text-align:left;' width='20%'>Price</th>
                                <th style='text-align:left;' width='20%'>Thumbnail</th>
                                <th style='text-align:left;' width="20%">Action</th>
                            </tr>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->regular_price }}</td>
                                <td>
                                    @if(!empty($product->product_thumbnail))
                                    <img src="{{ asset('uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$product->product_thumbnail)}}" alt="alt" /></td>
                                    @endif
                                <td>
                                    <form action="{{ route('admin.product.destroy',$product->id) }}" method="POST">

                                        <a class="btn btn-primary" href="{{ route('admin.product.edit',$product->id) }}">Edit</a>

                                        @csrf

                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {!! $products->links() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>


    
</x-admin-layout>