/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                ink: '#14141A',      // texte principal / fonds sombres
                paper: '#FBFAF8',    // fond clair
                ember: '#F2831D',    // orange - accent primaire (issu du logo)
                moss: '#3F7D33',     // vert - accent secondaire
                claret: '#7A1F3D',   // bordeaux - accent tertiaire
                slate: '#5B5D63',    // gris - texte secondaire / bordures
            },
            fontFamily: {
                display: ['"Space Grotesk"', 'sans-serif'],
                body: ['"Inter"', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
