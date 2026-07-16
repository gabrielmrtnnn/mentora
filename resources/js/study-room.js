// Helper terjemahan: pakai kamus global dari layout (window.trans), kalau belum
// ke-load (harusnya selalu ada) fallback ke teks aslinya (Indonesia).
const trans = (typeof window !== 'undefined' && window.trans) ? window.trans : (text) => text;

const MODES = {
    pomodoro25: {
        key: 'pomodoro25',
        name: 'Pomodoro 25/5',
        sequence: [{
                type: 'study',
                duration: 25 * 60,
                label: trans('Belajar 25 Menit'),
                saveMinutes: 25
            },
            {
                type: 'break',
                duration: 5 * 60,
                label: trans('Istirahat 5 Menit'),
                saveMinutes: 0
            },
            {
                type: 'study',
                duration: 25 * 60,
                label: trans('Belajar 25 Menit'),
                saveMinutes: 25
            },
            {
                type: 'break',
                duration: 5 * 60,
                label: trans('Istirahat 5 Menit'),
                saveMinutes: 0
            },
            {
                type: 'study',
                duration: 25 * 60,
                label: trans('Belajar 25 Menit'),
                saveMinutes: 25
            },
            {
                type: 'break',
                duration: 5 * 60,
                label: trans('Istirahat 5 Menit'),
                saveMinutes: 0
            },
            {
                type: 'study',
                duration: 25 * 60,
                label: trans('Belajar 25 Menit'),
                saveMinutes: 25
            },
            {
                type: 'long_break',
                duration: 30 * 60,
                label: trans('Istirahat Panjang 30 Menit'),
                saveMinutes: 0
            },
        ],
    },
    deep50: {
        key: 'deep50',
        name: 'Deep 50/10',
        sequence: [{
                type: 'study',
                duration: 50 * 60,
                label: trans('Belajar 50 Menit'),
                saveMinutes: 50
            },
            {
                type: 'break',
                duration: 10 * 60,
                label: trans('Istirahat 10 Menit'),
                saveMinutes: 0
            },
            {
                type: 'study',
                duration: 50 * 60,
                label: trans('Belajar 50 Menit'),
                saveMinutes: 50
            },
            {
                type: 'long_break',
                duration: 30 * 60,
                label: trans('Istirahat Panjang 30 Menit'),
                saveMinutes: 0
            },
        ],
    },
};

let currentMode = MODES.pomodoro25;
let currentStepIndex = 0;
let currentStep = currentMode.sequence[0];
let secondsLeft = currentStep.duration;
let totalSeconds = currentStep.duration;
let timer = null;
let isRunning = false;
let isFocusMode = false;
let expectedEndTime = 0;

// --- PERSISTENSI STATE TIMER (biar gak reset ke awal pas refresh) ---
const TIMER_STORAGE_KEY = 'mentora_solo_timer_state';

function saveTimerState() {
    try {
        sessionStorage.setItem(TIMER_STORAGE_KEY, JSON.stringify({
            modeKey: currentMode.key,
            stepIndex: currentStepIndex,
            secondsLeft: secondsLeft,
        }));
    } catch (e) {
        // sessionStorage bisa gagal (mode private/incognito dsb), abaikan saja
    }
}

function clearTimerState() {
    try {
        sessionStorage.removeItem(TIMER_STORAGE_KEY);
    } catch (e) {}
}

// Timer dianggap "sedang jalan" untuk keperluan warning navigasi kalau
// dia lagi running ATAU lagi paused di tengah (bukan di posisi awal/reset).
function hasActiveProgress() {
    return isRunning || (secondsLeft > 0 && secondsLeft < currentStep.duration);
}

