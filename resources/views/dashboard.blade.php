<x-app-layout>
    <div class="py-6 flex">
        <div class="w-full lg:w-3/4 p-4">

            <!-- Menampilkan Alert Sukses -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <form action="{{ route('dashboard') }}" class="p-6 bg-white text-xl pb-5 block lg:flex align-center justify-between">
                    <input
                        type="text"
                        name="keyword"
                        class="w-full lg:w-5/6 rounded-xl"
                        value="{{ Request::get('keyword') }}"
                        placeholder="Cari sesuatu di sini.." />
                    <x-button class="w-full mt-2 justify-center md:w-1/3 md:ml-auto lg:mt-0 lg:w-auto">
                        &nbsp &nbsp Cari &nbsp &nbsp
                    </x-button>
                </form>

                <hr>
            </div>

            @if(!count($blogs))
                <div class="text-red-600 text-2xl text-center font-bold">
                    Belum ada blog.
                </div>
            @endif

            @foreach ($blogs as $blog)
            <div class="bg-white my-7 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg ease-in-out duration-300 cursor-pointer lg:flex lg:align-center">
                <img
                    class="w-full max-h-52 lg:w-1/4 object-contain bg-gray-200"
                    src="{{ $blog->image && file_exists(public_path($blog->image->path)) ? asset($blog->image->path) : asset('blogs/dummy.png')}}" alt="" />

                <div class="w-full lg:w-3/4 p-4">
                    <h3 class="text-2xl font-bold">
                        {{ $blog->title }}
                    </h3>

                    <p class="p-3 text-gray-500">
                        Dibuat oleh:
                        <a class="hover:text-blue-500" href="{{ route('profile', $blog->creator_id) }}">{{ $blog->creator->name }}</a>
                    </p>

                    <p>
                        {!! Str::limit($blog->body, 170) !!}
                    </p>

                    <x-link href="{{ route('blogs.show', $blog->id) }}" class="mt-3">
                        Selengkapnya
                    </x-link>
                </div>
            </div>
            @endforeach

            {{ $blogs->links() }}
        </div>

        <div class="hidden lg:block lg:w-1/4 p-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="font-bold">
                    Blog Saya
                </div>

                <div class="text-blue-700 text-2xl">
                    {{ auth()->user()->blogs()->count() }}
                </div>

                <hr class="my-3">

                <x-link href="{{ route('blogs.create') }}">
                    Buat Blog Baru
                </x-link>
            </div>
        </div>
    </div>
</x-app-layout>
