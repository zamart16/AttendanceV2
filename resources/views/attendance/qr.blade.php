<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Attendance QR</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

  <!-- QR Code Library -->
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    
  <style>
    :root {
      --primary: #2563eb;
      --secondary: #16a34a;
      --bg-light-1: #f8fafc;
      --bg-light-2: #eef2ff;
    }

    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      margin: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--bg-light-1), var(--bg-light-2));
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      color: #0f172a;
    }

    /* Decorative Blobs */
    .blob {
      position: absolute;
      width: 320px;
      height: 320px;
      border-radius: 50%;
      filter: blur(100px);
      opacity: 0.35;
      z-index: 0;
    }

    .blob.one {
      background: var(--primary);
      top: -120px;
      left: -120px;
    }

    .blob.two {
      background: var(--secondary);
      bottom: -120px;
      right: -120px;
    }

    /* Card */
    .card {
      position: relative;
      z-index: 1;
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(18px);
      border-radius: 28px;
      padding: 52px 48px;
      text-align: center;
      box-shadow: 0 30px 80px rgba(15, 23, 42, 0.15);
      max-width: 460px;
      width: 92%;
      border: 1px solid rgba(255, 255, 255, 0.6);
    }

    h1 {
      font-size: 2.2rem;
      font-weight: 800;
      margin-bottom: 12px;
      color: var(--primary);
    }

    p {
      margin-bottom: 34px;
      font-size: 1.1rem;
      color: #475569;
    }

    /* QR + Sticker */
    .qr-wrapper {
      position: relative;
      display: inline-block;
      margin-bottom: 20px;
    }

    .sticker {
      position: absolute;
      top: -16px;
      right: -16px;
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: white;
      font-weight: 700;
      font-size: 0.85rem;
      padding: 8px 14px;
      border-radius: 999px;
      box-shadow: 0 8px 24px rgba(34, 197, 94, 0.4);
      transform: rotate(6deg);
      z-index: 3;
    }

    .qr-wrapper::before {
      content: "";
      position: absolute;
      inset: -14px;
      border-radius: 30px;
      background: radial-gradient(circle, rgba(37,99,235,0.25), transparent 70%);
      animation: pulse 2.5s infinite;
      z-index: -1;
    }

    @keyframes pulse {
      0% { transform: scale(0.95); opacity: 0.6; }
      50% { transform: scale(1); opacity: 1; }
      100% { transform: scale(0.95); opacity: 0.6; }
    }

    /* QR Box */
    .qr-box {
      position: relative;
      background: #ffffff;
      padding: 22px;
      border-radius: 22px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    #qrcode {
      width: 240px;
      height: 240px;
    }

    /* Center Logo */
    #qr-logo {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 56px;
      height: 56px;
      transform: translate(-50%, -50%);
      background: white;
      border-radius: 14px;
      padding: 6px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.2);
      pointer-events: none;
      z-index: 2;
    }

    #qr-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Total Attendee */
    .total-attendee {
      margin-top: 16px;
      font-weight: 700;
      font-size: 1.1rem;
      color: var(--primary);
    }

    .footer {
      margin-top: 28px;
      font-size: 0.95rem;
      color: #64748b;
    }
  </style>
</head>
<body>

    <!-- Top-left Voice Toggle -->
<div class="fixed top-4 left-4 z-50 flex items-center gap-2 bg-white/80 backdrop-blur-sm p-2 rounded-full shadow-md">
  <label class="relative inline-flex items-center cursor-pointer">
      <input
          type="checkbox"
          id="voiceToggle"
          class="sr-only peer">
      <div class="w-11 h-6 bg-gray-200 rounded-full peer
          peer-checked:after:translate-x-full
          peer-checked:after:border-white
          after:content-[''] after:absolute after:top-[2px] after:left-[2px]
          after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
          peer-checked:bg-blue-500">
      </div>
  </label>
  <span class="text-gray-700 font-semibold text-sm">Voice Assistant</span>
</div>


  <!-- Background Blobs -->
  <div class="blob one"></div>
  <div class="blob two"></div>

  <!-- Main Card -->
  <div class="card">
    <h1 class="text-4xl font-extrabold text-center text-gradient mb-3 relative inline-block">
  Scan to Register
</h1>
    <p>Please scan the QR code to record your attendance</p>

    <div class="qr-wrapper">
      <span class="sticker">SCAN ME</span>

      <div class="qr-box">
        <div id="qrcode"></div>

        <!-- CENTER LOGO -->
        <div id="qr-logo">
          <img src="{{ asset('logo.png')}}" alt="Logo">
        </div>
      </div>

      <!-- Total Attendee -->
      <div class="total-attendee">
        TOTAL ATTENDEE: <span id="attendeeCount">0</span>
      </div>
    </div>

    <div class="footer">
      Attendance System
    </div>
  </div>

  <!-- <script>
    // 🔗 CHANGE THIS TO YOUR ATTENDANCE FORM URL
    const attendanceURL = "https://bac-meeting-attendances.up.railway.app/bac-attendance";

    new QRCode(document.getElementById("qrcode"), {
      text: attendanceURL,
      width: 240,
      height: 240,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });

    // Example: Update TOTAL ATTENDEE dynamically
    let attendeeCount = 42; // Replace this with real number from backend
    document.getElementById("attendeeCount").textContent = attendeeCount;
  </script> -->

