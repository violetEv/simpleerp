@section('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Delete User
    </h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Delete User Form -->
                    <form action="{{ route('superadmin.users.delete', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <p class="mb-4">Are you sure you want to delete this user?</p>

                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete
                            User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
