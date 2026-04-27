@php
    /** @var \App\Models\Project|null $project */
    $project = $project ?? null;
    $technologies = old('technologies', $project?->technologies ? implode(', ', $project->technologies) : '');
    $imageUrl = old('image_url', $project?->getRawOriginal('image_url') ?? '');
    $fallbackImageUrl = old('fallback_image_url', $project?->getRawOriginal('fallback_image_url') ?? '');
    $resolvedImage = $project?->display_image_url;
@endphp

<div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
    <div class="space-y-6">
        <section class="admin-surface rounded-[1.75rem] p-6 sm:p-7">
            <div class="mb-6">
                <h2 class="admin-display text-xl font-bold text-white">Core Details</h2>
                <p class="mt-1 text-sm text-slate-400">Title, copy, stack and delivery links.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-200">Project Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $project?->title) }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="Expense Tracker Dashboard" autocomplete="off" required>
                    @error('title')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-200">Summary</label>
                    <textarea id="description" name="description" rows="4"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="Describe the outcome, audience and value in one clear paragraph." required>{{ old('description', $project?->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="long_description" class="mb-2 block text-sm font-semibold text-slate-200">Detailed Description</label>
                    <textarea id="long_description" name="long_description" rows="8"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="Capture scope, constraints, implementation notes and measurable impact.">{{ old('long_description', $project?->long_description) }}</textarea>
                    @error('long_description')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="technologies" class="mb-2 block text-sm font-semibold text-slate-200">Technologies</label>
                    <input type="text" id="technologies" name="technologies" value="{{ $technologies }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="Laravel, Tailwind CSS, MySQL, GSAP" autocomplete="off" spellcheck="false">
                    <p class="mt-2 text-xs text-slate-500">Separate items with commas. Duplicates are removed automatically.</p>
                    @error('technologies')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="live_url" class="mb-2 block text-sm font-semibold text-slate-200">Live Demo URL</label>
                    <input type="url" id="live_url" name="live_url" value="{{ old('live_url', $project?->live_url) }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="https://example.com" autocomplete="url" spellcheck="false">
                    @error('live_url')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="github_url" class="mb-2 block text-sm font-semibold text-slate-200">Source Code URL</label>
                    <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $project?->github_url) }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="https://github.com/username/repository" autocomplete="url" spellcheck="false">
                    @error('github_url')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="admin-surface rounded-[1.75rem] p-6 sm:p-7">
            <div class="mb-6">
                <h2 class="admin-display text-xl font-bold text-white">Visual Assets</h2>
                <p class="mt-1 text-sm text-slate-400">Use an uploaded image, a hosted URL, or a fallback URL for resilience.</p>
            </div>

            <div class="grid gap-5 lg:grid-cols-2">
                <div class="space-y-3">
                    <label for="image" class="block text-sm font-semibold text-slate-200">Upload Image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="admin-focus w-full rounded-2xl border border-dashed border-white/15 bg-slate-950/60 px-4 py-3 text-sm text-slate-200 file:mr-4 file:rounded-xl file:border-0 file:bg-cyan-300 file:px-4 file:py-2 file:font-semibold file:text-slate-950 hover:file:bg-cyan-200">
                    <p class="text-xs text-slate-500">PNG, JPG, GIF or WEBP up to 2 MB. Uploading a new file replaces the existing local image.</p>
                    @error('image')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-3">
                    <label for="image_url" class="block text-sm font-semibold text-slate-200">Hosted Image URL</label>
                    <input type="url" id="image_url" name="image_url" value="{{ $imageUrl }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="https://cdn.example.com/project-cover.jpg" autocomplete="url" spellcheck="false">
                    <p class="text-xs text-slate-500">When provided without a new upload, this becomes the primary image source.</p>
                    @error('image_url')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2 space-y-3">
                    <label for="fallback_image_url" class="block text-sm font-semibold text-slate-200">Fallback Image URL</label>
                    <input type="url" id="fallback_image_url" name="fallback_image_url" value="{{ $fallbackImageUrl }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="https://cdn.example.com/project-fallback.jpg" autocomplete="url" spellcheck="false">
                    @error('fallback_image_url')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="admin-surface rounded-[1.75rem] p-6">
            <div class="mb-5">
                <h2 class="admin-display text-xl font-bold text-white">Publishing</h2>
                <p class="mt-1 text-sm text-slate-400">Set ordering and visibility for this entry.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="order" class="mb-2 block text-sm font-semibold text-slate-200">Display Order</label>
                    <input type="number" id="order" name="order" min="0" value="{{ old('order', $project?->order ?? 0) }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500">
                    @error('order')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <input type="hidden" name="featured" value="0">
                    <label for="featured" class="flex cursor-pointer items-start gap-3">
                        <input type="checkbox" id="featured" name="featured" value="1"
                            class="admin-focus mt-1 h-4 w-4 rounded border-white/20 bg-slate-950/70 text-cyan-300"
                            {{ old('featured', $project?->featured) ? 'checked' : '' }}>
                        <span>
                            <span class="block font-semibold text-white">Featured Project</span>
                            <span class="mt-1 block text-sm text-slate-400">Highlight this on the homepage and in priority lists.</span>
                        </span>
                    </label>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <input type="hidden" name="is_active" value="0">
                    <label for="is_active" class="flex cursor-pointer items-start gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            class="admin-focus mt-1 h-4 w-4 rounded border-white/20 bg-slate-950/70 text-cyan-300"
                            {{ old('is_active', $project?->is_active ?? true) ? 'checked' : '' }}>
                        <span>
                            <span class="block font-semibold text-white">Visible On Site</span>
                            <span class="mt-1 block text-sm text-slate-400">Inactive projects remain in admin but are hidden from public pages.</span>
                        </span>
                    </label>
                </div>
            </div>
        </section>

        <section class="admin-surface rounded-[1.75rem] p-6">
            <div class="mb-4">
                <h2 class="admin-display text-xl font-bold text-white">Preview</h2>
                <p class="mt-1 text-sm text-slate-400">The module uses the best available image source.</p>
            </div>

            <div class="overflow-hidden rounded-[1.5rem] border border-white/10 bg-slate-950/60">
                <img id="projectPreviewImage" src="{{ $resolvedImage ?? asset('assets/project-placeholder.svg') }}"
                    data-default-src="{{ $resolvedImage ?? asset('assets/project-placeholder.svg') }}"
                    alt="{{ $project?->title ?? 'Project preview placeholder' }}" width="640" height="384"
                    class="h-48 w-full object-cover" loading="lazy">
                <div class="space-y-2 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <h3 id="projectPreviewTitle" class="min-w-0 truncate text-base font-semibold text-white">
                            {{ old('title', $project?->title ?: 'Project title preview') }}
                        </h3>
                        <span id="projectPreviewStatus"
                            class="rounded-full px-2.5 py-1 text-xs font-semibold {{ old('is_active', $project?->is_active ?? true) ? 'bg-emerald-400/15 text-emerald-200' : 'bg-slate-700 text-slate-300' }}">
                            {{ old('is_active', $project?->is_active ?? true) ? 'Active' : 'Hidden' }}
                        </span>
                    </div>
                    <p id="projectPreviewDescription" class="text-sm leading-6 text-slate-400">
                        {{ \Illuminate\Support\Str::limit(old('description', $project?->description ?: 'Project summary preview.'), 130) }}
                    </p>
                </div>
            </div>
        </section>
    </aside>
</div>
