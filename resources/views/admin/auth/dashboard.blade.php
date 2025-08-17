<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Awais Ahmad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background-color: rgba(59, 130, 246, 0.1); border-right: 3px solid #3b82f6; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
                <p class="text-sm text-gray-600">Awais Ahmad Portfolio</p>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active text-blue-700' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('admin.projects.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.projects.*') ? 'sidebar-active text-blue-700' : '' }}">
                    <i class="fas fa-project-diagram w-5"></i>
                    <span class="ml-3">Projects</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.contacts.*') ? 'sidebar-active text-blue-700' : '' }}">
                    <i class="fas fa-envelope w-5"></i>
                    <span class="ml-3">Contacts</span>
                    @if($unreadCount = App\Models\Contact::unread()->count())
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.settings.*') ? 'sidebar-active text-blue-700' : '' }}">
                    <i class="fas fa-cog w-5"></i>
                    <span class="ml-3">Settings</span>
                </a>
                <a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700" target="_blank">
                    <i class="fas fa-external-link-alt w-5"></i>
                    <span class="ml-3">View Site</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b px-6 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Welcome back, Admin</span>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 overflow-y-auto" style="height: calc(100vh - 80px);">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>