<div class="h-16 bg-white shadow-md z-40 flex items-center justify-between px-6">

    {{-- LEFT: PAGE TITLE --}}
    <h1 class="text-lg font-semibold text-gray-700">
        Dashboard
    </h1>

    {{-- RIGHT: ACCOUNT --}}
    <div class="flex items-center gap-4">

        {{-- Profile --}}
        <a href="{{ route('profile.show') }}"
           class="flex items-center gap-2 text-gray-700 hover:text-indigo-600 font-medium">
             <i class="bi bi-person-circle text-xl"></i>
             {{ Auth::user()->name }}
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-[#F63E6F] hover:bg-red-700 text-white rounded-lg font-semibold">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>

    </div>
</div>