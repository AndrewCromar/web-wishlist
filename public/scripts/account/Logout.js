function Logout() {
    var protocol = window.location.protocol + '//';
    var host = window.location.host;
    var thisPage = window.location.href;
    var authBase = protocol + host + '/web_auth/public';
    window.location.href = authBase + '/pages/logout.html?redirect=' + encodeURIComponent(thisPage);
}
