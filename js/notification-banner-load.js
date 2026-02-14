/**
 * Load "What's New" section on static HTML pages (same structure/CSS as course page).
 * Data from php/api/notifications.php. Injects ticker with notification items.
 */
(function() {
    var placeholder = document.getElementById('notification-banner-placeholder');
    if (!placeholder) return;

    var apiUrl = (document.currentScript && document.currentScript.getAttribute('data-api')) || 'php/api/notifications.php';

    var css = '#notification-banner-placeholder{overflow:visible;min-height:0;margin-top:12px;margin-bottom:0}.whats-new-section{background:white;padding:8px 0;border-bottom:1px solid #e5e7eb;overflow:hidden;position:relative}.whats-new-header{display:flex;align-items:center;gap:15px;margin-bottom:6px;flex-wrap:wrap}.whats-new-header h2{font-size:16px;font-weight:700;color:#1a1a2e;margin:0;white-space:nowrap}.whats-new-view-all{color:#0ea5e9;font-weight:600;font-size:14px;text-decoration:none}.whats-new-view-all:hover{text-decoration:underline}.whats-new-ticker{display:flex;gap:30px;animation:scrollTicker 30s linear infinite;width:max-content}.whats-new-ticker:hover{animation-play-state:paused}@keyframes scrollTicker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}.update-item{display:inline-flex;align-items:center;gap:15px;padding:8px 15px;background:#f8f9fa;border-radius:6px;border-left:3px solid #0ea5e9;white-space:nowrap;min-width:max-content}.update-item h3{font-size:13px;font-weight:600;color:#1a1a2e;margin:0}.update-item h3 a{color:#1a1a2e;text-decoration:none;transition:color .2s}.update-item h3 a:hover{color:#0ea5e9}.update-meta{font-size:11px;color:#666;display:flex;gap:10px;align-items:center}.update-author{font-weight:500}.update-date{color:#999}@media (max-width:768px){#notification-banner-placeholder{margin-top:12px}.whats-new-section{padding:8px 0}.whats-new-header h2{font-size:14px}.whats-new-ticker{animation-duration:20s}.update-item{padding:6px 12px}}';
    var style = document.createElement('style');
    style.textContent = css;
    document.head.appendChild(style);

    function esc(s) {
        if (s == null) return '';
        var d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    function formatDate(publishedAt) {
        if (!publishedAt) return '';
        try {
            var d = new Date(publishedAt);
            var m = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][d.getMonth()];
            return m + ' ' + d.getDate() + ', ' + d.getFullYear();
        } catch (e) { return publishedAt; }
    }

    function buildUpdateItem(item) {
        var title = esc(item.title || '');
        var linkUrl = (item.link_url && item.link_url !== '#') ? item.link_url : '#';
        var dateStr = formatDate(item.published_at);
        var meta = '<div class="update-meta"><span class="update-author">Eduspray</span>' + (dateStr ? '<span class="update-date">' + esc(dateStr) + '</span>' : '') + '</div>';
        return '<div class="update-item"><h3><a href="' + esc(linkUrl) + '" target="_blank" rel="noopener">' + title + '</a></h3>' + meta + '</div>';
    }

    fetch(apiUrl)
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (!res.success) return;
            var viewAll = (res.view_all_link && res.view_all_link !== '#') ? res.view_all_link : 'notifications.php';
            var items = res.data || [];
            var duplicated = items.length ? items.concat(items) : [];
            var itemsHtml = duplicated.length
                ? duplicated.map(buildUpdateItem).join('')
                : '<div class="update-item"><h3>No notifications at the moment. Check back later.</h3></div>';
            var viewAllLink = '<a href="' + esc(viewAll) + '" class="whats-new-view-all">View All</a>';
            var html = '<div class="whats-new-section"><div class="container"><div class="whats-new-header"><h2>What\'s New</h2>' + viewAllLink + '</div><div class="whats-new-ticker-wrapper" style="overflow:hidden"><div class="whats-new-ticker">' + itemsHtml + '</div></div></div></div>';
            placeholder.innerHTML = html;
        })
        .catch(function() { placeholder.innerHTML = ''; });
})();
