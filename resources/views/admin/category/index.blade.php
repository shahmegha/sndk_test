<x-admin-layout>
    <x-slot name="header">
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            <x-nav-link  :href="route('admin.category.add')" :active="request()->routeIs('admin.category.add')">
                {{ __('Add Category') }}
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
                                <th style='text-align:left;' width='40%'>Category</th>
                                <th style='text-align:left;' width='40%'>Sub Category</th>
                                <th style='text-align:left;' width="20%">Action</th>
                            </tr>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->getSubCategoryName() }}</td>
                                <td>
                                    <form action="{{ route('admin.category.destroy',$category->id) }}" method="POST">

                                        <a class="btn btn-primary" href="{{ route('admin.category.edit',$category->id) }}">Edit</a>

                                        @csrf

                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {!! $categories->links() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>


    
</x-admin-layout>