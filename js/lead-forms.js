/**
 * Newsletter & lead forms: submit to save_lead API so no user details are lost.
 */
(function() {
    function handleNewsletterSubmit(e) {
        e.preventDefault();
        var form = e.target;
        var emailInput = form.querySelector('input[name="email"]') || form.querySelector('input[type="email"]') || form.querySelector('#email');
        if (!emailInput) return;
        var email = (emailInput.value || '').trim();
        if (!email) {
            alert('Please enter your email address.');
            return;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert('Please enter a valid email address.');
            return;
        }
        var btn = form.querySelector('button[type="submit"]');
        var btnOrig = btn ? btn.textContent : '';
        if (btn) { btn.disabled = true; btn.textContent = 'Sending...'; }
        fetch('php/api/save_lead.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: email, source: 'newsletter' })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                alert(data.message || 'Thank you for subscribing!');
                form.reset();
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(function() { alert('Request failed. Please try again.'); })
        .finally(function() {
            if (btn) { btn.disabled = false; btn.textContent = btnOrig; }
        });
    }
    document.querySelectorAll('.newsletter-form').forEach(function(f) {
        f.addEventListener('submit', handleNewsletterSubmit);
    });
})();
