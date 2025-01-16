<x-app-layout>
    <div class="py-6 flex justify-center align-center">
        <div class="w-full md:w-3/4 mx-2 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
            <img class="w-full max-h-screen object-contain bg-gray-200"
                src="{{ $blog->image ? asset($blog->image->path) : asset('blogs/dummy.png') }}" alt="" />

            <div>
                <h2 class="font-sans text-5xl font-bold p-5">{{ $blog->title }}</h2>
                <small class="p-5 text-gray-500 font-bold">Diposting pada: {{ $blog->created_at }}</small>

                <hr>

                <div class="w-full text-left my-2 px-5 max-w-full prose">
                    {!! $blog->body !!}
                </div>

                <hr>

                <p class="p-3 text-gray-500">
                    Dibuat oleh:
                    <a class="hover:text-blue-500" href="{{ route('profile', $blog->creator_id) }}">{{ $blog->creator->name }}</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Form komentar w-full md:w-3/4 mx-2 bg-white p-4-->
    <div class="w-full md:w-3/4 mx-auto">
        <form action="{{ route('comments.store', $blog->id) }}" method="POST">
            @csrf
            <textarea name="content" rows="4" class="w-full border-2 border-gray-300 rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tuliskan pendapat anda di sini..."></textarea>
            @error('content')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg mt-1 bb-7 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Posting</button>
        </form>
    </div>
    
    <!-- Menampilkan komentar yang sudah ada -->
    <div class="w-full md:w-3/4 mx-auto">
        <h3 class="font-bold text-lg mb-4 mt-7">Komentar:</h3>

        @foreach($blog->comments as $comment)
            <div class="border-b p-4 my-3 bg-gray-50 rounded-lg shadow-md transition-all duration-300">
                <div class="flex items-center mb-2">
                    <p class="font-semibold">{{ $comment->user->name }}</p>
                </div>
                <p>{{ $comment->content }}</p>
                <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
</x-app-layout>
