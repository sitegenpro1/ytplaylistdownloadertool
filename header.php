<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - PlaylistDownloader' : 'PlaylistDownloader'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="../index.php" class="flex items-center space-x-2 text-red-600 hover:opacity-80 transition">
                <i data-lucide="youtube" class="w-8 h-8"></i>
                <span class="text-xl font-bold tracking-tight text-slate-900">PlaylistDownloader</span>
            </a>
            <nav class="hidden md:flex space-x-6 text-sm font-medium text-slate-600">
                <a href="../index.php" class="hover:text-red-600 transition">Home</a>
                <a href="about.php" class="hover:text-red-600 transition">About</a>
                <a href="contact.php" class="hover:text-red-600 transition">Contact</a>
            </nav>
            <button class="md:hidden text-slate-600">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8 max-w-5xl">
