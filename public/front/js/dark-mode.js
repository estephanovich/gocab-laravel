let theme = localStorage.front_theme || '';

document.addEventListener('DOMContentLoaded', function () {
  // Detect initial theme
  if (localStorage.front_theme === 'dark' || (!('front_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    theme = 'dark';
    document.body.classList.add('dark');
    sessionStorage.setItem("front_theme_color", "dark");
  } else {
    theme = 'light';
    document.body.classList.remove('dark');
    sessionStorage.setItem("front_theme_color", "");
  }

  // Update button active states on load
  updateButtonStates();
});

/// Light Mode Function ///
const lightMode = function () {
  theme = 'light';
  document.body.classList.remove('dark');
  sessionStorage.setItem("front_theme_color", "");
  updateButtonStates();
  updateThemeInSession(theme);
};

/// Dark Mode Function ///
const darkMode = function () {
  theme = 'dark';
  document.body.classList.add('dark');
  sessionStorage.setItem("front_theme_color", "dark");
  updateButtonStates();
  updateThemeInSession(theme);
};

// Helper to add/remove 'active' class on buttons
function updateButtonStates() {
  const lightBtn = document.getElementById('light-mode');
  const darkBtn = document.getElementById('dark-mode');

  if (theme === 'dark') {
    darkBtn.classList.add('active');
    lightBtn.classList.remove('active');
  } else {
    lightBtn.classList.add('active');
    darkBtn.classList.remove('active');
  }
}

// Event listeners for separate buttons
document.getElementById('light-mode')?.addEventListener('click', lightMode);
document.getElementById('dark-mode')?.addEventListener('click', darkMode);

// Save to localStorage on page unload
window.addEventListener('beforeunload', function () {
  localStorage.front_theme = theme;
});

function updateThemeInSession(theme) {
  fetch('/set-theme', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ theme: theme })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log(data);
    } else {
      console.error('Failed to update theme in session');
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
