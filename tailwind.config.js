import preset from "./vendor/filament/support/tailwind.config.preset";
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import aspectRatio from "@tailwindcss/aspect-ratio";

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./node_modules/swiper/**/*.{js,css}",
        "./vendor/awcodes/filament-tiptap-editor/resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: "rgb(var(--color-primary))",
                secondary: "rgb(var(--color-secondary))",
                accent: "hsl(var(--color-accent))",
                accentdark: "hsl(var(--color-accentdark))",
                logogray: "rgb(var(--color-logogray))",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography, aspectRatio],
};
