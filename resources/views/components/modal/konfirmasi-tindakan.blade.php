@props([
    'id' => 'konfirmasiModal',
    'title' => 'Konfirmasi',
    'body' => 'Apakah Anda yakin?',
    'confirmLabel' => 'Lanjutkan',
    'confirmColor' => 'success',
    'cancelLabel' => 'Batal',
    'onConfirm' => null, // JS function or action ID
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                {!! $body !!}
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ $cancelLabel }}
                </button>
                <button type="button" class="btn btn-{{ $confirmColor }}"
                    @if ($onConfirm) onclick="{{ $onConfirm }}" @endif>
                    {{ $confirmLabel }}
                </button>
            </div>
        </div>
    </div>
</div>
