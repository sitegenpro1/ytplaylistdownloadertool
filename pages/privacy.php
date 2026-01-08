<?php
$pageTitle = "Privacy Policy";
include '../header.php';
?>

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <h1 class="text-3xl font-bold mb-6 text-slate-900">Privacy Policy</h1>
    <div class="prose prose-slate text-slate-600">
        <p class="mb-4">Last updated: <?php echo date('F Y'); ?></p>
        
        <p class="mb-4">
            Your privacy is important to us. It is PlaylistDownloader's policy to respect your privacy regarding any information we may collect from you across our website.
        </p>

        <h3 class="font-bold text-lg text-slate-900 mt-6 mb-3">Information We Collect</h3>
        <p class="mb-4">
            We do not ask for personal information unless we truly need it to provide a service to you. We collect it by fair and lawful means, with your knowledge and consent.
        </p>
        <p class="mb-4">
            We do not store the YouTube URLs you enter or the files you download. Logs are rotated daily and are only used for debugging errors.
        </p>

        <h3 class="font-bold text-lg text-slate-900 mt-6 mb-3">Cookies</h3>
        <p class="mb-4">
            We use local storage to remember your preferences (such as Batch vs Sequential mode). We do not use tracking cookies or sell data to third parties.
        </p>
    </div>
</div>

<?php include '../footer.php'; ?>
