{{--
    The translucent, blurred content panel used on the content pages.
    Layout classes (grid, flex, gap...) go in `class`; the padding defaults to p-8.
--}}
@props(['padding' => 'p-8'])

<div {{ $attributes->class(['max-w-7xl mx-auto backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl', $padding]) }}>
    {{ $slot }}
</div>
