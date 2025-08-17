{{-- resources/views/components/footer.blade.php --}}
<footer class="border-t border-cyan-500/20 py-8">
    <div class="container mx-auto px-6 text-center text-gray-400">
        <div class="flex justify-center gap-6 mb-4">
            <a href="{{ $settings['https://github.com/awais0892'] ?? 'https://github.com/awais0892' }}" target="_blank" class="text-2xl hover:text-cyan-400 transition-colors"><i class="fab fa-github"></i></a>
            <a href="{{ $settings['https://www.linkedin.com/in/awaisahmads/'] ?? 'https://www.linkedin.com/in/awaisahmads/' }}" target="_blank" class="text-2xl hover:text-cyan-400 transition-colors"><i class="fab fa-linkedin"></i></a>
            <a href="mailto:{{ $settings['email'] ?? 'awais.32525@gmail.com' }}" class="text-2xl hover:text-cyan-400 transition-colors"><i class="fas fa-envelope"></i></a>
        </div>
        <p>&copy; {{ date('Y') }} Awais Ahmad. Designed & Built with a futuristic touch.</p>
    </div>
</footer>