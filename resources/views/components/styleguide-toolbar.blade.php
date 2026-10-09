<div id="styleguide-toolbar" class="fixed bottom-0 inset-x-0 z-50 bg-gray-900/95 text-white shadow-2xl border-t border-gray-700 py-2.5 px-4 print:hidden backdrop-blur-sm">
    <div class="max-w-7xl mx-auto flex gap-4">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gold text-green-900 uppercase tracking-wide">
                Styleguide
            </span>
            <label for="styleguide-site-select" class="text-sm font-medium text-gray-200">
                Site Theme:
            </label>
        </div>

        <div class="flex items-center gap-2">
            <select id="styleguide-site-select" class="bg-gray-800 text-white border border-gray-600 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold focus:border-gold">
                <option value="">Default (Base)</option>
                @foreach($base['styleguide_sites'] as $slug => $label)
                    <option value="{{ $slug }}" @selected(($base['styleguide_selected_site'] ?? '') === $slug)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<script>
(function() {
    var select = document.getElementById('styleguide-site-select');
    if (!select) return;

    var storageKey = 'styleguide_app';
    var url = new URL(window.location.href);
    var urlApp = url.searchParams.get('app');

    if (urlApp) {
        localStorage.setItem(storageKey, urlApp);
        document.cookie = storageKey + '=' + encodeURIComponent(urlApp) + '; path=/; max-age=2592000; SameSite=Lax';
    } else {
        var stored = localStorage.getItem(storageKey);
        var currentServer = '{{ $base['styleguide_selected_site'] ?? '' }}';
        if (stored && stored !== currentServer) {
            document.cookie = storageKey + '=' + encodeURIComponent(stored) + '; path=/; max-age=2592000; SameSite=Lax';
            url.searchParams.set('app', stored);
            window.location.href = url.toString();
            return;
        }
    }

    select.addEventListener('change', function(e) {
        var value = e.target.value;
        var nextUrl = new URL(window.location.href);

        if (value) {
            localStorage.setItem(storageKey, value);
            document.cookie = storageKey + '=' + encodeURIComponent(value) + '; path=/; max-age=2592000; SameSite=Lax';
            nextUrl.searchParams.set('app', value);
        } else {
            localStorage.removeItem(storageKey);
            document.cookie = storageKey + '=; path=/; max-age=0; SameSite=Lax';
            nextUrl.searchParams.delete('app');
        }

        window.location.href = nextUrl.toString();
    });
})();
</script>
