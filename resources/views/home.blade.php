{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', $settings['site_title'] ?? 'Awais Ahmad - Full-Stack Developer')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center">
        <div class="flex flex-col md:flex-row items-center justify-between w-full gap-12">
            <!-- Text Content -->
            <div class="text-center md:text-left md:w-1/2">
                <p class="text-cyan-400 font-semibold text-lg gsap-reveal hero-text">HI, MY NAME IS AWAIS AHMAD</p>
                <h1 class="text-4xl md:text-7xl font-orbitron text-white mt-2 mb-4 leading-tight gsap-reveal hero-text"
                    data-gsap-delay="0.1">
                    {!! $settings['hero_title'] ?? 'I Build Things <br class="hidden md:block" /> for the <span class="gradient-text">Web.</span>' !!}
                </h1>
                <p class="text-gray-300 max-w-2xl mx-auto md:mx-0 mb-8 text-lg gsap-reveal hero-text" data-gsap-delay="0.2">
                    {{ $settings['hero_subtitle'] ?? "I'm a detail-oriented software engineer with over a year of hands-on experience in Laravel and the MERN stack. I specialize in building robust web applications, scalable backend architectures, and delivering exceptional user experiences." }}
                </p>
                <div class="gsap-reveal hero-text" data-gsap-delay="0.3">
                    <a href="{{ route('projects') }}"
                        class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-6 rounded-lg transition-colors mr-4 glow-button">
                        View Projects
                    </a>
                    <a href="{{ route('cv.download') }}"
                        class="border-2 border-cyan-500 hover:bg-cyan-500/20 text-white font-bold py-3 px-6 rounded-lg transition-all"
                        download>
                        Download CV
                    </a>
                </div>
            </div>
            <!-- Profile Photo -->
            <div class="md:w-1/2 flex justify-center gsap-reveal" data-gsap-delay="0.2">
                <div class="relative">
                    <!-- Glowing ring -->
                    <div
                        class="absolute inset-0 rounded-full bg-gradient-to-br from-cyan-500 to-purple-600 blur-2xl opacity-40 scale-110">
                    </div>
                    <img src="{{ asset('assets/awais-formal.jpg') }}" alt="Awais Ahmad"
                        class="relative z-10 w-72 h-72 md:w-96 md:h-96 rounded-full object-cover object-top border-4 border-cyan-500/60 shadow-2xl"
                        style="box-shadow: 0 0 40px rgba(0, 245, 255, 0.3), 0 0 80px rgba(122, 0, 255, 0.2);">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20">
        <h2 class="text-4xl font-orbitron text-center text-white mb-12 gsap-reveal">About Me</h2>
        <div class="flex flex-col md:flex-row items-center gap-12 glass-card p-8 rounded-lg">
            <div class="md:w-1/3 gsap-reveal">
                <img src="{{ asset('assets/awais-casual.jpg') }}" alt="Awais Ahmad"
                    class="rounded-full mx-auto shadow-lg w-64 h-64 md:w-full md:h-auto object-cover border-4 border-cyan-500/50">
            </div>
            <div class="md:w-2/3 gsap-reveal" data-gsap-delay="0.1">
                <h3 class="text-2xl font-semibold text-white mb-4 font-orbitron">Building Digital Solutions</h3>
                <div class="text-gray-300 mb-6 text-lg space-y-4">
                    {!! nl2br(e($settings['about_text'] ?? "I'm a passionate software engineer from Islamabad with a strong command of both Laravel and the MERN stack (MongoDB, Express.js, React, Node.js). My expertise lies in building robust web applications, from managing database migrations and RESTful APIs in Laravel to developing scalable backend architectures.\n\nCurrently working at Pixako Technologies, I've had the opportunity to contribute to a variety of impactful projects, including a U.S. SEC-compliant government application, high-performance e-commerce platforms, and feature-rich expense tracking systems. I'm committed to translating business requirements into efficient, user-friendly solutions with a focus on performance and maintainability.\n\nAs a graduate of COMSATS University Islamabad with a BS in Computer Science, I believe in continuous learning and staying updated with the latest technologies to deliver cutting-edge digital products.")) !!}
                </div>
                <div class="flex gap-4">
                    <a href="{{ $settings['https://www.linkedin.com/in/awaisahmads/'] ?? 'https://www.linkedin.com/in/awaisahmads/' }}"
                        target="_blank"
                        class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-6 rounded-lg transition-colors glow-button">
                        LinkedIn Profile
                    </a>
                    <a href="{{ $settings['https://github.com/awais0892'] ?? 'https://github.com/awais0892' }}"
                        target="_blank"
                        class="border-2 border-cyan-500 hover:bg-cyan-500/20 text-white font-bold py-3 px-6 rounded-lg transition-all">
                        GitHub Profile
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-20">
        <h2 class="text-4xl font-orbitron text-center text-white mb-12 gsap-reveal">Work Experience</h2>
        <div class="max-w-4xl mx-auto space-y-8">
            @foreach($experiences as $experience)
                <div class="glass-card p-8 rounded-lg exp-card gsap-reveal">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <div>
                            <h3 class="text-2xl font-semibold text-white font-orbitron">{{ $experience->title }}</h3>
                            <p class="text-cyan-400 text-lg">{{ $experience->company }}@if($experience->location),
                            {{ $experience->location }}@endif
                            </p>
                        </div>
                        <span
                            class="text-gray-400 bg-cyan-900/30 px-3 py-1 rounded-full text-sm mt-2 md:mt-0">{{ $experience->duration }}</span>
                    </div>
                    <div class="text-gray-300 mb-4">
                        {!! nl2br(e($experience->description)) !!}
                    </div>
                    @if($experience->achievements && count($experience->achievements) > 0)
                        <ul class="space-y-3 text-gray-300 list-disc list-inside mb-4">
                            @foreach($experience->achievements as $achievement)
                                <li>{{ $achievement }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if($experience->technologies && count($experience->technologies) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($experience->technologies as $tech)
                                <span
                                    class="bg-cyan-900/50 text-cyan-300 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20">
        <h2 class="text-4xl font-orbitron text-center text-white mb-12 gsap-reveal">Featured Projects</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="glass-card rounded-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 gsap-reveal"
                    data-gsap-delay="{{ $loop->index * 0.1 }}">
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }} Mockup" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-orbitron text-white mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-300 mb-4 h-24">{{ Str::limit($project->description, 120) }}</p>
                        @if($project->technologies && count($project->technologies) > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                    <span
                                        class="bg-cyan-900/50 text-cyan-300 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex gap-4">
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank"
                                    class="text-cyan-400 hover:underline font-semibold">Live Demo &rarr;</a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank"
                                    class="text-cyan-400 hover:underline font-semibold">Source Code &rarr;</a>
                            @endif
                            <a href="{{ route('project.show', $project->slug) }}"
                                class="text-cyan-400 hover:underline font-semibold">View Details &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('projects') }}"
                class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-6 rounded-lg transition-colors glow-button">
                View All Projects
            </a>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20">
        <h2 class="text-4xl font-orbitron text-center text-white mb-12 gsap-reveal">Technical Arsenal</h2>
        <div class="max-w-6xl mx-auto glass-card p-8 rounded-lg">
            <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-8 gap-8">
                @foreach($skills as $skill)
                    <div class="flex flex-col items-center gap-2 gsap-reveal"
                        title="{{ $skill->name }} - {{ $skill->proficiency }}%">
                        <img src="{{ $skill->icon_url }}" class="h-16 w-16 skill-icon" alt="{{ $skill->name }}" />
                        <span class="font-semibold text-sm text-center">{{ $skill->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Education & Training Section -->
    <section id="education" class="py-20">
        <h2 class="text-4xl font-orbitron text-center text-white mb-12 gsap-reveal">Education & Training</h2>
        <div class="max-w-4xl mx-auto space-y-8">
            @foreach($education as $edu)
                <div class="glass-card p-8 rounded-lg exp-card gsap-reveal" data-gsap-delay="{{ $loop->index * 0.1 }}">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2">
                        <div>
                            <h3 class="text-2xl font-semibold text-white font-orbitron">{{ $edu->degree }}</h3>
                            <p class="text-cyan-400 text-lg">{{ $edu->institution }}@if($edu->location),
                            {{ $edu->location }}@endif
                            </p>
                        </div>
                        <span
                            class="text-gray-400 bg-cyan-900/30 px-3 py-1 rounded-full text-sm mt-2 md:mt-0">{{ $edu->duration }}</span>
                    </div>
                    @if($edu->grade)
                        <p class="text-gray-400 mb-2">Grade: {{ $edu->grade }}</p>
                    @endif
                    @if($edu->description)
                        <div class="text-gray-300 mb-4">
                            {!! nl2br(e($edu->description)) !!}
                        </div>
                    @endif
                    @if($edu->achievements && count($edu->achievements) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">
                            @foreach($edu->achievements as $key => $achievement)
                                <div>
                                    <h4 class="font-semibold text-white mb-2">{{ $key }}:</h4>
                                    @if(is_array($achievement))
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($achievement as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>{{ $achievement }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20">
        <h2 class="text-4xl font-orbitron text-center text-white mb-4 gsap-reveal">Get In Touch</h2>
        <p class="text-gray-300 max-w-2xl mx-auto mb-8 text-lg text-center gsap-reveal" data-gsap-delay="0.1">
            I'm currently open to new opportunities. Whether you'd like to discuss a potential collaboration or just want to
            say hello, feel free to reach out!
        </p>
        <div class="max-w-2xl mx-auto glass-card p-8 rounded-lg mt-8 gsap-reveal" data-gsap-delay="0.2">
            <form id="contact-form" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-left text-cyan-400 font-semibold mb-2">Your Name</label>
                        <input type="text" id="name" name="name" required
                            class="w-full p-3 rounded-lg form-input transition-all duration-300"
                            placeholder="e.g., Jane Doe">
                    </div>
                    <div>
                        <label for="email" class="block text-left text-cyan-400 font-semibold mb-2">Your Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full p-3 rounded-lg form-input transition-all duration-300"
                            placeholder="e.g., jane@example.com">
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-left text-cyan-400 font-semibold mb-2">Subject</label>
                    <input type="text" id="subject" name="subject" required
                        class="w-full p-3 rounded-lg form-input transition-all duration-300"
                        placeholder="e.g., Project Opportunity">
                </div>
                <div>
                    <label for="message" class="block text-left text-cyan-400 font-semibold mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" required
                        class="w-full p-3 rounded-lg form-input transition-all duration-300"
                        placeholder="Your message here..."></textarea>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-8 rounded-lg transition-colors text-lg glow-button">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection