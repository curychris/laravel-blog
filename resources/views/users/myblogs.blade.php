<x-app-layout>
    <div class="py-6 container sm:flex mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full sm:w-1/4">
            <div class="bg-white rounded shadow-sm sm:rounded-lg text-center p-2">
                <img
                    class="w-1/4 rounded-full mx-auto mt-3"
                    src="https://w7.pngwing.com/pngs/956/160/png-transparent-head-the-dummy-avatar-man-user.png" alt="">

                <h2 class="font-bold py-2">
                    {{ $user->name }}
                </h2>

                <hr class="my-2">

                <div class="font-bold">
                    My Blogs:
                </div>

                <div class="text-blue-700 text-2xl">
                    {{ $user->blogs()->count() }}
                </div>

                @if (auth()->id() === $user->id)
                <x-link href="{{ route('blogs.create') }}" class="m-3">
                    buat blog baru
                </x-link>
                @endif
            </div>
        </div>

        <div class="w-full sm:w-3/4 bg-white rounded overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 sm:mt-0 sm:ml-5">
            <h3 class="text-2xl uppercase text-center p-2 border-b-2">
                Blog yang dibuat
            </h3>

            <div class="inline-block lg:flex lg:align-center lg:flex-wrap">
                @foreach ($user->blogs as $blog)
                <div class="w-full lg:w-1/2 mt-6 px-6 py-4 shadow-md sm:rounded-lg hover:shadow-lg">
                    <img
                        class="max-w-full max-h-52 mx-auto"
                        src="{{ $blog->image ? asset($blog->image->path) : asset('blogs/dummy.png')}}" alt="">

                    <hr class="my-2">

                    <h3>{{ $blog->title }}</h3>

                    <hr class="my-2">

                    <p>
                        {!! Str::limit($blog->body, 100) !!}
                    </p>

                    <hr class="my-2">

                    <div class="flex justify-end items-center space-x-2 mt-4">
                        <x-link href="{{ route('blogs.show', $blog->id) }}">
                            View
                        </x-link>

                        @if ($blog->creator_id === auth()->id())
                            <x-link href="{{ route('blogs.edit', $blog->id) }}">
                                Edit
                            </x-link>

                            <form id="deleteBlogForm" action="{{ route('blogs.delete', $blog->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button onclick="showDeleteConfirmation(event)">
                                    Delete
                                </x-button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <p class="my-2">
                {{ $user->blogs->links() }}
            </p>
        </div>
    </div>

    <!-- Konfirmasi Hapus Blog Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-semibold mb-4">Are you sure you want to delete this blog?</h3>
            <div class="flex justify-between space-x-4">
                <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded-lg w-full">Cancel</button>
                <button id="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded-lg w-full">Delete</button>
            </div>
        </div>
    </div>

    <script>
        function showDeleteConfirmation(event) {
            event.preventDefault(); // Mencegah form submit langsung
            const modal = document.getElementById('deleteModal');
            const confirmButton = document.getElementById('confirmDelete');
            const cancelButton = document.getElementById('cancelDelete');

            // Tampilkan modal
            modal.classList.remove('hidden');

            // Aksi jika tombol konfirmasi di-klik
            confirmButton.onclick = function() {
                event.target.closest('form').submit(); // Mengirimkan form setelah dikonfirmasi
            };

            // Aksi jika tombol cancel di-klik
            cancelButton.onclick = function() {
                modal.classList.add('hidden'); // Sembunyikan modal jika cancel
            };
        }
    </script>
</x-app-layout>
