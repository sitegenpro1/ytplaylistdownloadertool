// dist/assets/app.js

// Constants
const PIPED_API = 'https://pipedapi.kavin.rocks';

// State
let state = {
    playlist: null,
    videos: [],
    loading: false,
    downloading: false,
    stopRequested: false,
    mode: 'batch', // batch | sequential
    processedCount: 0
};

// DOM Elements
const els = {
    input: document.getElementById('playlistUrl'),
    fetchBtn: document.getElementById('fetchBtn'),
    fetchSpinner: document.getElementById('fetchSpinner'),
    fetchIcon: document.getElementById('fetchIcon'),
    fetchText: document.getElementById('fetchText'),
    errorMsg: document.getElementById('errorMessage'),
    errorText: document.getElementById('errorText'),
    playlistSection: document.getElementById('playlistSection'),
    playlistTitle: document.getElementById('playlistTitle'),
    playlistMeta: document.getElementById('playlistMeta'),
    playlistThumb: document.getElementById('playlistThumb'),
    videoList: document.getElementById('videoList'),
    selectAllBtn: document.getElementById('selectAllBtn'),
    selectedCount: document.getElementById('selectedCount'),
    downloadBtn: document.getElementById('downloadBtn'),
    stopBtn: document.getElementById('stopBtn'),
    downloadText: document.getElementById('downloadText'),
    btnBatch: document.getElementById('btnBatch'),
    btnSeq: document.getElementById('btnSeq')
};

// Utility Functions
const formatDuration = (seconds) => {
    const h = Math.floor(seconds / 3600);
    const m = Math.floor((seconds % 3600) / 60);
    const s = seconds % 60;
    if (h > 0) return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    return `${m}:${s.toString().padStart(2, '0')}`;
};

const extractPlaylistId = (url) => {
    try {
        const u = new URL(url);
        return u.searchParams.get('list');
    } catch {
        return null;
    }
};

// Actions
const setMode = (mode) => {
    state.mode = mode;
    if (mode === 'batch') {
        els.btnBatch.className = "px-3 py-1.5 text-sm font-medium rounded-md transition bg-slate-100 text-slate-900";
        els.btnSeq.className = "px-3 py-1.5 text-sm font-medium rounded-md transition text-slate-500 hover:text-slate-700";
    } else {
        els.btnSeq.className = "px-3 py-1.5 text-sm font-medium rounded-md transition bg-slate-100 text-slate-900";
        els.btnBatch.className = "px-3 py-1.5 text-sm font-medium rounded-md transition text-slate-500 hover:text-slate-700";
    }
};

const showError = (msg) => {
    els.errorMsg.classList.remove('hidden');
    els.errorText.textContent = msg;
};

const hideError = () => {
    els.errorMsg.classList.add('hidden');
};

const setLoading = (isLoading) => {
    state.loading = isLoading;
    els.fetchBtn.disabled = isLoading;
    if (isLoading) {
        els.fetchSpinner.classList.remove('hidden');
        els.fetchIcon.classList.add('hidden');
        els.fetchText.textContent = 'Loading...';
    } else {
        els.fetchSpinner.classList.add('hidden');
        els.fetchIcon.classList.remove('hidden');
        els.fetchText.textContent = 'Fetch';
    }
};

