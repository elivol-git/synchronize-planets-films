<footer class="app-footer">
    <div>
Last updated:
{{ $lastUpdated?->format('d M Y H:i') ?? '—' }}
</div>

<div>
    © {{ now()->year }} All rights reserved
</div>
</footer>
