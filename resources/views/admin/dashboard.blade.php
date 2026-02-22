@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Top metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-br from-[#071026] to-[#0b1224] border border-cyan-600/20 p-6 rounded-lg shadow-xl transform hover:scale-[1.01] transition-transform reveal">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-cyan-300 uppercase tracking-widest">Projects</div>
                        <div class="stat-count text-4xl font-extrabold text-white mt-2"
                            data-target="{{ $stats['projects'] ?? 0 }}">0</div>
                    </div>
                    <div class="text-cyan-400 text-3xl opacity-80"><i class="fas fa-project-diagram"></i></div>
                </div>
                <div class="text-sm text-cyan-200 mt-3">Recent: <span
                        class="text-white">{{ $recent_projects->first()->title ?? '—' }}</span></div>
            </div>

            <div
                class="bg-gradient-to-br from-[#071026] to-[#0b1224] border border-fuchsia-600/20 p-6 rounded-lg shadow-xl transform hover:scale-[1.01] transition-transform reveal">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-fuchsia-300 uppercase tracking-widest">Skills</div>
                        <div class="stat-count text-4xl font-extrabold text-white mt-2"
                            data-target="{{ $stats['skills'] ?? 0 }}">0</div>
                    </div>
                    <div class="text-fuchsia-400 text-3xl opacity-80"><i class="fas fa-microchip"></i></div>
                </div>
                <div class="text-sm text-fuchsia-200 mt-3">Visible: <span
                        class="text-white">{{ $stats['skills'] ?? 0 }}</span></div>
            </div>

            <div
                class="bg-gradient-to-br from-[#071026] to-[#0b1224] border border-emerald-500/20 p-6 rounded-lg shadow-xl transform hover:scale-[1.01] transition-transform reveal">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-emerald-300 uppercase tracking-widest">Contacts (Unread)</div>
                        <div class="stat-count text-4xl font-extrabold text-white mt-2"
                            data-target="{{ $stats['unread_contacts'] ?? 0 }}">0</div>
                    </div>
                    <div class="text-emerald-400 text-3xl opacity-80"><i class="fas fa-envelope-open-text"></i></div>
                </div>
                <div class="text-sm text-emerald-200 mt-3">Total: <span
                        class="text-white">{{ $stats['total_contacts'] ?? 0 }}</span></div>
            </div>

            <div
                class="bg-gradient-to-br from-[#071026] to-[#0b1224] border border-purple-600/20 p-6 rounded-lg shadow-xl transform hover:scale-[1.01] transition-transform reveal">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-purple-300 uppercase tracking-widest">Blog Posts</div>
                        <div class="stat-count text-4xl font-extrabold text-white mt-2"
                            data-target="{{ $stats['blogs'] ?? 0 }}">0</div>
                    </div>
                    <div class="text-purple-400 text-3xl opacity-80"><i class="fas fa-blog"></i></div>
                </div>
                <div class="text-sm text-purple-200 mt-3">Published: <span
                        class="text-white">{{ $stats['published_blogs'] ?? 0 }}</span></div>
            </div>
        </div>

        <!-- Middle panels -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-[#071026] border border-cyan-600/10 rounded-lg shadow-lg p-6 reveal">
                <h3 class="text-lg font-semibold text-white mb-4">Recent Projects</h3>
                <div class="space-y-3">
                    @forelse($recent_projects as $p)
                        <a href="{{ route('admin.projects.show', $p) }}"
                            class="block p-3 rounded-md bg-gradient-to-r from-cyan-900/10 to-transparent hover:from-cyan-900/20 transition-colors">
                            <div class="flex justify-between items-center">
                                <div class="text-white font-medium">{{ $p->title ?? 'Untitled' }}</div>
                                <div class="text-sm text-cyan-300">{{ optional($p->created_at)->toDateString() }}</div>
                            </div>
                            <div class="text-sm text-cyan-200 mt-1">
                                {{ \Illuminate\Support\Str::limit($p->description ?? $p->title ?? '', 140) }}</div>
                        </a>
                    @empty
                        <div class="text-sm text-gray-400">No recent projects.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-[#071026] border border-emerald-700/10 rounded-lg shadow-lg p-6 reveal">
                <h3 class="text-lg font-semibold text-white mb-4">Recent Contacts</h3>
                <ul class="space-y-3">
                    @forelse($recent_contacts as $c)
                        <li class="p-3 rounded-md bg-gradient-to-r from-emerald-900/6 to-transparent">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-white font-medium">{{ $c->name ?? $c->email }}</div>
                                    <div class="text-xs text-gray-400">{{ optional($c->created_at)->diffForHumans() }}</div>
                                </div>
                                <div class="text-sm text-emerald-300">{{ ucwords($c->status ?? 'new') }}</div>
                            </div>
                            @if(!empty($c->message))
                                <div class="text-sm text-gray-300 mt-2">{{ \Illuminate\Support\Str::limit($c->message, 140) }}</div>
                            @endif
                        </li>
                    @empty
                        <li class="text-sm text-gray-400">No recent contacts.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-[#071026] border border-purple-700/10 rounded-lg shadow-lg p-6 reveal">
                <h3 class="text-lg font-semibold text-white mb-4">Recent Blog Posts</h3>
                <div class="space-y-3">
                    @forelse($recent_blogs ?? [] as $blog)
                        <a href="{{ route('admin.blogs.show', $blog) }}"
                            class="block p-3 rounded-md bg-gradient-to-r from-purple-900/10 to-transparent hover:from-purple-900/20 transition-colors">
                            <div class="flex justify-between items-center">
                                <div class="text-white font-medium">{{ $blog->title ?? 'Untitled' }}</div>
                                <div class="text-sm text-purple-300">{{ optional($blog->created_at)->toDateString() }}</div>
                            </div>
                            <div class="text-sm text-purple-200 mt-1">
                                {{ \Illuminate\Support\Str::limit($blog->excerpt ?? $blog->title ?? '', 140) }}</div>
                            <div class="flex items-center gap-2 mt-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $blog->status === 'published' ? 'bg-green-500/20 text-green-300' : ($blog->status === 'draft' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-gray-500/20 text-gray-300') }}">
                                    {{ ucfirst($blog->status ?? 'draft') }}
                                </span>
                                <span class="text-xs text-purple-300">{{ $blog->views ?? 0 }} views</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-sm text-gray-400">No recent blog posts.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="space-y-8">
            <!-- Content Management -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 reveal">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-cogs text-cyan-400"></i>
                    Content Management
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Projects Management -->
                    <div
                        class="bg-gradient-to-br from-cyan-500/10 to-cyan-600/10 border border-cyan-500/20 rounded-xl p-4 hover:bg-cyan-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-cyan-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-project-diagram text-cyan-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Projects</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.projects.index') }}"
                                class="block w-full px-4 py-2 bg-cyan-600 text-white text-sm font-semibold rounded-lg hover:bg-cyan-700 transition-colors text-center">
                                Manage Projects
                            </a>
                            <a href="{{ route('admin.projects.create') }}"
                                class="block w-full px-4 py-2 bg-cyan-500/20 border border-cyan-400/30 text-cyan-300 text-sm font-semibold rounded-lg hover:bg-cyan-500/30 transition-colors text-center">
                                New Project
                            </a>
                        </div>
                    </div>

                    <!-- Blog Management -->
                    <div
                        class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-4 hover:bg-purple-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-blog text-purple-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Blog Posts</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.blogs.index') }}"
                                class="block w-full px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 transition-colors text-center">
                                Manage Blogs
                            </a>
                            <a href="{{ route('admin.blogs.create') }}"
                                class="block w-full px-4 py-2 bg-purple-500/20 border border-purple-400/30 text-purple-300 text-sm font-semibold rounded-lg hover:bg-purple-500/30 transition-colors text-center">
                                New Blog Post
                            </a>
                        </div>
                    </div>

                    <!-- Skills Management -->
                    <div
                        class="bg-gradient-to-br from-fuchsia-500/10 to-fuchsia-600/10 border border-fuchsia-500/20 rounded-xl p-4 hover:bg-fuchsia-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-fuchsia-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-microchip text-fuchsia-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Skills</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.skills.index') }}"
                                class="block w-full px-4 py-2 bg-fuchsia-600 text-white text-sm font-semibold rounded-lg hover:bg-fuchsia-700 transition-colors text-center">
                                Manage Skills
                            </a>
                            <a href="{{ route('admin.skills.create') }}"
                                class="block w-full px-4 py-2 bg-fuchsia-500/20 border border-fuchsia-400/30 text-fuchsia-300 text-sm font-semibold rounded-lg hover:bg-fuchsia-500/30 transition-colors text-center">
                                New Skill
                            </a>
                        </div>
                    </div>

                    <!-- Experience Management -->
                    <div
                        class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/10 border border-emerald-500/20 rounded-xl p-4 hover:bg-emerald-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-briefcase text-emerald-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Experience</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.experiences.index') }}"
                                class="block w-full px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-colors text-center">
                                Manage Experiences
                            </a>
                            <a href="{{ route('admin.experiences.create') }}"
                                class="block w-full px-4 py-2 bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-sm font-semibold rounded-lg hover:bg-emerald-500/30 transition-colors text-center">
                                New Experience
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Management -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 reveal">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-server text-blue-400"></i>
                    System Management
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Settings Management -->
                    <div
                        class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-4 hover:bg-blue-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cog text-blue-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Site Settings</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.settings.index') }}"
                                class="block w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors text-center">
                                Manage Settings
                            </a>
                            <a href="{{ route('admin.settings.create') }}"
                                class="block w-full px-4 py-2 bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-semibold rounded-lg hover:bg-blue-500/30 transition-colors text-center">
                                New Setting
                            </a>
                        </div>
                    </div>

                    <!-- Contact Management -->
                    <div
                        class="bg-gradient-to-br from-orange-500/10 to-orange-600/10 border border-orange-500/20 rounded-xl p-4 hover:bg-orange-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-orange-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Contact Messages</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.contacts.index') }}"
                                class="block w-full px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition-colors text-center">
                                View Messages
                            </a>
                            <a href="{{ route('admin.contacts.index') }}?status=unread"
                                class="block w-full px-4 py-2 bg-orange-500/20 border border-orange-400/30 text-orange-300 text-sm font-semibold rounded-lg hover:bg-orange-500/30 transition-colors text-center">
                                Unread Messages
                            </a>
                        </div>
                    </div>

                    <!-- Dashboard Overview -->
                    <div
                        class="bg-gradient-to-br from-indigo-500/10 to-indigo-600/10 border border-indigo-500/20 rounded-xl p-4 hover:bg-indigo-500/20 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-line text-indigo-400 text-xl"></i>
                            </div>
                            <h4 class="text-white font-semibold">Analytics</h4>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.dashboard') }}"
                                class="block w-full px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors text-center">
                                Dashboard
                            </a>
                            <a href="{{ route('home') }}"
                                class="block w-full px-4 py-2 bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-sm font-semibold rounded-lg hover:bg-indigo-500/30 transition-colors text-center">
                                View Site
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-8 border-t border-white/10">
            <div class="text-sm text-gray-400">Last updated: {{ now()->toDayDateTimeString() }}</div>
            <div class="flex gap-3">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-md bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:opacity-90 transition-opacity">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    View Site
                </a>
                <a href="{{ route('admin.settings.index') }}"
                    class="px-4 py-2 rounded-md bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold hover:opacity-90 transition-opacity">
                    <i class="fas fa-cog mr-2"></i>
                    Quick Settings
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // GSAP animations for stat counters and reveal
        document.addEventListener('DOMContentLoaded', function () {
            const { gsap } = window;
            if (!gsap) return;

            // reveal cards - keep original timing for top sections
            gsap.utils.toArray('.reveal').forEach((el, i) => {
                gsap.fromTo(el, { y: 12, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.7, delay: i * 0.08, ease: 'power3.out' });
            });

            // animate numbers - keep original
            document.querySelectorAll('.stat-count').forEach(el => {
                const target = parseInt(el.dataset.target || 0, 10);
                gsap.fromTo(el, { innerText: 0 }, {
                    innerText: target,
                    duration: 1.4,
                    ease: 'power1.out',
                    snap: { innerText: 1 },
                    onUpdate: function () { el.innerText = Math.floor(el.innerText); }
                });
            });

            // IMPROVED Management section animations - Much faster and more responsive
            // Wait a bit for DOM to be fully ready
            setTimeout(() => {
                // Find management sections by looking for the specific structure
                const contentManagementSection = document.querySelector('h3[class*="text-2xl"][class*="font-bold"]');
                const managementSections = [];

                if (contentManagementSection) {
                    const section = contentManagementSection.closest('div[class*="bg-white"]');
                    if (section) managementSections.push(section);
                }

                // Also find system management section
                const systemSection = document.querySelector('h3 i.fa-server');
                if (systemSection) {
                    const section = systemSection.closest('div[class*="bg-white"]');
                    if (section && !managementSections.includes(section)) {
                        managementSections.push(section);
                    }
                }

                managementSections.forEach((section, index) => {
                    if (!section) return;

                    const cards = section.querySelectorAll('div[class*="bg-gradient-to-br"]');

                    if (section) {
                        gsap.fromTo(section,
                            { y: 20, opacity: 0 },
                            {
                                y: 0,
                                opacity: 1,
                                duration: 0.4,
                                delay: 0.6 + (index * 0.1),
                                ease: "power2.out"
                            }
                        );
                    }

                    // Animate cards within each section faster
                    if (cards.length > 0) {
                        gsap.fromTo(cards,
                            { y: 15, opacity: 0, scale: 0.98 },
                            {
                                y: 0,
                                opacity: 1,
                                scale: 1,
                                duration: 0.5,
                                stagger: 0.06,
                                delay: 0.7 + (index * 0.1),
                                ease: "power2.out"
                            }
                        );
                    }
                });
            }, 100);

            // Enhanced hover effects for management cards - More responsive
            // Use a more reliable selector
            setTimeout(() => {
                const managementCards = document.querySelectorAll('div[class*="bg-gradient-to-br"][class*="border"][class*="rounded-xl"]');

                managementCards.forEach(card => {
                    // Add a subtle glow effect on hover
                    card.addEventListener('mouseenter', () => {
                        gsap.to(card, {
                            scale: 1.03,
                            duration: 0.2,
                            ease: "power2.out"
                        });
                    });

                    card.addEventListener('mouseleave', () => {
                        gsap.to(card, {
                            scale: 1,
                            duration: 0.2,
                            ease: "power2.out"
                        });
                    });

                    // Add click animation for better feedback
                    card.addEventListener('mousedown', () => {
                        gsap.to(card, { scale: 0.98, duration: 0.1 });
                    });

                    card.addEventListener('mouseup', () => {
                        gsap.to(card, { scale: 1.03, duration: 0.1 });
                    });
                });

                // Add staggered button animations within cards
                managementCards.forEach((card, cardIndex) => {
                    const buttons = card.querySelectorAll('a');

                    if (buttons.length > 0) {
                        gsap.fromTo(buttons,
                            { opacity: 0, x: -10 },
                            {
                                opacity: 1,
                                x: 0,
                                duration: 0.3,
                                stagger: 0.1,
                                delay: 1 + (cardIndex * 0.05),
                                ease: "power2.out"
                            }
                        );
                    }
                });
            }, 150);
        });
    </script>
@endpush