@props([
    'message' => 'Preparing workspace',
    'theme' => 'emerald',
])

<div
    data-page-loader
    role="status"
    aria-live="polite"
    aria-label="{{ $message }}"
>
    <span class="sr-only">{{ $message }}</span>
    <span class="page-loader__bar" aria-hidden="true"></span>
</div>

@once
    <style>
        [data-page-loader] {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 9999;
            height: 3px;
            overflow: hidden;
            opacity: 1;
            visibility: visible;
            pointer-events: none;
            transition: opacity 180ms ease, visibility 0s linear 180ms;
        }
        [data-page-loader][aria-hidden="true"] {
            opacity: 0;
            visibility: hidden;
        }
        .page-loader__bar {
            position: absolute;
            inset-block: 0;
            left: 0;
            width: 38%;
            border-radius: 0 999px 999px 0;
            background: linear-gradient(90deg, #047857, #34d399, #a7f3d0);
            box-shadow: 0 0 10px rgba(16, 185, 129, .75);
            animation: page-loader-progress 1.15s ease-in-out infinite;
            transform-origin: left center;
            will-change: transform;
        }
        @keyframes page-loader-progress {
            0% {
                transform: translateX(-105%) scaleX(.55);
            }
            55% {
                transform: translateX(115%) scaleX(1.15);
            }
            100% {
                transform: translateX(275%) scaleX(.65);
            }
        }
        @media (prefers-reduced-motion: reduce) {
            [data-page-loader] { transition-duration: 1ms; }
            .page-loader__bar {
                animation: none;
                width: 70%;
            }
        }
    </style>
@endonce
