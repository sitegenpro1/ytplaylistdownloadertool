<?php
$pageTitle = "About Us";
include '../header.php'; // We'll create a header include for reusability
?>

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <h1 class="text-3xl font-bold mb-6 text-slate-900">About PlaylistDownloader</h1>
    <div class="prose prose-slate text-slate-600 leading-relaxed">
        <p class="mb-4">
            PlaylistDownloader is a professional, web-based tool designed to help content creators, educators, and archivists save YouTube playlists for offline use. 
            We believe in the importance of data preservation and accessibility.
        </p>
        
        <h2 class="text-xl font-bold mb-3 mt-8 text-slate-800">How It Works</h2>
        <p class="mb-4">
            Our tool acts as a secure bridge between you and the content. When you enter a playlist URL:
        </p>
        <ul class="list-disc pl-5 mb-4 space-y-2">
            <li>We fetch the public metadata for the playlist.</li>
            <li>We locate the best available quality stream (MP4).</li>
            <li>We stream the content directly to your device securely.</li>
        </ul>

        <h2 class="text-xl font-bold mb-3 mt-8 text-slate-800">Privacy First</h2>
        <p>
            We do not track your downloads or store any files on our servers. The entire process is transient and designed to respect your privacy.
        </p>
    </div>
</div>

<?php include '../footer.php'; ?>
