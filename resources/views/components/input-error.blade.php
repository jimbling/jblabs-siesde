@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'alert alert-danger alert-dismissible fade show']) }} role="alert">
        <div class="d-flex align-items-center">
            <span class="me-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
            </span>
            <div class="flex-grow-1">
                @if (count((array) $messages) > 1)
                    <ul class="mb-0 ps-3">
                        @foreach ((array) $messages as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @else
                    {{ $messages[0] }}
                @endif
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi fungsi dismiss alert
                document.querySelectorAll('.alert-dismissible .btn-close').forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.alert').remove();
                    });
                });
            });
        </script>
    @endpush
@endif