function restoreTimerState() {
    let saved = null;
    try {
        saved = JSON.parse(sessionStorage.getItem(TIMER_STORAGE_KEY));
    } catch (e) {
        saved = null;
    }

    const mode = saved && MODES[saved.modeKey] ? MODES[saved.modeKey] : MODES.pomodoro25;
    const stepIndex = saved && mode.sequence[saved.stepIndex] ? saved.stepIndex : 0;
    const step = mode.sequence[stepIndex];

    currentMode = mode;
    currentStepIndex = stepIndex;
    currentStep = step;
    totalSeconds = step.duration;

    const restoredSeconds = saved && typeof saved.secondsLeft === 'number'
        ? Math.min(Math.max(saved.secondsLeft, 0), step.duration)
        : step.duration;

    secondsLeft = restoredSeconds;
    isRunning = false;

    updateModeButtons();

    // Selalu tampil sebagai "Paused" di angka terakhir, bukan auto-lanjut jalan,
    // karena tidak ada jam di server yang melacak waktu selagi tab reload.
    if (saved && restoredSeconds < step.duration && restoredSeconds > 0) {
        setStateText(trans('Dijeda'));
        if (statusText) statusText.textContent = trans('Timer dijeda. Tekan Mulai untuk lanjut.');
    } else {
        setStateText(trans('Siap'));
    }
}

// Element Selectors
const timerDisplay = document.getElementById('timerDisplay');
const sessionTitle = document.getElementById('sessionTitle');
const sessionTypeLabel = document.getElementById('sessionTypeLabel');
const statusText = document.getElementById('statusText');
const activeModeText = document.getElementById('activeModeText');
const nextBreakText = document.getElementById('nextBreakText');
const stateText = document.getElementById('stateText');
const progressCircle = document.getElementById('progressCircle');
const stepCounter = document.getElementById('stepCounter');
const timerCard = document.getElementById('timerCard');

const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resetBtn = document.getElementById('resetBtn');

const modePomodoro = document.getElementById('modePomodoro');
const modeDeep50 = document.getElementById('modeDeep50');
const focusModeBtn = document.getElementById('focusModeBtn');

const focusOverlay = document.getElementById('focusOverlay');
const exitFocusModeBtn = document.getElementById('exitFocusModeBtn');
const focusOverlayType = document.getElementById('focusOverlayType');
const focusOverlayTitle = document.getElementById('focusOverlayTitle');
const focusOverlayTimerDisplay = document.getElementById('focusOverlayTimerDisplay');
const focusOverlayStatusText = document.getElementById('focusOverlayStatusText');
const focusOverlayProgressCircle = document.getElementById('focusOverlayProgressCircle');
const focusOverlayStepCounter = document.getElementById('focusOverlayStepCounter');
const focusOverlayNextBreakText = document.getElementById('focusOverlayNextBreakText');
const focusOverlayStartBtn = document.getElementById('focusOverlayStartBtn');
const focusOverlayPauseBtn = document.getElementById('focusOverlayPauseBtn');
const focusOverlayResetBtn = document.getElementById('focusOverlayResetBtn');

const alarmSound = document.getElementById('alarmSound');

const modal = document.getElementById('sessionModal');
const modalTitle = document.getElementById('modalTitle');
const modalDescription = document.getElementById('modalDescription');
const modalPrimaryBtn = document.getElementById('modalPrimaryBtn');
const modalSecondaryBtn = document.getElementById('modalSecondaryBtn');

const todayMinutesEl = document.getElementById('todayMinutes');
const todaySessionsEl = document.getElementById('todaySessions');

const warningModal = document.getElementById('warningModal');
const warningModalTitle = document.getElementById('warningModalTitle');
const warningModalDescription = document.getElementById('warningModalDescription');
const confirmWarningBtn = document.getElementById('confirmWarningBtn');
const cancelWarningBtn = document.getElementById('cancelWarningBtn');

const soloTabBtn = document.getElementById('soloTabBtn');
const groupTabBtn = document.getElementById('groupTabBtn');
const groupTimerDisplay = document.getElementById('groupTimerDisplay');
const groupTimerCategoryLabel = document.getElementById('groupTimerCategoryLabel');

const CIRCLE_LENGTH = 427;
let pendingAction = null;

// --- KATEGORI FOKUS (TPS / Numerasi / Literasi) ---
let selectedCategory = 'TPS';       // dipakai solo mode
let groupSelectedCategory = 'TPS';  // dipakai group mode

