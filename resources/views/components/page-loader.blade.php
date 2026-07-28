@props([
    'message' => 'Preparing workspace',
    'theme' => 'emerald',
])

<div
    data-page-loader
    data-theme="{{ $theme }}"
    role="status"
    aria-live="polite"
    aria-label="{{ $message }}"
>
    <span class="page-loader__spinner" aria-hidden="true"></span>
</div>

@once
    <style>
        [data-page-loader] {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            color: #d1fae5;
            background: rgba(6, 41, 31, .96);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transition: opacity 180ms ease, visibility 0s linear 180ms;
        }
        [data-page-loader][aria-hidden="true"] {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .page-loader__spinner {
            width: 2.75rem;
            height: 2.75rem;
            border: 2px solid rgba(110, 231, 183, .28);
            border-top-color: #6ee7b7;
            border-radius: 50%;
            animation: page-loader-spin 900ms linear infinite;
        }
        [data-page-loader][data-theme="light"] {
            color: #064e3b;
            background: rgba(248, 250, 252, .97);
        }
        [data-page-loader][data-theme="light"] .page-loader__spinner {
            border-color: #d1fae5;
            border-top-color: #047857;
        }
        @keyframes page-loader-spin { to { transform: rotate(360deg); } }
        @media (prefers-reduced-motion: reduce) {
            [data-page-loader] { transition-duration: 1ms; }
            .page-loader__spinner {
                animation: none;
                border-color: #6ee7b7;
            }
            [data-page-loader][data-theme="light"] .page-loader__spinner {
                border-color: #047857;
            }
        }
    </style>
@endonce
