<x-app-layout>
    <div class="py-6 container sm:flex mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full bg-white overflow-hidden">
            <h3 class="font-bold text-2xl text-center my-2">Edit Blog Anda</h3>

            <hr class="my-2">

            <form action="{{ route('blogs.update', $blog->id) }}" class="p-4" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <img class="w-1/2 rounded" src="{{ $blog->image ? asset($blog->image->path) :'' }}" alt="">

                <label class="block">
                    <span class="sr-only">Select Image</span>
                    <input type="file" name="image" multiple class="block w-full text-sm text-slate-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-violet-50 file:text-violet-700
                      hover:file:bg-violet-100
                    "/>
                </label>

                <div class="mb-4 w-full mt-2">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                        Judul
                    </label>
                    <input type="text" class="@error('title') border-red-500 @enderror shadow appearence-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                     id="title" name="title" value="{{ old('title') ?: $blog->title }}" placeholder="Judul Blog"/>
                    @error('title')
                        <p class="text-red-500 text-xs italic">
                            {{ $message}}
                        </p>
                    @enderror
                </div>

                <div class="mb-4 w-full">
                    <label for="body" class="block text-gray-700 text-sm font-bold mb-2">
                        Deskripsi
                    </label>
                    <textarea class="@error('body') border-red-500 @enderror shadow appearence-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="body" id="body" placeholder="Blog Body" >{{ old('body') ?: $blog->body }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-xs italic">
                            {{ $message}}
                        </p>
                    @enderror
                </div>

                <x-button>
                    Submit
                </x-button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'body' );
        </script>
    @endpush
</x-app-layout>