function initCategoryPicker(scope) {
    const container = document.getElementById(scope + 'CategoryPicker');
    if (!container) return;

    const buttons = container.querySelectorAll('.category-btn');

    function setActive(category) {
        buttons.forEach((btn) => {
            const isActive = btn.dataset.category === category;
            btn.classList.toggle('border-blue-500', isActive);
            btn.classList.toggle('bg-blue-50', isActive);
            btn.classList.toggle('border-gray-100', !isActive);
            btn.classList.toggle('bg-gray-50', !isActive);
        });
    }

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const category = btn.dataset.category;

            if (scope === 'solo') {
                selectedCategory = category;
            } else if (scope === 'group') {
                groupSelectedCategory = category;
                if (groupTimerCategoryLabel) {
                    groupTimerCategoryLabel.textContent = `${trans('Kategori')}: ${category}`;
                }
            }

            setActive(category);
        });
    });

    setActive(scope === 'solo' ? selectedCategory : groupSelectedCategory);
}

// --- STOPWATCH SESI GROUP ---
let groupSeconds = 0;
let groupTimerInterval = null;
let groupTimerRunning = false;

function formatStopwatch(total) {
    const m = String(Math.floor(total / 60)).padStart(2, '0');
    const s = String(total % 60).padStart(2, '0');
    return `${m}:${s}`;
}

function startGroupTimer() {
    if (groupTimerRunning) return;

    groupTimerRunning = true;
    groupTimerInterval = setInterval(() => {
        groupSeconds += 1;
        if (groupTimerDisplay) groupTimerDisplay.textContent = formatStopwatch(groupSeconds);
    }, 1000);
}

function stopGroupTimer() {
    groupTimerRunning = false;
    if (groupTimerInterval) clearInterval(groupTimerInterval);
    groupTimerInterval = null;
}

async function finalizeGroupSession(onDone) {
    stopGroupTimer();

    const minutes = Math.floor(groupSeconds / 60);
    if (minutes >= 1) {
        await saveSession(minutes, groupSelectedCategory);
    }

    groupSeconds = 0;
    if (groupTimerDisplay) groupTimerDisplay.textContent = '00:00';

    if (onDone) onDone();
}

function formatTime(t) {
    const m = String(Math.floor(t / 60)).padStart(2, '0');
    const s = String(t % 60).padStart(2, '0');
    return `${m}:${s}`;
}

function getTypeText(type) {
    if (type === 'study') return trans('Sesi Fokus');
    if (type === 'break') return trans('Istirahat Singkat');
    return trans('Istirahat Panjang');
}

function getNextStep() {
    let next = currentStepIndex + 1;
    if (next >= currentMode.sequence.length) next = 0;
    return currentMode.sequence[next];
}

function getStudyProgress() {
    const studies = currentMode.sequence.filter(step => step.type === 'study');
    const total = studies.length;

    let completedOrCurrent = 0;
    for (let i = 0; i <= currentStepIndex; i++) {
        if (currentMode.sequence[i].type === 'study') {
            completedOrCurrent++;
        }
    }

    if (currentStep.type !== 'study') {
        completedOrCurrent = Math.max(1, completedOrCurrent);
    }

    return {
        current: Math.min(completedOrCurrent, total),
        total,
    };
}

function updateCircleElement(circleEl) {
    if (!circleEl) return;
    const progress = (totalSeconds - secondsLeft) / totalSeconds;
    const offset = CIRCLE_LENGTH - (progress * CIRCLE_LENGTH);

    circleEl.style.strokeDasharray = CIRCLE_LENGTH;
    circleEl.style.strokeDashoffset = offset;

    if (currentStep.type === 'study') {
        circleEl.style.stroke = '#FACC15';
    } else if (currentStep.type === 'break') {
        circleEl.style.stroke = '#4ADE80';
    } else {
        circleEl.style.stroke = '#A78BFA';
    }
}

function updateModeButtons() {
    const activeClass = 'mode-btn px-5 py-3 rounded-2xl text-sm font-bold transition-all duration-200 border border-blue-200 bg-blue-600 text-white shadow-md scale-[1.02]';
    const inactiveClass = 'mode-btn px-5 py-3 rounded-2xl text-sm font-bold transition-all duration-200 border border-transparent bg-gray-100 text-gray-700 hover:bg-gray-200';

    if (modePomodoro) modePomodoro.className = currentMode.key === 'pomodoro25' ? activeClass : inactiveClass;
    if (modeDeep50) modeDeep50.className = currentMode.key === 'deep50' ? activeClass : inactiveClass;
}

