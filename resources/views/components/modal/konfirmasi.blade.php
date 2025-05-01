@props([
    'id' => 'modalKonfirmasi',
    'title' => 'Apakah Anda yakin?',
    'body' => 'Tindakan ini tidak dapat dibatalkan.',
    'btnLabel' => 'Ya, Lanjutkan',
    'btnColor' => 'primary',
    'formAction' => '#',
    'method' => 'POST',
])

<div class="modal modal-blur fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-{{ $btnColor }}"></div>
            <div class="modal-body text-center py-4">
                <!-- Ikon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-{{ $btnColor }} icon-lg"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 9v2m0 4v.01" />
                    <path
                        d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                </svg>

                <h3>{{ $title }}</h3>
                <div class="text-secondary">
                    {!! $body !!}
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn w-100" data-bs-dismiss="modal">Batal</button>
                        </div>
                        <div class="col">
                            <form method="POST" action="{{ $formAction }}">
                                @csrf
                                @method($method)

                                {{-- SLOT untuk field tambahan --}}
                                {{ $slot }}

                                <button type="submit" class="btn btn-{{ $btnColor }} w-100">
                                    {{ $btnLabel }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
