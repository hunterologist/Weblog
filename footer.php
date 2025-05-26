</main>
    <footer class="bg-gray-800 text-white py-6 w-full mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 Hunterologist Weblog System. All rights reserved.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.querySelector('nav ul');
            const toggleButton = document.querySelector('nav button');
            if (toggleButton && nav) {
                toggleButton.addEventListener('click', () => {
                    nav.classList.toggle('hidden');
                    nav.classList.toggle('flex');
                    nav.classList.toggle('flex-col');
                    nav.classList.toggle('absolute');
                    nav.classList.toggle('bg-blue-600');
                    nav.classList.toggle('w-full');
                    nav.classList.toggle('top-16');
                    nav.classList.toggle('left-0');
                });
            }
        });
    </script>
</body>
</html>