function updateButtonState(buttonStart, buttonPause) {
    if (!buttonStart || !buttonPause) return;
    if (isRunning) {
        buttonStart.disabled = true;
        buttonStart.className = 'px-6 py-3 rounded-2xl bg-yellow-200 text-gray-500 font-extrabold transition-all duration-200 shadow-sm cursor-not-allowed';
        buttonPause.className = 'px-6 py-3 rounded-2xl bg-white/25 text-white font-semibold hover:bg-white/30 transition-all duration-200 active:scale-[0.98] ring-2 ring-white/20';
    } else {
        buttonStart.disabled = false;
        buttonStart.className = 'px-6 py-3 rounded-2xl bg-yellow-300 text-gray-900 font-extrabold hover:bg-yellow-200 transition-all duration-200 shadow-sm active:scale-[0.98]';
        buttonPause.className = 'px-6 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition-all duration-200 active:scale-[0.98]';
    }
}

function updateCardAppearance() {
    if (timerCard) {
        if (currentStep.type === 'study') {
            timerCard.className = 'rounded-[32px] bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-500 p-8 md:p-10 text-white shadow-lg transition-all duration-300';
        } else if (currentStep.type === 'break') {
            timerCard.className = 'rounded-[32px] bg-gradient-to-br from-emerald-500 via-green-500 to-teal-500 p-8 md:p-10 text-white shadow-lg transition-all duration-300';
        } else {
            timerCard.className = 'rounded-[32px] bg-gradient-to-br from-violet-600 via-purple-500 to-fuchsia-500 p-8 md:p-10 text-white shadow-lg transition-all duration-300';
        }
    }

    if (focusOverlay) {
        if (currentStep.type === 'study') {
            focusOverlay.className = 'fixed inset-0 z-[9999] bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 text-white flex';
        } else if (currentStep.type === 'break') {
            focusOverlay.className = 'fixed inset-0 z-[9999] bg-gradient-to-br from-emerald-600 via-green-600 to-teal-600 text-white flex';
        } else {
            focusOverlay.className = 'fixed inset-0 z-[9999] bg-gradient-to-br from-violet-700 via-purple-600 to-fuchsia-700 text-white flex';
        }

        if (!isFocusMode) {
            focusOverlay.classList.add('hidden');
            focusOverlay.classList.remove('flex');
        }
    }
}

function updateDisplay() {
    const next = getNextStep();
    const progress = getStudyProgress();
    const timeText = formatTime(secondsLeft);
    const statusTextContent = (statusText && statusText.textContent) ? statusText.textContent : trans('Siap');

    if (timerDisplay) timerDisplay.textContent = timeText;
    if (sessionTitle) sessionTitle.textContent = currentStep.label;
    if (sessionTypeLabel) sessionTypeLabel.textContent = getTypeText(currentStep.type);
    if (activeModeText) activeModeText.textContent = currentMode.name;
    if (nextBreakText) nextBreakText.textContent = next.label;
    if (stepCounter) stepCounter.textContent = `${trans('Sesi')} ${progress.current} / ${progress.total}`;

    if (focusOverlayTimerDisplay) focusOverlayTimerDisplay.textContent = timeText;
    if (focusOverlayTitle) focusOverlayTitle.textContent = currentStep.label;
    if (focusOverlayType) focusOverlayType.textContent = getTypeText(currentStep.type);
    if (focusOverlayNextBreakText) focusOverlayNextBreakText.textContent = next.label;
    if (focusOverlayStepCounter) focusOverlayStepCounter.textContent = `${trans('Sesi')} ${progress.current} / ${progress.total}`;

    if (focusOverlayStatusText) {
        focusOverlayStatusText.textContent = statusTextContent;
    }

    updateCircleElement(progressCircle);
    updateCircleElement(focusOverlayProgressCircle);

    updateModeButtons();
    updateButtonState(startBtn, pauseBtn);
    updateButtonState(focusOverlayStartBtn, focusOverlayPauseBtn);
    updateCardAppearance();
}

function setStateText(text) {
    if (stateText) stateText.textContent = text;
    if (focusOverlayStatusText) {
        focusOverlayStatusText.textContent = text;
    }
}

function stopTimer() {
    if (timer) {
        clearInterval(timer);
        timer = null;
    }
    isRunning = false;
    updateDisplay();
}

