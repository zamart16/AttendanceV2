<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BAC Meeting Attendance Form</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">

    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#3B82F6',
              secondary: '#1E40AF'
            },
            borderRadius: {
              'none': '0px',
              'sm': '4px',
              DEFAULT: '8px',
              'md': '12px',
              'lg': '16px',
              'xl': '20px',
              '2xl': '24px',
              '3xl': '32px',
              'full': '9999px',
              'button': '8px'
            },
            fontFamily: {
              'inter': ['Inter', 'sans-serif']
            }
          }
        }
      }
    </script>
    <style>
      :where([class^="ri-"])::before {
        content: "\f3c2";
      }

      .glass-morphism {
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1),
          0 0 0 1px rgba(255, 255, 255, 0.2) inset;
      }

      .floating-label {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        font-weight: 500;
      }

      .floating-label.active {
        transform: translateY(-1.8rem) scale(0.85);
        color: #3B82F6;
        font-weight: 600;
        background: linear-gradient(to right, rgba(249, 250, 251, 0.95), rgba(255, 255, 255, 0.95), rgba(249, 250, 251, 0.95));
        padding: 0 8px;
        border-radius: 4px;
        margin-left: -8px;
        backdrop-filter: blur(10px);
      }

      .ripple {
        position: relative;
        overflow: hidden;
      }

      .ripple::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: translate(-50%, -50%);
        transition: width 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), height 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      }

      .ripple:active::before {
        width: 400px;
        height: 400px;
      }

      .fade-in {
        animation: fadeIn 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      }

      .slide-up {
        animation: slideUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes slideUp {
        from {
          opacity: 0;
          transform: translateY(50px) scale(0.95);
        }

        to {
          opacity: 1;
          transform: translateY(0) scale(1);
        }
      }

      .pulse-border {
        animation: pulseBorder 3s infinite ease-in-out;
      }

      @keyframes pulseBorder {

        0%,
        100% {
          border-color: #3B82F6;
          box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        50% {
          border-color: #60A5FA;
          box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        }
      }

      .camera-preview {
        border: 3px dashed #E5E7EB;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        background: rgba(249, 250, 251, 0.8);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
      }

      .camera-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 50%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
      }

      .camera-preview.active {
        border-color: #3B82F6;
        background: rgba(59, 130, 246, 0.08);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.1),
          0 10px 25px -5px rgba(59, 130, 246, 0.1);
      }

      .camera-preview.active::before {
        opacity: 1;
      }

      .enhanced-input {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(229, 231, 235, 0.8);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
      }

      .enhanced-input:focus {
        border-color: #3B82F6;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1),
          0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
      }

      .enhanced-button {
        background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
        box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4),
          0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
      }

      .enhanced-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
      }

      .enhanced-button:hover::before {
        left: 100%;
      }

      .enhanced-button:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 15px 30px -5px rgba(59, 130, 246, 0.5),
          0 0 0 1px rgba(255, 255, 255, 0.2) inset;
      }

      .enhanced-button:active {
        transform: translateY(0) scale(0.98);
      }

      .time-display {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(30, 64, 175, 0.05) 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
        backdrop-filter: blur(10px);
      }

      .notification {
        backdrop-filter: blur(20px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
          0 10px 10px -5px rgba(0, 0, 0, 0.04);
      }

      @media (max-width: 640px) {
        .camera-preview {
          border: 2px dashed #E5E7EB;
        }

        .glass-morphism {
          backdrop-filter: blur(15px);
        }
      }

      .mobile-touch {
        -webkit-tap-highlight-color: transparent;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        user-select: none;
      }

      video {
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      }

      .captured-photo {
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      }

      .header-gradient {
        background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 50%, #1E3A8A 100%);
        position: relative;
        overflow: hidden;
      }

      .header-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite;
      }

      @keyframes shimmer {
        0% {
          transform: translateX(-100%);
        }

        100% {
          transform: translateX(100%);
        }
      }
    </style>
  </head>

  <body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 font-inter">
    <div class="min-h-screen flex flex-col">
      <header class="fade-in header-gradient text-white py-12 px-4 shadow-2xl relative overflow-hidden">
        <div class="max-w-4xl mx-auto text-center relative z-10">
          <div class="mb-4">
            <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
              <i class="ri-file-list-3-fill text-2xl text-white"></i>
            </div>
          </div>
          <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">BAC - MEETING and ISO</h1>
          <p class="text-xl text-blue-50 font-medium">Professional Attendance Registration System</p>
          <div class="mt-6 flex items-center justify-center space-x-4">
            <div class="h-1 w-12 bg-gradient-to-r from-transparent via-white/60 to-transparent rounded-full"></div>
            <div class="w-2 h-2 bg-white/60 rounded-full"></div>
            <div class="h-1 w-12 bg-gradient-to-r from-transparent via-white/60 to-transparent rounded-full"></div>
          </div>
        </div>
      </header>
      <main class="flex-1 py-12 px-4">
        <div class="max-w-2xl mx-auto">
          <div class="slide-up glass-morphism rounded-3xl p-8 shadow-2xl">
            <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
            @csrf
              <input type="hidden" name="photo" id="photo_input">
              <input type="hidden" name="type_attendee" id="type_attendee_input">
              <div class="space-y-6">
                <div class="relative group">
                  <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                    <i class="ri-user-line text-lg text-gray-400 group-focus-within:text-primary transition-colors duration-300"></i>
                  </div>
                  <input type="text" id="fullName" name="fullName" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                  <label for="fullName" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">
                    Full Name
                  </label>
                </div>

                <div class="relative group">
                  <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                    <i class="ri-briefcase-line text-lg text-gray-400 group-focus-within:text-primary transition-colors duration-300"></i>
                  </div>
                  <input type="text" id="position" name="position" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                  <label for="position" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">
                    Position/Title
                  </label>
                </div>
                <div class="relative">
                  <div class="relative">
                    <button type="button" id="attendeeTypeBtn" name="type_attendee" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-all duration-300 text-lg bg-white/80 backdrop-blur-sm text-left flex items-center justify-between">
                      <span id="selectedType" class="text-gray-500">Select Attendee Type</span>
                      <div class="w-6 h-6 flex items-center justify-center">
                        <i class="ri-arrow-down-s-line text-xl transition-transform duration-300" id="dropdownIcon"></i>
                      </div>
                    </button>
                    <div id="attendeeDropdown" class="absolute top-full left-0 right-0 mt-2 bg-white/95 backdrop-blur-sm border-2 border-gray-200 rounded-xl shadow-lg opacity-0 invisible transition-all duration-300 z-50">
                      <div class="py-2">
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="BAC Member">BAC Member</button>
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="BAC-TWG">BAC-TWG</button>
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="Observers">Observers</button>
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="End-User of the Province">End-User of the Province</button>
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="Supplier/Bidders">Supplier/Bidders</button>
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="BAC-SEC(GOODS)">BAC-SEC(GOODS)</button>
                        <button name="type_attendee" type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="BAC-SEC(INFRA)">BAC-SEC(INFRA)</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="relative group">
                  <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                    <i class="ri-phone-line text-lg text-gray-400 group-focus-within:text-primary transition-colors duration-300"></i>
                  </div>
                  <input type="text" name="phone_number" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                  <label for="Pnumber" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">
                    Phone Number
                  </label>
                </div>

                <div class="relative group">
                  <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                    <i class="ri-file-list-line text-lg text-gray-400 group-focus-within:text-primary transition-colors duration-300"></i>
                  </div>
                  <input type="text" id="purpose" name="purpose" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                  <label for="purpose" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">
                    Purpose
                  </label>
                </div>

                <div id="companySection" class="hidden space-y-6">
                  <div class="relative group">
                    <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                      <i class="ri-building-line text-lg text-gray-400"></i>
                    </div>
                    <input type="text" id="company" name="company" class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                    <label class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">
                      Company
                    </label>
                  </div>

                  <div class="relative group">
                    <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                      <i class="ri-map-pin-line text-lg text-gray-400"></i>
                    </div>
                    <input type="text" id="address" name="address" class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                    <label class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">
                      Address
                    </label>
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="relative group">
                    <div class="absolute left-3 top-3 w-6 h-6 flex items-center justify-center pointer-events-none z-10">
                      <i class="ri-calendar-line text-lg text-gray-400 group-focus-within:text-primary transition-colors duration-300"></i>
                    </div>
                    <input type="date" id="attendanceDate" name="attendance_date" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                    <div class="absolute right-4 top-4 w-6 h-6 flex items-center justify-center pointer-events-none">
                      <i class="ri-calendar-event-line text-lg text-gray-400"></i>
                    </div>
                  </div>
                  <div class="relative">
                    <div class="time-display w-full px-6 py-4 rounded-2xl flex items-center justify-between">
                      <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary/20 to-secondary/10 rounded-full flex items-center justify-center">
                          <i class="ri-time-line text-lg text-primary"></i>
                        </div>
                        <span class="text-lg font-semibold text-gray-700">Current Time</span>
                      </div>
                      <div class="flex items-center space-x-2">
                        <span id="currentTime" class="text-xl font-mono text-primary font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="space-y-4">
                  <h3 class="text-xl font-semibold text-gray-800">Photo Capture</h3>
                  <div class="camera-preview rounded-xl p-4 sm:p-6 md:p-8 text-center min-h-[250px] sm:min-h-[300px] flex flex-col items-center justify-center space-y-4">
                    <video id="cameraPreview" class="hidden w-full max-w-sm sm:max-w-md rounded-xl shadow-lg aspect-[4/3] object-cover bg-gray-100"></video>
                    <canvas id="photoCanvas" class="hidden"></canvas>
                    <img id="capturedPhoto" class="hidden w-full max-w-sm sm:max-w-md rounded-xl shadow-lg aspect-[4/3] object-cover">
                    <div id="cameraPlaceholder" class="flex flex-col items-center space-y-4">
                      <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex items-center justify-center bg-gray-100 rounded-full">
                        <i class="ri-camera-line text-2xl sm:text-3xl md:text-4xl text-gray-400"></i>
                      </div>
                      <p class="text-gray-500 text-base sm:text-lg px-4 text-center">Tap to start camera and capture your photo</p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full max-w-sm">
                      <button type="button" id="startCameraBtn" class="ripple flex-1 px-4 py-3 bg-primary text-white rounded-button font-semibold hover:bg-secondary active:scale-95 transition-all duration-300 whitespace-nowrap flex items-center justify-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                          <i class="ri-camera-line text-lg"></i>
                        </div>
                        <span class="text-sm sm:text-base">Start Camera</span>
                      </button>
                      <button type="button" id="captureBtn" class="ripple flex-1 px-4 py-3 bg-green-500 text-white rounded-button font-semibold hover:bg-green-600 active:scale-95 transition-all duration-300 whitespace-nowrap hidden flex items-center justify-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                          <i class="ri-camera-fill text-lg"></i>
                        </div>
                        <span class="text-sm sm:text-base">Capture Photo</span>
                      </button>
                      <button type="button" id="retakeBtn" class="ripple flex-1 px-4 py-3 bg-orange-500 text-white rounded-button font-semibold hover:bg-orange-600 active:scale-95 transition-all duration-300 whitespace-nowrap hidden flex items-center justify-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                          <i class="ri-refresh-line text-lg"></i>
                        </div>
                        <span class="text-sm sm:text-base">Retake</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>


              <br>

              <button type="submit" class="enhanced-button w-full py-5 text-white text-xl font-bold rounded-2xl whitespace-nowrap relative overflow-hidden">
                <div id="submitText" class="flex items-center justify-center space-x-3 relative z-10">
                  <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-send-plane-fill text-xl"></i>
                  </div>
                  <span class="font-semibold">Submit Attendance</span>
                </div>
                <div id="submitLoader" class="hidden flex items-center justify-center space-x-3 relative z-10">
                  <div class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                  <span class="font-semibold">Processing...</span>
                </div>
              </button>
            </form>
          </div>
        </div>
      </main>
    </div>



