<x-layouts.app>
    <x-slot name="title">Kiadó irodák - Szűrés | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description"
            content="Keresse meg a tökéletes kiadó irodaházat Budapesten. Szűrje eredményeit kerület, méret és bérleti díj szerint.">
        <meta name="keywords" content="kiadó irodák, Budapest, irodaház, iroda bérlés, szűrés, kerület">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>
    <x-slot name="content">
        <style>
            .map-container {
                position: relative;
            }

            .kerulet.selected {
                fill: rgba(111, 114, 185, 0.6) !important;
                stroke: #6f72b9;
                stroke-width: 2px;
            }

            .search-form {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>

        <script>
            // Additional map interaction enhancements
            document.addEventListener('DOMContentLoaded', function() {
                // Add hover effects to map districts
                const districts = document.querySelectorAll('.kerulet');
                districts.forEach(district => {
                    district.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.02)';
                        this.style.transformOrigin = 'center';
                        this.style.transition = 'transform 0.2s ease';
                    });

                    district.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });
            });
        </script>
    </x-slot>

    <div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
        <livewire:list-rent-offices />
    </div>
</x-layouts.app>