function resetCurrentStep() {
    stopTimer();
    secondsLeft = currentStep.duration;
    totalSeconds = currentStep.duration;
    setStateText(trans('Siap'));
    if (statusText) statusText.textContent = trans('Timer di-reset.');
    updateDisplay();
    saveTimerState();
}

function switchMode(modeKey) {
    const doSwitch = () => {
        stopTimer();
        currentMode = MODES[modeKey];
        currentStepIndex = 0;
        currentStep = currentMode.sequence[0];
        secondsLeft = currentStep.duration;
        totalSeconds = currentStep.duration;
        setStateText(trans('Siap'));
        updateDisplay();
        saveTimerState();
    };

    if (isRunning) {
        showWarning(doSwitch); // Panggil modal keren kita
    } else {
        doSwitch();
    }
}

function nextStep() {
    currentStepIndex += 1;

    if (currentStepIndex >= currentMode.sequence.length) {
        currentStepIndex = 0;
    }

    currentStep = currentMode.sequence[currentStepIndex];
    secondsLeft = currentStep.duration;
    totalSeconds = currentStep.duration;

    setStateText(trans('Siap'));
    if (statusText) statusText.textContent = `${currentStep.label} ${trans('siap dimulai.')}`;
    updateDisplay();
    saveTimerState();
}

function playAlarm() {
    if (!alarmSound) return;

    alarmSound.pause();
    alarmSound.currentTime = 0;

    alarmSound.play().then(() => {
        console.log('Alarm bunyi!');
    }).catch(error => {
        console.error('Alarm diblokir browser:', error);
        alert(trans('Sesi selesai!'));
    });
}

function openModal(title, desc, nextLabel) {
    if (!modal) return;

    if (modalTitle) modalTitle.textContent = title;
    if (modalDescription) modalDescription.textContent = desc;

    if (modalPrimaryBtn) {
        modalPrimaryBtn.textContent = `${nextLabel}`;
        modalPrimaryBtn.onclick = () => {
            closeModal();
            nextStep(); // Pindah ke step berikutnya (break/study)

            // Tambahkan ini supaya langsung jalan
            setTimeout(() => {
                startTimer();
            }, 100);
        };
    }

    if (modalSecondaryBtn) {
        modalSecondaryBtn.onclick = () => {
            closeModal();
        };
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function saveSession(minutes, category) {
    if (!minutes || minutes <= 0) return true;

    const categoryToSend = category || selectedCategory;

    try {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = metaTag ? metaTag.getAttribute('content') : '';

        const response = await fetch('/study-room/session', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                duration: minutes,
                category: categoryToSend,
            }),
        });

        if (!response.ok) {
            throw new Error('Failed to save session');
        }

        if (todayMinutesEl && todaySessionsEl) {
            const currentMinutes = parseInt(todayMinutesEl.textContent || '0', 10);
            const currentSessions = parseInt(todaySessionsEl.textContent || '0', 10);
            todayMinutesEl.textContent = currentMinutes + minutes;
            todaySessionsEl.textContent = currentSessions + 1;
        }

        return true;
    } catch (error) {
        console.error(error);
        return false;
    }
}

async function handleSessionComplete() {
    stopTimer();
    playAlarm();

    const next = getNextStep();

    if (currentStep.type === 'study') {
        setStateText(trans('Selesai'));
        if (statusText) statusText.textContent = trans('Sesi fokus selesai.');

        openModal(
            trans('Sesi fokus selesai'),
            `${currentStep.label} ${trans('selesai. Sekarang lanjut ke')} ${next.label}.`,
            next.label
        );

        saveSession(currentStep.saveMinutes);
        updateDisplay();
        return;
    }

    if (currentStep.type === 'break') {
        setStateText(trans('Istirahat Selesai'));
        if (statusText) statusText.textContent = trans('Istirahat selesai.');

        openModal(
            trans('Istirahat selesai'),
            `${trans('Saatnya balik fokus. Langkah berikutnya:')} ${next.label}.`,
            next.label
        );
        updateDisplay();
        return;
    }

    setStateText(trans('Siklus Selesai'));
    if (statusText) statusText.textContent = trans('Istirahat panjang selesai.');
    openModal(
        trans('Siklus selesai 🔥'),
        `${trans('Istirahat panjang selesai. Urutan akan kembali ke awal:')} ${next.label}.`,
        next.label
    );
    updateDisplay();
}