<script>
document.addEventListener('DOMContentLoaded', function() {

  // --- FLOATING LABELS ---
  const inputs = document.querySelectorAll('input[type="text"], input[type="date"], input[type="time"], input[type="hidden"]');
  inputs.forEach(input => {
    const label = input.nextElementSibling;
    function updateLabel() {
      if (input.value || input === document.activeElement) {
        label?.classList.add('active');
      } else {
        label?.classList.remove('active');
      }
    }
    input.addEventListener('focus', updateLabel);
    input.addEventListener('blur', updateLabel);
    input.addEventListener('input', updateLabel);
    updateLabel();
  });

  // --- ATTENDEE TYPE DROPDOWN ---
  const attendeeTypeBtn = document.getElementById('attendeeTypeBtn');
  const attendeeDropdown = document.getElementById('attendeeDropdown');
  const selectedType = document.getElementById('selectedType');
  const dropdownIcon = document.getElementById('dropdownIcon');
  const attendeeOptions = document.querySelectorAll('.attendee-option');
  const hiddenTypeInput = document.getElementById('type_attendee_input'); // Hidden input
  let isOpen = false;

  attendeeTypeBtn.addEventListener('click', function() {
    isOpen = !isOpen;
    attendeeDropdown.classList.toggle('opacity-0', !isOpen);
    attendeeDropdown.classList.toggle('invisible', !isOpen);
    attendeeDropdown.classList.toggle('opacity-100', isOpen);
    attendeeDropdown.classList.toggle('visible', isOpen);
    dropdownIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
  });

  attendeeOptions.forEach(option => {
    option.addEventListener('click', function() {
      const value = this.dataset.value;
      selectedType.textContent = value;
      selectedType.classList.remove('text-gray-500');
      selectedType.classList.add('text-gray-800');
      hiddenTypeInput.value = value;

      attendeeDropdown.classList.add('opacity-0', 'invisible');
      attendeeDropdown.classList.remove('opacity-100', 'visible');
      dropdownIcon.style.transform = 'rotate(0deg)';
      isOpen = false;

      // Show company section if needed
      const companySection = document.getElementById('companySection');
      if (value === 'Observers' || value === 'Supplier/Bidders') {
        companySection.classList.remove('hidden');
        document.getElementById('company').required = true;
        document.getElementById('address').required = true;
      } else {
        companySection.classList.add('hidden');
        document.getElementById('company').required = false;
        document.getElementById('address').required = false;
      }
    });
  });

  document.addEventListener('click', function(e) {
    if (!attendeeTypeBtn.contains(e.target) && !attendeeDropdown.contains(e.target)) {
      attendeeDropdown.classList.add('opacity-0', 'invisible');
      attendeeDropdown.classList.remove('opacity-100', 'visible');
      dropdownIcon.style.transform = 'rotate(0deg)';
      isOpen = false;
    }
  });

  // --- REAL-TIME CLOCK ---
  const currentTimeElement = document.getElementById('currentTime');
  function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
      hour12: true,
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    });
    currentTimeElement.textContent = timeString;
  }
  updateTime();
  setInterval(updateTime, 1000);

  // --- CAMERA FUNCTIONALITY ---
  const startCameraBtn = document.getElementById('startCameraBtn');
  const captureBtn = document.getElementById('captureBtn');
  const retakeBtn = document.getElementById('retakeBtn');
  const cameraPreview = document.getElementById('cameraPreview');
  const photoCanvas = document.getElementById('photoCanvas');
  const capturedPhoto = document.getElementById('capturedPhoto');
  const cameraPlaceholder = document.getElementById('cameraPlaceholder');
  const cameraContainer = document.querySelector('.camera-preview');
  const photoInput = document.getElementById('photo_input'); // Hidden input
  let stream = null;

  const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  document.body.classList.add('mobile-touch');

  startCameraBtn.addEventListener('click', async function() {
    try {
      const constraints = { video: { width: { ideal: isMobile ? 480 : 640 }, height: { ideal: isMobile ? 360 : 480 }, facingMode: 'user' } };
      try { stream = await navigator.mediaDevices.getUserMedia(constraints); }
      catch (err) { stream = await navigator.mediaDevices.getUserMedia({ video: { width: { ideal: isMobile ? 480 : 640 }, height: { ideal: isMobile ? 360 : 480 } } }); }

      cameraPreview.srcObject = stream;
      await cameraPreview.play();
      cameraPlaceholder.classList.add('hidden');
      cameraPreview.classList.remove('hidden');
      startCameraBtn.classList.add('hidden');
      captureBtn.classList.remove('hidden');
      cameraContainer.classList.add('active');
    } catch (error) {
      alert('Unable to access camera. Check permissions or device.');
    }
  });

  captureBtn.addEventListener('click', function() {
    const canvas = photoCanvas;
    const ctx = canvas.getContext('2d');
    const videoWidth = cameraPreview.videoWidth;
    const videoHeight = cameraPreview.videoHeight;
    canvas.width = videoWidth;
    canvas.height = videoHeight;
    ctx.scale(-1, 1);
    ctx.drawImage(cameraPreview, -videoWidth, 0, videoWidth, videoHeight);
    ctx.scale(-1, 1);

    capturedPhoto.src = canvas.toDataURL('image/jpeg', 0.85);
    capturedPhoto.classList.add('captured-photo');
    cameraPreview.classList.add('hidden');
    capturedPhoto.classList.remove('hidden');
    captureBtn.classList.add('hidden');
    retakeBtn.classList.remove('hidden');
    if (stream) stream.getTracks().forEach(track => track.stop());

    photoInput.value = capturedPhoto.src; // Set hidden input
  });

  retakeBtn.addEventListener('click', function() {
    capturedPhoto.src = '';
    capturedPhoto.classList.add('hidden');
    capturedPhoto.classList.remove('captured-photo');
    cameraPlaceholder.classList.remove('hidden');
    retakeBtn.classList.add('hidden');
    startCameraBtn.classList.remove('hidden');
    cameraContainer.classList.remove('active');
    photoInput.value = ''; // Clear hidden input
  });

  // --- INITIALIZE DATE TO TODAY ---
  // const dateInput = document.getElementById('attendanceDate');
  // if (dateInput) {
  //   dateInput.value = new Date().toISOString().split('T')[0];
  // }
    const dateInput = document.getElementById('attendanceDate');
