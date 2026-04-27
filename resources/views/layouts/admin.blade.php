<!DOCTYPE html>
<html lang="en" class="h-full bg-[#08111f] text-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Awais Ahmad</title>
    <meta name="description" content="@yield('description', 'Administration area for portfolio content management.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            color-scheme: dark;
        }

        body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(103, 232, 249, 0.12), transparent 24rem),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.14), transparent 28rem),
                linear-gradient(180deg, #08111f 0%, #0d172a 52%, #09101d 100%);
        }

        .admin-display {
            font-family: 'Space Grotesk', sans-serif;
        }

        .admin-shell::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 32px 32px;
            mask-image: radial-gradient(circle at center, black 35%, transparent 95%);
            opacity: 0.18;
        }

        .admin-surface {
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: rgba(8, 17, 31, 0.72);
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 80px rgba(2, 6, 23, 0.35);
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            border-radius: 1rem;
            padding: 0.9rem 1rem;
            color: rgb(191 219 254 / 0.82);
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease, transform 180ms ease;
            border: 1px solid transparent;
        }

        .admin-nav-link:hover {
            transform: translateY(-1px);
            border-color: rgba(103, 232, 249, 0.24);
            background: rgba(14, 27, 45, 0.92);
            color: white;
        }

        .admin-nav-link.is-active {
            border-color: rgba(103, 232, 249, 0.32);
            background: linear-gradient(135deg, rgba(8, 145, 178, 0.24), rgba(79, 70, 229, 0.2));
            color: white;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }

        .admin-focus:focus-visible {
            outline: 2px solid rgba(103, 232, 249, 0.9);
            outline-offset: 3px;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body class="text-slate-100 antialiased">
    <a href="#admin-main"
        class="admin-focus sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-xl focus:bg-cyan-300 focus:px-4 focus:py-2 focus:text-slate-950">
        Skip to content
    </a>

    @php
        $navItems = [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'fa-chart-pie'],
            ['route' => 'admin.projects.index', 'label' => 'Projects', 'icon' => 'fa-diagram-project'],
            ['route' => 'admin.blogs.index', 'label' => 'Blogs', 'icon' => 'fa-newspaper'],
            ['route' => 'admin.experiences.index', 'label' => 'Experience', 'icon' => 'fa-briefcase'],
            ['route' => 'admin.skills.index', 'label' => 'Skills', 'icon' => 'fa-layer-group'],
            ['route' => 'admin.contacts.index', 'label' => 'Contacts', 'icon' => 'fa-envelope-open-text'],
            ['route' => 'admin.settings.index', 'label' => 'Settings', 'icon' => 'fa-sliders'],
        ];
    @endphp

    <div class="admin-shell relative min-h-screen">
        <div id="admin-nav-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/70 backdrop-blur-sm lg:hidden"></div>

        <aside id="admin-sidebar"
            class="admin-surface fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-white/5 p-5 transition-transform duration-200 lg:translate-x-0">
            <div class="flex items-center justify-between gap-3 border-b border-white/10 pb-5">
                <div>
                    <div class="admin-display text-lg font-bold tracking-tight text-white">Portfolio Admin</div>
                    <p class="mt-1 text-sm text-slate-400">Project, content & site controls</p>
                </div>
                <button type="button" id="admin-nav-close"
                    class="admin-focus rounded-xl border border-white/10 px-3 py-2 text-slate-300 lg:hidden">
                    <span class="sr-only">Close navigation</span>
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-cyan-300/80">Signed In</div>
                <div class="mt-2 text-base font-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-sm text-slate-400">{{ auth()->user()->email ?? 'Portfolio manager' }}</div>
            </div>

            <nav class="mt-6 space-y-2" aria-label="Admin">
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="admin-nav-link admin-focus {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'is-active' : '' }}">
                        <i class="fa-solid {{ $item['icon'] }} w-5 text-center" aria-hidden="true"></i>
                        <span class="font-medium">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto space-y-3 border-t border-white/10 pt-5">
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                    class="admin-nav-link admin-focus">
                    <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center" aria-hidden="true"></i>
                    <span class="font-medium">View Site</span>
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="admin-focus flex w-full items-center justify-center gap-2 rounded-2xl border border-rose-400/20 bg-rose-500/10 px-4 py-3 font-semibold text-rose-200 transition-colors duration-200 hover:bg-rose-500/20">
                        <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="relative lg:pl-72">
            <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/55 backdrop-blur-xl">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button type="button" id="admin-nav-open"
                            class="admin-focus inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-100 lg:hidden">
                            <span class="sr-only">Open navigation</span>
                            <i class="fa-solid fa-bars" aria-hidden="true"></i>
                        </button>
                        <div>
                            <p class="text-xs uppercase tracking-[0.24em] text-cyan-300/75">Admin Workspace</p>
                            <h1 class="admin-display text-2xl font-bold tracking-tight text-white">
                                @yield('page-title', 'Dashboard')
                            </h1>
                            @hasSection('page-subtitle')
                                <p class="mt-1 text-sm text-slate-400">@yield('page-subtitle')</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @yield('page-actions')
                    </div>
                </div>
            </header>

            <main id="admin-main" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div aria-live="polite" class="mb-6 space-y-3">
                    @if(session('success'))
                        <div class="admin-surface rounded-2xl border-emerald-400/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="admin-surface rounded-2xl border-rose-400/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="admin-surface rounded-2xl border-amber-300/20 bg-amber-500/10 px-5 py-4 text-sm text-amber-50">
                            <p class="font-semibold text-white">Please review the highlighted fields.</p>
                            <ul class="mt-2 space-y-1 text-amber-100/90">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openButton = document.getElementById('admin-nav-open');
            const closeButton = document.getElementById('admin-nav-close');
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-nav-overlay');

            if (!openButton || !closeButton || !sidebar || !overlay) {
                return;
            }

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            openButton.addEventListener('click', openSidebar);
            closeButton.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