function startTimer() {
    if (isRunning) return;

    isRunning = true;
    setStateText(trans('Berjalan'));
    if (statusText) statusText.textContent = `${currentStep.label} ${trans('sedang berjalan...')}`;

    expectedEndTime = Date.now() + (secondsLeft * 1000);
    updateDisplay();

    timer = setInterval(async () => {
        const now = Date.now();
        secondsLeft = Math.max(0, Math.round((expectedEndTime - now) / 1000));

        if (secondsLeft <= 0) {
            secondsLeft = 0;
            updateDisplay();
            await handleSessionComplete();
            return;
        }

        updateDisplay();
        saveTimerState();
    }, 1000);
}

function pauseTimer() {
    if (!isRunning) return;

    secondsLeft = Math.max(0, Math.round((expectedEndTime - Date.now()) / 1000));
    stopTimer();

    setStateText(trans('Dijeda'));
    if (statusText) statusText.textContent = trans('Timer dijeda. Tekan Mulai untuk lanjut.');
    updateDisplay();
    saveTimerState();
}

function resetTimer() {
    resetCurrentStep();
}

function enterFocusMode() {
    isFocusMode = true;
    if (focusOverlay) {
        focusOverlay.classList.remove('hidden');
        focusOverlay.classList.add('flex');
    }
    updateDisplay();
}

function exitFocusMode() {
    isFocusMode = false;
    if (focusOverlay) {
        focusOverlay.classList.add('hidden');
        focusOverlay.classList.remove('flex');
    }
}

// --- LOGIKA AREA KLIK SAKTI ---

window.handleAreaClick = function (event) {
    // 1. Pastikan kita tidak mengganggu tombol Start/Pause/Reset
    // closest('button') akan mengecek apakah yang diklik itu tombol atau isi di dalam tombol
    if (event.target.closest('button')) {
        return;
    }

    // 2. Cek status timer saat ini
    const state = stateText ? stateText.textContent.trim() : trans('Siap');

    // 3. Masuk Focus Mode hanya jika Running atau Paused
    if (state === trans('Berjalan') || state === trans('Dijeda')) {
        enterFocusMode();
    } else {
        // Efek visual kalau belum Start
        const card = document.getElementById('timerCard');
        card.classList.add('shake-subtle');
        setTimeout(() => card.classList.remove('shake-subtle'), 400);
        console.log("Timer belum berjalan.");
    }
};

window.handleOverlayAreaClick = function (event) {
    // Keluar mode fokus jika klik area kosong (bukan klik tombol di dalam overlay)
    if (!event.target.closest('button')) {
        exitFocusMode();
    }
};

// Event Listeners (All guarded by null checks)
if (modePomodoro) modePomodoro.addEventListener('click', () => switchMode('pomodoro25'));
if (modeDeep50) modeDeep50.addEventListener('click', () => switchMode('deep50'));
if (startBtn) startBtn.addEventListener('click', startTimer);
if (pauseBtn) pauseBtn.addEventListener('click', pauseTimer);
if (resetBtn) resetBtn.addEventListener('click', resetTimer);
if (focusOverlayStartBtn) focusOverlayStartBtn.addEventListener('click', startTimer);
if (focusOverlayPauseBtn) focusOverlayPauseBtn.addEventListener('click', pauseTimer);
if (focusOverlayResetBtn) focusOverlayResetBtn.addEventListener('click', resetTimer);
if (focusModeBtn) {
    focusModeBtn.addEventListener('click', () => {
        // Cek status timer saat ini
        const state = stateText ? stateText.textContent.trim() : trans('Siap');
        
        // Hanya izinkan masuk Focus Mode jika timer sedang jalan atau pause
        if (state === trans('Berjalan') || state === trans('Dijeda')) {
            enterFocusMode();
        } else {
            // Efek visual getar pada card utama kalau belum Start
            const card = document.getElementById('timerCard');
            if (card) {
                card.classList.add('shake-subtle');
                setTimeout(() => card.classList.remove('shake-subtle'), 400);
            }
            console.log("Timer belum berjalan, tombol Focus Mode terkunci.");
        }
    });
}
if (exitFocusModeBtn) exitFocusModeBtn.addEventListener('click', exitFocusMode);