const renderVideos = () => {
    els.videoList.innerHTML = '';
    state.videos.forEach(video => {
        const div = document.createElement('div');
        div.className = `p-4 flex gap-4 hover:bg-slate-50 transition group ${video.selected ? 'bg-slate-50/50' : ''}`;
        div.id = `video-${video.id}`;
        
        div.innerHTML = `
            <button onclick="toggleVideo('${video.id}')" class="text-slate-400 hover:text-red-600 transition flex-shrink-0 pt-1">
                <i data-lucide="${video.selected ? 'check-square' : 'square'}" class="w-5 h-5 ${video.selected ? 'text-red-600' : ''}"></i>
            </button>
            <div class="w-32 md:w-40 aspect-video bg-slate-200 rounded-lg overflow-hidden flex-shrink-0 relative">
                <img src="${video.thumbnail}" alt="" class="w-full h-full object-cover">
                <span class="absolute bottom-1 right-1 bg-black/80 text-white text-[10px] md:text-xs px-1.5 py-0.5 rounded">${formatDuration(video.duration)}</span>
            </div>
            <div class="flex-grow min-w-0 py-1">
                <h3 class="font-medium text-slate-900 truncate pr-4 text-sm md:text-base" title="${video.title}">${video.title}</h3>
                <p class="text-xs md:text-sm text-slate-500 mt-1">${video.uploader}</p>
                <div class="status-area mt-2 text-sm hidden">
                    <!-- Status injected here -->
                </div>
            </div>
        `;
        els.videoList.appendChild(div);
    });
    lucide.createIcons();
    updateSelectionUI();
};

const updateSelectionUI = () => {
    const selected = state.videos.filter(v => v.selected);
    els.selectedCount.textContent = `${selected.length} selected`;
    
    // Update Select All Icon
    const allSelected = state.videos.length > 0 && selected.length === state.videos.length;
    els.selectAllBtn.querySelector('i').setAttribute('data-lucide', allSelected ? 'check-square' : 'square');
    lucide.createIcons();
    
    // Enable/Disable Download
    els.downloadBtn.disabled = selected.length === 0 || state.downloading;
};

// Event Handlers
window.toggleVideo = (id) => {
    if (state.downloading) return;
    const v = state.videos.find(v => v.id === id);
    if (v) {
        v.selected = !v.selected;
        renderVideos(); // Re-render is expensive but simplest for vanilla js state sync
    }
};

els.selectAllBtn.addEventListener('click', () => {
    if (state.downloading) return;
    const allSelected = state.videos.every(v => v.selected);
    state.videos.forEach(v => v.selected = !allSelected);
    renderVideos();
});

els.fetchBtn.addEventListener('click', async () => {
    const url = els.input.value.trim();
    const listId = extractPlaylistId(url);
    
    if (!listId) {
        showError('Invalid YouTube Playlist URL');
        return;
    }

    setLoading(true);
    hideError();
    els.playlistSection.classList.add('hidden');

    try {
        const response = await fetch(`${PIPED_API}/playlists/${listId}`);
        if (!response.ok) throw new Error('Failed to fetch playlist');
        
        const data = await response.json();
        
        state.playlist = data;
        state.videos = data.relatedStreams.map(v => ({
            id: v.url.split('v=')[1],
            title: v.title,
            thumbnail: v.thumbnail,
            duration: v.duration,
            uploader: v.uploaderName,
            url: v.url,
            selected: true,
            status: 'pending'
        }));

        // Update UI
        els.playlistTitle.textContent = data.name;
        els.playlistMeta.textContent = `${state.videos.length} videos • ${data.uploader}`;
        els.playlistThumb.src = data.thumbnailUrl;
        
        renderVideos();
        els.playlistSection.classList.remove('hidden');

    } catch (err) {
        showError(err.message || 'Could not fetch playlist. Please try again.');
    } finally {
        setLoading(false);
    }
});

