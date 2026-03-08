function Logout() {
    var thisPage = window.location.href;
    var isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    var authBase = isLocal
        ? window.location.protocol + '//' + window.location.host + '/web_auth/public'
        : 'https://auth.andrewcromar.org';
    window.location.href = authBase + '/pages/logout.html?redirect=' + encodeURIComponent(thisPage);
}
