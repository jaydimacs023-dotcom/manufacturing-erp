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
    <div class="page-loader__panel">
        <span class="page-loader__mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="m4.5 8 7.5-4 7.5 4-7.5 4-7.5-4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                <path d="M4.5 8v8l7.5 4 7.5-4V8M12 12v8" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                <path d="M9.25 6.55 16.7 10.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
        </span>
        <span class="page-loader__copy">
            <strong>{{ $message }}</strong>
            <small>Please wait a moment</small>
        </span>
    </div>
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
        .page-loader__panel {
            display: flex;
            align-items: center;
            gap: .9rem;
            min-width: min(18rem, 100%);
            padding: 1rem 1.15rem;
            border: 1px solid rgba(110, 231, 183, .22);
            border-radius: .9rem;
            background: rgba(6, 78, 59, .72);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .24);
        }
        .page-loader__mark {
            display: grid;
            place-items: center;
            width: 2.75rem;
            height: 2.75rem;
            flex: 0 0 auto;
            border: 2px solid rgba(110, 231, 183, .28);
            border-top-color: #6ee7b7;
            border-radius: 50%;
            color: #a7f3d0;
            animation: page-loader-spin 900ms linear infinite;
        }
        .page-loader__mark svg {
            width: 1.35rem;
            height: 1.35rem;
            animation: page-loader-counter-spin 900ms linear infinite;
        }
        .page-loader__copy { display: grid; gap: .15rem; line-height: 1.2; }
        .page-loader__copy strong { font-size: .9rem; font-weight: 700; letter-spacing: .01em; }
        .page-loader__copy small { color: #a7f3d0; font-size: .72rem; }
        [data-page-loader][data-theme="light"] {
            color: #064e3b;
            background: rgba(248, 250, 252, .97);
        }
        [data-page-loader][data-theme="light"] .page-loader__panel {
            border-color: #d1fae5;
            background: #fff;
        }
        [data-page-loader][data-theme="light"] .page-loader__copy small { color: #047857; }
        @keyframes page-loader-spin { to { transform: rotate(360deg); } }
        @keyframes page-loader-counter-spin { to { transform: rotate(-360deg); } }
        @media (prefers-reduced-motion: reduce) {
            [data-page-loader] { transition-duration: 1ms; }
            .page-loader__mark, .page-loader__mark svg { animation: none; }
            .page-loader__mark { border-color: #6ee7b7; }
        }
    </style>
@endonce
