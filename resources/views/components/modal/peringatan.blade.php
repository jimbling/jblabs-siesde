@props([
    'id' => 'modalPeringatan',
    'title' => 'Peringatan',
    'message' => 'Tidak ada data yang dipilih.',
    'icon' => 'warning',
    'statusColor' => 'bg-warning',
    'buttonColor' => 'btn-warning',
])

<div class="modal modal-blur fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status {{ $statusColor }}"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-{{ $icon }} icon-lg"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 9v2m0 4v.01" />
                    <path
                        d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                </svg>
                <h3>{{ $title }}</h3>
                <div class="text-secondary">
                    {{ $message }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn w-100 {{ $buttonColor }}" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
