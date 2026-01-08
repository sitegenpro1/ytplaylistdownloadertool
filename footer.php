    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12 mt-auto">
        <div class="container mx-auto px-4 grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 text-slate-900 mb-4">
                    <i data-lucide="youtube" class="w-6 h-6"></i>
                    <span class="font-bold">PlaylistDownloader</span>
                </div>
                <p class="text-slate-500 text-sm">Professional tool for archiving your favorite content.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Legal</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><a href="privacy.php" class="hover:text-red-600">Privacy Policy</a></li>
                    <li><a href="dmca.php" class="hover:text-red-600">DMCA</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><a href="contact.php" class="hover:text-red-600">Contact Us</a></li>
                    <li><a href="contact.php" class="hover:text-red-600">Report Abuse</a></li>
                </ul>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-8 pt-8 border-t border-slate-100 text-center text-sm text-slate-400">
            &copy; <?php echo date("Y"); ?> PlaylistDownloader. All rights reserved.
        </div>
    </footer>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