// Download Logic
const getStreamUrl = async (videoId) => {
    try {
        const res = await fetch(`${PIPED_API}/streams/${videoId}`);
        const data = await res.json();
        // Get best video+audio stream (mp4) or just video
        // Piped usually provides separate streams, but 'videoStreams' might have container: 'mp4'
        // Ideally we want 720p or 1080p
        // But for simplicity in "browser download", we need a single file.
        // Piped provides "audioStreams" and "videoStreams".
        // It DOES NOT mux them for us.
        // Wait, "relatedStreams" in playlist object doesn't have download links.
        // We must fetch stream info.
        
        // Problem: Browser cannot merge audio+video without FFmpeg.wasm (heavy) or server.
        // Solution: Piped API often returns a 'streams' array where some formats are video+audio (usually 720p or 360p).
        // Let's look for `videoOnly: false`.
        
        // Piped response format:
        // videoStreams: [{ url, quality, fps, videoOnly: true/false }]
        // Usually high qualities are videoOnly=true (DASH).
        // We look for a progressive stream (videoOnly=false).
        
        const progressive = data.videoStreams.find(s => s.videoOnly === false && s.format === 'MPEG-4');
        // If no mp4, try any.
        const stream = progressive || data.videoStreams.find(s => s.videoOnly === false) || data.videoStreams[0];
        
        return stream ? stream.url : null;
    } catch (e) {
        console.error(e);
        return null;
    }
};

const updateVideoStatus = (id, status, msg) => {
    const el = document.getElementById(`video-${id}`);
    if (!el) return;
    const area = el.querySelector('.status-area');
    area.classList.remove('hidden');
    
    if (status === 'loading') {
        area.innerHTML = `<div class="flex items-center gap-2 text-blue-600"><span class="loader w-4 h-4 border-2"></span> <span>${msg}</span></div>`;
    } else if (status === 'downloading') {
        area.innerHTML = `<div class="flex items-center gap-2 text-orange-600"><i data-lucide="download" class="w-4 h-4"></i> <span>${msg}</span></div>`;
    } else if (status === 'done') {
        area.innerHTML = `<div class="flex items-center gap-2 text-green-600"><i data-lucide="check" class="w-4 h-4"></i> <span>Completed</span></div>`;
    } else if (status === 'error') {
        area.innerHTML = `<div class="flex items-center gap-2 text-red-600"><i data-lucide="alert-triangle" class="w-4 h-4"></i> <span>${msg}</span></div>`;
    }
    lucide.createIcons();
};

const triggerDownload = (url, title) => {
    // We use our PHP proxy to force download
    const proxyUrl = `api/download.php?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`;
    
    // Create iframe to prevent popup blocking for batch downloads?
    // Actually, iframe works best for file downloads without opening tabs.
    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = proxyUrl;
    document.body.appendChild(iframe);
    
    // Cleanup iframe after a minute
    setTimeout(() => {
        document.body.removeChild(iframe);
    }, 60000);
};

els.stopBtn.addEventListener('click', () => {
    state.stopRequested = true;
    els.stopBtn.disabled = true;
});

els.downloadBtn.addEventListener('click', async () => {
    const selected = state.videos.filter(v => v.selected);
    if (selected.length === 0) return;

    state.downloading = true;
    state.stopRequested = false;
    els.downloadBtn.classList.add('hidden');
    els.stopBtn.classList.remove('hidden');
    els.stopBtn.disabled = false;
    
    // Disable inputs
    els.input.disabled = true;
    
    for (const video of selected) {
        if (state.stopRequested) break;
        
        updateVideoStatus(video.id, 'loading', 'Fetching stream...');
        
        try {
            const streamUrl = await getStreamUrl(video.id);
            if (streamUrl) {
                updateVideoStatus(video.id, 'downloading', 'Starting download...');
                triggerDownload(streamUrl, video.title);
                
                // Wait a bit to ensure browser registers the download
                await new Promise(r => setTimeout(r, 1000));
                updateVideoStatus(video.id, 'done', 'Done');
            } else {
                updateVideoStatus(video.id, 'error', 'No compatible stream found');
            }
        } catch (e) {
            updateVideoStatus(video.id, 'error', 'Failed');
        }

        // Delay for batch mode
        const delay = state.mode === 'batch' ? 2000 : 5000;
        await new Promise(r => setTimeout(r, delay));
    }

    state.downloading = false;
    els.downloadBtn.classList.remove('hidden');
    els.stopBtn.classList.add('hidden');
    els.input.disabled = false;
});