if (modal) {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
}

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && isFocusMode) {
        exitFocusMode();
    }
});

// INITIALIZATION WRAPPER
// ONLY RUN IF WE ARE ON THE STUDY ROOM PAGE
if (timerDisplay) {
    restoreTimerState();
    updateDisplay();
    initCategoryPicker('solo');
    initCategoryPicker('group');

    // Kalau halaman di-load langsung ke tab Group (misal lewat session active_tab),
    // stopwatch group langsung jalan juga.
    const studyRoomContainerEl = document.getElementById('studyRoomContainer');
    if (studyRoomContainerEl && studyRoomContainerEl.dataset.initialTab === 'group') {
        startGroupTimer();
    }
}

// Listener untuk mencegah user pindah halaman saat timer solo ATAU sesi group aktif
window.addEventListener('beforeunload', (event) => {
    if (hasActiveProgress() || groupTimerRunning) {
        event.preventDefault();
        event.returnValue = ''; 
    }
});

function showWarning(onConfirm, title, description) {
    pendingAction = onConfirm;

    if (warningModalTitle) {
        warningModalTitle.textContent = title || trans('Sesi Belajar Masih Berjalan');
    }
    if (warningModalDescription) {
        warningModalDescription.textContent = description ||
            trans('Kalau kamu pindah halaman sekarang, timer akan berhenti dan progres sesi ini bisa hilang. Yakin mau lanjut?');
    }

    if (warningModal) {
        warningModal.classList.remove('hidden');
        warningModal.classList.add('flex');
    }
}

// Event listener tombol modal
if (cancelWarningBtn) {
    cancelWarningBtn.onclick = () => {
        warningModal.classList.add('hidden');
        warningModal.classList.remove('flex');
        pendingAction = null;
    };
}

if (confirmWarningBtn) {
    confirmWarningBtn.onclick = () => {
        warningModal.classList.add('hidden');
        warningModal.classList.remove('flex');
        if (pendingAction) pendingAction();
    };
}

// --- TAB GROUP: auto-start stopwatch pas masuk, konfirmasi pas mau keluar ---
if (groupTabBtn) {
    groupTabBtn.addEventListener('click', () => {
        startGroupTimer();
    });
}

if (soloTabBtn) {
    // Pakai capture phase supaya listener ini jalan LEBIH DULU dari @click Alpine
    // di tombol yang sama, jadi bisa dicegat sebelum tab-nya kepindah.
    soloTabBtn.addEventListener('click', (event) => {
        if (!groupTimerRunning) return;

        event.preventDefault();
        event.stopImmediatePropagation();

        showWarning(
            () => {
                finalizeGroupSession(() => {
                    const container = document.getElementById('studyRoomContainer');
                    if (window.Alpine && container) {
                        window.Alpine.$data(container).activeTab = 'solo';
                    }
                });
            },
            trans('Akhiri Sesi Kelompok?'),
            `${trans('Sesi belajar kamu (kategori')} ${groupSelectedCategory}) ${trans('akan disimpan dulu sebelum pindah ke Mode Solo. Lanjut?')}`
        );
    }, true);
}

// Pantau semua link di halaman Mentora
document.addEventListener('click', (event) => {
    const link = event.target.closest('a');

    if (!link || !link.href || link.target) return;

    const targetUrl = link.href;
    const isRealNav = !targetUrl.includes('#') && targetUrl !== window.location.href;

    if (!isRealNav) return;

    // Kalau lagi di sesi group (stopwatch jalan) terus mau pindah HALAMAN LAIN
    // (bukan cuma ganti tab), simpan dulu sesi groupnya sebelum pindah.
    if (groupTimerRunning) {
        event.preventDefault();

        showWarning(
            () => {
                finalizeGroupSession(() => {
                    window.location.href = targetUrl;
                });
            },
            trans('Akhiri Sesi Kelompok?'),
            `${trans('Sesi belajar kamu (kategori')} ${groupSelectedCategory}) ${trans('akan disimpan dulu sebelum pindah halaman. Lanjut?')}`
        );
        return;
    }

    // Kalau timer solo lagi jalan/paused, pakai warning versi biasa
    if (hasActiveProgress()) {
        event.preventDefault();

        showWarning(() => {
            window.location.href = targetUrl;
        });
    }
});