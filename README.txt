# YouTube Playlist Downloader (cPanel Edition)

## Installation Instructions

1. **Upload Files**:
   - Zip the contents of the `dist` folder.
   - Upload the zip file to your cPanel `public_html` directory (or a subdirectory).
   - Extract the zip file.

2. **Requirements**:
   - PHP 7.4 or higher.
   - `allow_url_fopen` must be enabled in PHP settings (usually enabled by default).
   - `curl` extension enabled (standard on 99% of hosts).

3. **Configuration**:
   - No database required.
   - No API keys required (uses Piped public API).

## Features
- **Zero Server Load**: Fetches metadata via Client-Side JS (Piped API).
- **Secure Downloading**: Uses `api/download.php` as a stream proxy to handle filenames and CORS, but doesn't store files on disk.
- **Batch Downloading**: Automatically queues downloads.

## Troubleshooting
- **403 Errors**: If downloads fail, your server IP might be blocked by YouTube. The script tries to stream, but if your shared hosting IP is blacklisted, it might fail. In this case, consider using a VPS or a different hosting provider.
- **Timeouts**: For very long videos, the PHP script might hit a timeout. We have set `set_time_limit(0)` in `api/download.php`, but your host might enforce a hard limit (e.g., 60s).

## Legal
- This tool is for educational purposes and personal archiving only.
- Ensure you comply with YouTube's Terms of Service and local copyright laws.