if (dateInput) {
  const today = new Date();
  const localDate = today.getFullYear() + '-' +
    String(today.getMonth() + 1).padStart(2, '0') + '-' +
    String(today.getDate()).padStart(2, '0');

  dateInput.value = localDate;
}


});
</script>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('attendanceForm');
  const submitText = document.getElementById('submitText');
  const submitLoader = document.getElementById('submitLoader');
  const capturedPhoto = document.getElementById('capturedPhoto');
  const selectedTypeElem = document.getElementById('selectedType');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Basic validation
    if (
      !form.fullName.value ||
      !form.position.value ||
      selectedTypeElem.textContent.trim() === 'Select Attendee Type' ||
      !form.phone_number.value ||
      !form.attendance_date.value
    ) {
      Swal.fire('Oops!', 'Please fill in all required fields.', 'warning');
      return;
    }

    if (!capturedPhoto.src) {
      Swal.fire('Oops!', 'Please capture your photo!', 'warning');
      return;
    }

    submitText.classList.add('hidden');
    submitLoader.classList.remove('hidden');

    try {
      const formData = new FormData(form);
      formData.set('type_attendee', selectedTypeElem.textContent.trim());
      formData.set('photo', capturedPhoto.src);
      formData.set(
        'attendance_time',
        new Date().toLocaleTimeString('en-GB')
      );

      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content'),
          'Accept': 'application/json'
        }
      });

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.error || 'Server error');
      }

      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Attendance submitted successfully!',
        timer: 2000,
        showConfirmButton: false
      });

      form.reset();
      selectedTypeElem.textContent = 'Select Attendee Type';
      capturedPhoto.src = '';
      capturedPhoto.classList.add('hidden');

    } catch (err) {
      console.error(err);
      Swal.fire('Error!', err.message, 'error');
    } finally {
      submitText.classList.remove('hidden');
      submitLoader.classList.add('hidden');
    }
  });
});
</script>










  </body>

</html>
