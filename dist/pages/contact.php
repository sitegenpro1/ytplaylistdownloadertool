<?php
$pageTitle = "Contact Us";
include '../header.php';
?>

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <h1 class="text-3xl font-bold mb-6 text-slate-900">Contact Us</h1>
    <p class="text-slate-500 mb-8">Have questions, suggestions, or need to report an issue? We're here to help.</p>

    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="p-6 bg-slate-50 rounded-xl border border-slate-100">
            <h3 class="font-bold text-lg mb-2">General Support</h3>
            <p class="text-sm text-slate-500 mb-3">For help with using the tool.</p>
            <a href="mailto:support@example.com" class="text-red-600 font-medium hover:underline">support@example.com</a>
        </div>
        <div class="p-6 bg-slate-50 rounded-xl border border-slate-100">
            <h3 class="font-bold text-lg mb-2">Legal & Abuse</h3>
            <p class="text-sm text-slate-500 mb-3">For DMCA and abuse reports.</p>
            <a href="mailto:legal@example.com" class="text-red-600 font-medium hover:underline">legal@example.com</a>
        </div>
    </div>

    <form class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Your Name</label>
            <input type="text" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
            <input type="email" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Message</label>
            <textarea rows="5" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"></textarea>
        </div>
        <button type="button" class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-lg font-medium transition w-full md:w-auto">
            Send Message
        </button>
    </form>
</div>

<?php include '../footer.php'; ?>
