// function to set a cookie that will remember if dark mode is toggled
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

// function to get cookie value
function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (let cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split('=');
        if (cookieName === name) {
            return cookieValue;
        }
    }
    return null;
}

// initialize isDarkMode based on the stored value in the cookie
let isDarkMode = getCookie('darkMode') === 'on';

function darkDarkMode() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const bod = document.body;

    // Toggle the theme class
    bod.dataset.bsTheme = isDarkMode ? 'light' : 'dark';

    if (isDarkMode) {
        darkModeToggle.textContent = "Dark Mode";
    } else {
        darkModeToggle.textContent = "Light Mode";
    }

    // Toggle isDarkMode and update the cookie
    isDarkMode = !isDarkMode;
    setCookie('darkMode', isDarkMode ? 'on' : 'off', 7); // Set the cookie to expire after 7 days
}