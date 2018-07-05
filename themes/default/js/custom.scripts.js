var pathname            =   window.location.pathname;

if (pathname.indexOf('/Security') != 0 && pathname.indexOf('/dev') != 0) {
    var target_url      =   '/!/#' + window.location.pathname;
    window.location.replace(target_url);
}
