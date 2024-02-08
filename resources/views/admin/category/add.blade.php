<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(ucFirst($mode).' Categories') }}
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
                        <form method="post" action="{{ route('admin.category.update') }}" class="mt-6 space-y-6">
                            @csrf
                            <x-text-input id="mode" name="mode" :value="$mode" type="hidden" />
                            <x-text-input id="mode" name="id" :value="!empty($category)?$category->id:''" type="hidden" />
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="category_name" name="category_name" :value="old('category_name',!empty($category)?$category->name:'')" type="text" class="mt-1 block w-full"  required autofocus autocomplete="name" max='255' />
                                <x-input-error class="mt-2" :messages="$errors->get('category_name')" />
                            </div>
                            <div>
                                <x-input-label for="" :value="__('Parent Category')" />
                                <select class="mt-1 block w-full" id="parent_category_id" name="parent_category_id">
                                    <option value="">Select Parent category</option>
                                    @if (!empty($categories))
                                        @foreach ($categories as $parent_category)
                                            <option value="{{$parent_category->id}}"  @if ($parent_category->id == old('parent_category_id', !empty($category)?$category->parent_category_id:''))selected="selected" @endif>{{ $parent_category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('parent_category_id')" />
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
</x-admin-layout>