<!-- <script>
  // 🔗 ATTENDANCE FORM URL (QR CODE)
  const attendanceURL = "https://bac-meeting-attendances.up.railway.app/bac-attendance";

  new QRCode(document.getElementById("qrcode"), {
    text: attendanceURL,
    width: 240,
    height: 240,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });

  // 🔊 Voice Announcement (Female, Formal)
  function playWelcomeVoice() {
    if (!('speechSynthesis' in window)) return;

    const message = new SpeechSynthesisUtterance(
      "Good day, attendees. Welcome to Ralota Hall. Kindly scan this QR code to record your attendance. Thank you."
    );

    message.lang = 'en-US';
    message.rate = 0.9;  // slightly slower for clarity
    message.pitch = 1;

    // Select female voice if available
    const voices = speechSynthesis.getVoices();
    message.voice = voices.find(v =>
      v.lang.startsWith('en') && v.name.toLowerCase().includes('female')
    ) || voices.find(v => v.lang.startsWith('en')) || null;

    window.speechSynthesis.cancel(); // prevent overlapping
    window.speechSynthesis.speak(message);
  }

  // 📊 AJAX attendee counter
  let lastCount = null;

  function loadAttendeeCountAjax() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/attendances/today-count', true);
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onload = function () {
      if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);

        if (data.count !== lastCount) {
          lastCount = data.count;
          document.getElementById('attendeeCount').textContent = data.count;
        }
      }
    };

    xhr.send();
  }

  // 🚀 On page load
  document.addEventListener('DOMContentLoaded', () => {
    // Initial load & polling
    loadAttendeeCountAjax();
    setInterval(loadAttendeeCountAjax, 3000);

    // ⏳ Wait 5 seconds, then start repeating announcement every 20s
    setTimeout(() => {
      playWelcomeVoice(); // first announcement
      setInterval(playWelcomeVoice, 30000); // repeat every 20 seconds
    }, 5000);
  });
</script> -->



    <script>
  // 🔗 Attendance QR URL
  const attendanceURL = "https://bac-meeting-attendances.up.railway.app/bac-attendance";

  new QRCode(document.getElementById("qrcode"), {
    text: attendanceURL,
    width: 240,
    height: 240,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });

  // 🔊 Voice Assistant
  const voiceToggle = document.getElementById('voiceToggle');
  let voiceEnabled = false;

  function playWelcomeVoice() {
    if (!voiceEnabled) return; // do nothing if toggle OFF
    if (!('speechSynthesis' in window)) return;

    // Stop any ongoing speech immediately
    window.speechSynthesis.cancel();

    const msg = new SpeechSynthesisUtterance(
      "Good day, attendees. Welcome to Ralota Hall. Kindly scan this QR code to record your attendance. Thank you."
    );
    msg.lang = 'en-US';
    msg.rate = 0.9;
    msg.pitch = 1;

    const voices = speechSynthesis.getVoices();
    msg.voice = voices.find(v => v.lang.startsWith('en') && v.name.toLowerCase().includes('female')) ||
                voices.find(v => v.lang.startsWith('en')) || null;

    window.speechSynthesis.speak(msg);
  }

  // 📊 Attendee counter (AJAX)
  let lastCount = null;
  function loadAttendeeCountAjax() {
    fetch('/attendances/today-count', { headers: { 'Accept': 'application/json' } })
      .then(res => res.json())
      .then(data => {
        if (data.count !== lastCount) {
          lastCount = data.count;
          document.getElementById('attendeeCount').textContent = data.count;
        }
      })
      .catch(() => {});
  }

  // 🚀 On page load
  document.addEventListener('DOMContentLoaded', () => {
    loadAttendeeCountAjax();
    setInterval(loadAttendeeCountAjax, 3000);

    // 🔄 Voice toggle logic
    voiceToggle.checked = false; // start OFF
    voiceToggle.addEventListener('change', () => {
      voiceEnabled = voiceToggle.checked;

      if (!voiceEnabled) {
        // Stop speech immediately if toggle OFF
        window.speechSynthesis.cancel();
      } else {
        // Play first announcement immediately if toggled ON
        playWelcomeVoice();
      }
    });

    // 🔁 Repeat voice every 15 seconds only if toggle ON
    setInterval(() => {
      if (voiceEnabled) playWelcomeVoice();
    }, 15000);
  });
</script>

</body>
</html>
