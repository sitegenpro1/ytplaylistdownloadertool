<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Playlist Downloader</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #dc2626;
            width: 24px;
            height: 24px;
            -webkit-animation: spin 1s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="index.php" class="flex items-center space-x-2 text-red-600 hover:opacity-80 transition">
                <i data-lucide="youtube" class="w-8 h-8"></i>
                <span class="text-xl font-bold tracking-tight text-slate-900">PlaylistDownloader</span>
            </a>
            <nav class="hidden md:flex space-x-6 text-sm font-medium text-slate-600">
                <a href="index.php" class="hover:text-red-600 transition">Home</a>
                <a href="pages/about.php" class="hover:text-red-600 transition">About</a>
                <a href="pages/contact.php" class="hover:text-red-600 transition">Contact</a>
            </nav>
            <!-- Mobile Menu Button -->
            <button class="md:hidden text-slate-600">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8 max-w-5xl">
        
        <!-- Search Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-10 mb-8 transition-all duration-300">
            <h1 class="text-3xl font-bold text-center mb-2">YouTube Playlist Downloader</h1>
            <p class="text-slate-500 text-center mb-8">Archive entire playlists in high quality. Fast, secure, and free.</p>
            
            <div class="flex flex-col md:flex-row gap-3 max-w-2xl mx-auto">
                <div class="relative flex-grow">
                    <input
                        type="text"
                        id="playlistUrl"
                        placeholder="Paste YouTube Playlist URL here..."
                        class="w-full px-4 py-3 pl-10 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    />
                    <i data-lucide="link" class="absolute left-3 top-3.5 text-slate-400 w-5 h-5"></i>
                </div>
                <button
                    id="fetchBtn"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed min-w-[120px]"
                >
                    <span id="fetchIcon"><i data-lucide="play" class="w-5 h-5"></i></span>
                    <span id="fetchSpinner" class="hidden loader border-white border-t-transparent"></span>
                    <span id="fetchText">Fetch</span>
                </button>
            </div>
            
            <!-- Error Message -->
            <div id="errorMessage" class="hidden max-w-2xl mx-auto mt-4 p-4 bg-red-50 text-red-700 rounded-lg flex items-center gap-2 border border-red-100">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span id="errorText">Error message here</span>
            </div>
        </div>

        <!-- Playlist Info & Video List -->
        <div id="playlistSection" class="hidden bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            
            <!-- Playlist Header -->
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/50">
                <div class="flex items-start gap-4">
                    <img id="playlistThumb" src="" alt="Playlist" class="w-24 h-24 object-cover rounded-lg shadow-sm hidden md:block">
                    <div>
                        <h2 id="playlistTitle" class="text-xl font-bold text-slate-900 line-clamp-1">Playlist Title</h2>
                        <p id="playlistMeta" class="text-slate-500 text-sm mt-1">0 videos • Channel Name</p>
                        <div class="mt-3 flex gap-2">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ready
                             </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-3 w-full md:w-auto">
                    <!-- Download Controls -->
                    <div class="flex bg-white border border-slate-200 rounded-lg p-1 shadow-sm">
                        <button onclick="setMode('batch')" id="btnBatch" class="px-3 py-1.5 text-sm font-medium rounded-md transition bg-slate-100 text-slate-900">
                            Batch
                        </button>
                        <button onclick="setMode('sequential')" id="btnSeq" class="px-3 py-1.5 text-sm font-medium rounded-md transition text-slate-500 hover:text-slate-700">
                            Sequential
                        </button>
                    </div>
                    
                    <div class="flex gap-2 w-full md:w-auto">
                        <button
                            id="downloadBtn"
                            class="flex-1 md:flex-none bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg font-medium transition flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <i data-lucide="download" class="w-4 h-4"></i>
                            <span id="downloadText">Download Selected</span>
                        </button>
                        <button id="stopBtn" class="hidden bg-red-600 hover:bg-red-700 text-white px-3 py-2.5 rounded-lg transition" title="Stop Downloads">
                            <i data-lucide="square" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <button id="selectAllBtn" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    <i data-lucide="check-square" class="w-5 h-5 text-red-600"></i>
                    <span>Select All</span>
                </button>
                <span id="selectedCount" class="text-sm text-slate-500 font-medium">0 selected</span>
            </div>

            <!-- Video List -->
            <div id="videoList" class="divide-y divide-slate-100 max-h-[800px] overflow-y-auto">
                <!-- Video Items will be injected here -->
            </div>
        </div>

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
                    <li><a href="pages/privacy.php" class="hover:text-red-600">Privacy Policy</a></li>
                    <li><a href="pages/dmca.php" class="hover:text-red-600">DMCA</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><a href="pages/contact.php" class="hover:text-red-600">Contact Us</a></li>
                    <li><a href="pages/contact.php" class="hover:text-red-600">Report Abuse</a></li>
                </ul>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-8 pt-8 border-t border-slate-100 text-center text-sm text-slate-400">
            &copy; <?php echo date("Y"); ?> PlaylistDownloader. All rights reserved.
        </div>
    </footer>

    <!-- Core Logic -->
    <script src="assets/app.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
