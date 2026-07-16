// ---------- Slider Video -> Foto ----------
let currentSlide = 0;

function moveSlide(direction) {
    currentSlide = Math.max(0, Math.min(1, currentSlide + direction));

    const slider = document.getElementById('mainSlider');
    if (!slider) return;

    slider.style.transform = `translateX(-${currentSlide * 50}%)`;

    const prevBtn = document.getElementById('slidePrevBtn');
    const nextBtn = document.getElementById('slideNextBtn');
    if (prevBtn) prevBtn.classList.toggle('hidden', currentSlide === 0);
    if (nextBtn) nextBtn.classList.toggle('hidden', currentSlide === 1);

    const dot0 = document.getElementById('slideDot-0');
    const dot1 = document.getElementById('slideDot-1');
    if (dot0) dot0.className = currentSlide === 0
        ? 'w-2 h-2 rounded-full bg-white'
        : 'w-2 h-2 rounded-full bg-white/40';
    if (dot1) dot1.className = currentSlide === 1
        ? 'w-2 h-2 rounded-full bg-white'
        : 'w-2 h-2 rounded-full bg-white/40';

    const video = document.getElementById('mainVideo');
    if (!video) return;

    // Video hanya ikut jalan/pause mengikuti slide yang aktif.
    // Ketika user pindah ke slide foto, video di-pause (bukan di-reset)
    // supaya kalau balik lagi ke slide video, posisinya nyambung.
    if (currentSlide === 0) {
        // If it was playing or not explicitly paused by the user, we play it.
        // We can just try to play it.
        video.play().catch(() => {});
    } else {
        video.pause();
    }
}

// ---------- Video 3D: Autoplay + Custom Controls (Play/Pause, Slider, Mute) ----------
function formatTime(seconds) {
    if (!isFinite(seconds) || isNaN(seconds)) return '00:00';
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = Math.floor(seconds % 60).toString().padStart(2, '0');
    return `${m}:${s}`;
}

function updateVideoTimeLabel(video, label) {
    label.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
}

function initMainVideo() {
    const video = document.getElementById('mainVideo');
    if (!video) return;

    const label = document.getElementById('videoTimeLabel');
    const slider = document.getElementById('videoSlider');
    const playPauseBtn = document.getElementById('videoPlayPauseBtn');
    const playIcon = document.getElementById('playIcon');
    const pauseIcon = document.getElementById('pauseIcon');
    const muteBtn = document.getElementById('videoMuteBtn');
    const muteIcon = document.getElementById('muteIcon');
    const unmuteIcon = document.getElementById('unmuteIcon');

    // Auto-play the video initially (muted)
    video.muted = true;
    video.play().catch(() => {});

    // Helper to update play/pause buttons
    const syncPlayPauseButtons = () => {
        if (video.paused) {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        } else {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        }
    };

    // Helper to update mute buttons
    const syncMuteButtons = () => {
        if (video.muted || video.volume === 0) {
            muteIcon.classList.remove('hidden');
            unmuteIcon.classList.add('hidden');
        } else {
            muteIcon.classList.add('hidden');
            unmuteIcon.classList.remove('hidden');
        }
    };

    // Listen to video state changes to sync custom control icons
    video.addEventListener('play', syncPlayPauseButtons);
    video.addEventListener('pause', syncPlayPauseButtons);
    video.addEventListener('volumechange', syncMuteButtons);

    // Play/Pause button click
    if (playPauseBtn) {
        playPauseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (video.paused) {
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        });
    }

    // Mute/Unmute button click
    if (muteBtn) {
        muteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            video.muted = !video.muted;
        });
    }

    // Time update (synced label and slider progress)
    if (label) {
        const handleTimeUpdate = () => {
            updateVideoTimeLabel(video, label);
            if (slider && video.duration) {
                slider.value = (video.currentTime / video.duration) * 100;
            }
        };

        video.addEventListener('loadedmetadata', handleTimeUpdate);
        video.addEventListener('durationchange', handleTimeUpdate);
        video.addEventListener('timeupdate', handleTimeUpdate);
    }

    // Video Slider scrubbing (seeking)
    if (slider) {
        const seekVideo = () => {
            if (video.duration) {
                video.currentTime = (slider.value / 100) * video.duration;
            }
        };
        slider.addEventListener('input', seekVideo);
        slider.addEventListener('change', seekVideo);
    }

    // Handlers for loop
    video.addEventListener('ended', () => {
        if (!video.loop) {
            video.currentTime = 0;
            video.play().catch(() => {});
        }
    });

    // Run initial syncs
    syncPlayPauseButtons();
    syncMuteButtons();
}

// ---------- Modal Popup Gambar (With scale-up & fade transition animations) ----------
function openImageModal(src, caption) {
    const modal = document.getElementById('imageModal');
    const container = document.getElementById('modalContainer');
    const img = document.getElementById('modalImage');
    const cap = document.getElementById('modalCaption');

    if (!modal || !container || !img) return;

    img.src = src;
    img.alt = caption;
    if (cap) cap.textContent = caption;

    // Remove hidden-equivalent classes and apply transition classes
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');
    
    container.classList.remove('scale-95');
    container.classList.add('scale-100');

    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    const container = document.getElementById('modalContainer');
    const img = document.getElementById('modalImage');

    if (!modal || !container || !img) return;

    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.classList.remove('opacity-100', 'pointer-events-auto');
    
    container.classList.remove('scale-100');
    container.classList.add('scale-95');

    // Remove image src after animation finishes to avoid visual flash next time
    setTimeout(() => {
        if (modal.classList.contains('opacity-0')) {
            img.src = '';
        }
    }, 300);

    document.body.style.overflow = '';
}

function closeImageModalBackdrop(event) {
    if (event.target.id === 'imageModal') {
        closeImageModal();
    }
}

// ---------- DOM Bindings (Expose to global window scope for inline onclick/Vite ES compatibility) ----------
window.moveSlide = moveSlide;
window.openImageModal = openImageModal;
window.closeImageModal = closeImageModal;
window.closeImageModalBackdrop = closeImageModalBackdrop;

document.addEventListener('DOMContentLoaded', () => {
    initMainVideo();
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeImageModal();
});