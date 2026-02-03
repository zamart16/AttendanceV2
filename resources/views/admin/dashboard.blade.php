<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Management System</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#10b981'
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
                    }
                }
            }
        }
    </script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen">
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <i class="ri-admin-line text-primary text-xl"></i>
                        </div>
                        <h1 class="text-xl font-semibold text-gray-900">Attendance Management System</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-secondary rounded-full"></div>
                            <span class="text-sm text-gray-600">Admin Panel</span>
                        </div>
                        <button class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition-colors !rounded-button whitespace-nowrap">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-logout-box-line"></i>
                            </div>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Attendance Control Panel</h2>
                <p class="text-gray-600">Manage attendance options and view submission records</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
     data-controller-id="{{ $controller->id }}">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-lg">
                <i class="ri-group-line text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">BAC Meeting</h3>
                <p class="text-sm text-gray-500">Board Advisory Committee</p>
            </div>
        </div>

        <!-- TOGGLE -->
        <label class="relative inline-flex items-center cursor-pointer">
            <input
                type="checkbox"
                class="sr-only peer controller-toggle"
                data-id="{{ $controller->id }}"
                {{ $controller->status === 'active' ? 'checked' : '' }}
            >
            <div class="w-11 h-6 bg-gray-200 rounded-full peer
                peer-checked:after:translate-x-full
                peer-checked:after:border-white
                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                peer-checked:bg-primary">
            </div>
        </label>
    </div>

    <!-- STATUS -->
    <div class="mb-4">
        <div class="flex items-center space-x-2 mb-2 status-wrapper">
            <div class="w-3 h-3 rounded-full
                {{ $controller->status === 'active' ? 'bg-secondary' : 'bg-red-500' }}">
            </div>
            <span class="text-sm font-medium
                {{ $controller->status === 'active' ? 'text-secondary' : 'text-red-600' }}">
                {{ ucfirst($controller->status) }}
            </span>
        </div>

        <div class="text-sm {{ $controller->status === 'active' ? 'text-gray-600' : 'text-gray-400' }}">
            <p>Today's Submissions: <span class="font-medium">24</span></p>
            <p>Last Entry: 2 minutes ago</p>
        </div>
    </div>

    <button
        class="w-full px-4 py-2 text-sm font-medium transition-colors !rounded-button whitespace-nowrap
        {{ $controller->status === 'active'
            ? 'bg-gray-100 hover:bg-gray-200 text-gray-700'
            : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}"
        {{ $controller->status !== 'active' ? 'disabled' : '' }}>
        View Records
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.controller-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('change', async function () {
            const controllerId = this.dataset.id;
            const status = this.checked ? 'active' : 'disabled';

            const card = this.closest('[data-controller-id]');
            const dot = card.querySelector('.status-wrapper div');
            const text = card.querySelector('.status-wrapper span');
            const details = card.querySelector('.mb-4 > div.text-sm');
            const button = card.querySelector('button');

            // Update UI immediately
            if (status === 'active') {
                dot.className = 'w-3 h-3 rounded-full bg-secondary';
                text.className = 'text-sm font-medium text-secondary';
                text.textContent = 'Active';
                details.className = 'text-sm text-gray-600';
                button.disabled = false;
                button.className = 'w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors !rounded-button whitespace-nowrap';
            } else {
                dot.className = 'w-3 h-3 rounded-full bg-red-500';
                text.className = 'text-sm font-medium text-red-600';
                text.textContent = 'Disabled';
                details.className = 'text-sm text-gray-400';
                button.disabled = true;
                button.className = 'w-full px-4 py-2 bg-gray-200 text-gray-400 text-sm font-medium cursor-not-allowed !rounded-button whitespace-nowrap';
            }

            // Update BAC attendances via AJAX
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(`/admin/controllers/${controllerId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });
                const result = await res.json();
                if (!result.success) alert('Failed to update controller_id in attendances');
            } catch (err) {
                console.error(err);
                alert('Server error');
            }
        });
    });
});
</script>



                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-lg">
                                <i class="ri-briefcase-line text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">PMO Attendance</h3>
                                <p class="text-sm text-gray-500">Project Management Office</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" id="pmo-toggle">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm font-medium text-red-600">Disabled</span>
                        </div>
                        <div class="text-sm text-gray-400">
                            <p>Today's Submissions: <span class="font-medium">0</span></p>
                            <p>Last Entry: 3 days ago</p>
                        </div>
                    </div>
                    <button class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors !rounded-button whitespace-nowrap">
                        View Records
                    </button>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-orange-100 rounded-lg">
                                <i class="ri-feedback-line text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Feedback Entry</h3>
                                <p class="text-sm text-gray-500">Employee Feedback System</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" id="feedback-toggle" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-3 h-3 bg-secondary rounded-full"></div>
                            <span class="text-sm font-medium text-secondary">Active</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Today's Submissions: <span class="font-medium">18</span></p>
                            <p>Last Entry: 15 minutes ago</p>
                        </div>
                    </div>
                    <button class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors !rounded-button whitespace-nowrap">
                        View Records
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-primary/10 rounded-lg">
                            <i class="ri-bar-chart-line text-primary"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Active Systems</h3>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">2</div>
                    <p class="text-sm text-gray-600">out of 3 attendance types</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-secondary/10 rounded-lg">
                            <i class="ri-user-check-line text-secondary"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Today's Total</h3>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">42</div>
                    <p class="text-sm text-gray-600">attendance submissions</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-orange-100 rounded-lg">
                            <i class="ri-time-line text-orange-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Last Activity</h3>
                    </div>
                    <div class="text-lg font-semibold text-gray-900 mb-1">2 min ago</div>
                    <p class="text-sm text-gray-600">BAC Meeting entry</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                    <button class="text-sm text-primary hover:text-primary/80 font-medium">View All</button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full">
                            <i class="ri-user-line text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Sarah Johnson submitted BAC Meeting attendance</p>
                            <p class="text-xs text-gray-500">2 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 flex items-center justify-center bg-orange-100 rounded-full">
                            <i class="ri-user-line text-orange-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Michael Chen completed Feedback Entry</p>
                            <p class="text-xs text-gray-500">15 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full">
                            <i class="ri-user-line text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Emily Rodriguez attended BAC Meeting</p>
                            <p class="text-xs text-gray-500">28 minutes ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button class="flex items-center justify-center space-x-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white font-medium transition-colors !rounded-button whitespace-nowrap">
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-file-list-line"></i>
                    </div>
                    <span>View All Records</span>
                </button>
                <button class="flex items-center justify-center space-x-2 px-6 py-3 bg-secondary hover:bg-secondary/90 text-white font-medium transition-colors !rounded-button whitespace-nowrap">
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-download-line"></i>
                    </div>
                    <span>Export Data</span>
                </button>
                <button class="flex items-center justify-center space-x-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition-colors !rounded-button whitespace-nowrap">
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-settings-line"></i>
                    </div>
                    <span>System Settings</span>
                </button>
            </div>
        </main>
    </div>

{{-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.controller-toggle');

    function updateStats() {
        const activeCount = document.querySelectorAll('.controller-toggle:checked').length;
        const stat = document.querySelector('.text-3xl.font-bold.text-gray-900');
        if (stat) stat.textContent = activeCount;
    }

    toggles.forEach(toggle => {
        toggle.addEventListener('change', async function () {
            const controllerId = this.dataset.id;
            const status = this.checked ? 'active' : 'disabled';

            const card = this.closest('[data-controller-id]');
            const statusWrapper = card.querySelector('.status-wrapper');
            const dot = statusWrapper.querySelector('div');
            const text = statusWrapper.querySelector('span');
            const details = card.querySelector('.mb-4 > div.text-sm');
            const button = card.querySelector('button');

            // Update UI immediately
            if (status === 'active') {
                dot.className = 'w-3 h-3 rounded-full bg-secondary';
                text.className = 'text-sm font-medium text-secondary';
                text.textContent = 'Active';
                details.className = 'text-sm text-gray-600';
                button.disabled = false;
                button.className = 'w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors !rounded-button whitespace-nowrap';
            } else {
                dot.className = 'w-3 h-3 rounded-full bg-red-500';
                text.className = 'text-sm font-medium text-red-600';
                text.textContent = 'Disabled';
                details.className = 'text-sm text-gray-400';
                button.disabled = true;
                button.className = 'w-full px-4 py-2 bg-gray-200 text-gray-400 text-sm font-medium cursor-not-allowed !rounded-button whitespace-nowrap';
            }

            updateStats();

            // Send AJAX request to server
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const response = await fetch(`/admin/controllers/${controllerId}/toggle`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ status })
});
                const result = await response.json();
                if (!result.success) {
                    alert('Failed to update controller status');
                }
            } catch (err) {
                console.error(err);
                alert('Server error');
            }
        });
    });

    updateStats();
});
</script> --}}




    <script id="stats-update">
        document.addEventListener('DOMContentLoaded', function() {
            function updateStats() {
                const activeToggles = document.querySelectorAll('input[type="checkbox"]:checked');
                const activeCount = activeToggles.length;
                const activeStatsElement = document.querySelector('.text-3xl.font-bold.text-gray-900');

                if (activeStatsElement) {
                    activeStatsElement.textContent = activeCount;
                }
            }

            const toggles = document.querySelectorAll('input[type="checkbox"]');
            toggles.forEach(toggle => {
                toggle.addEventListener('change', updateStats);
            });
        });
    </script>


</body>
</html>
