/** @type {import("prettier").Config} */
export default {
    endOfLine: 'lf',
    plugins: ['prettier-plugin-blade', 'prettier-plugin-tailwindcss'],
    printWidth: 140,
    proseWrap: 'preserve',
    singleQuote: true,
    tabWidth: 4,
    tailwindStylesheet: './resources/css/app.css',
    overrides: [
        {
            files: '*.blade.php',
            options: {
                bladeDirectiveArgSpacing: 'none',
                bladePhpFormatting: 'safe',
                bladePhpFormattingTargets: ['directiveArgs'],
                parser: 'blade',
            },
        },
        {
            files: ['resources/views/components/ui/modal.blade.php', 'resources/views/livewire/sidebar.blade.php'],
            options: {
                bladePhpFormatting: 'off',
            },
        },
        {
            files: ['*.yaml', '*.yml'],
            options: {
                tabWidth: 2,
            },
        },
    ],
};
