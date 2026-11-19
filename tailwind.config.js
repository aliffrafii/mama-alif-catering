/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                mamaalif: {
                    // Brand colors (ambil nuansa dari logo)
                    primary: "#7A563B", // coklat hangat (outline/teks logo)
                    "primary-content": "#FFF7ED", // krem terang
                    secondary: "#6B7B3B", // hijau daun (mama)
                    "secondary-content": "#F7F7E8",
                    accent: "#B08A62", // coklat muda/karamel
                    "accent-content": "#1F130A",

                    // UI neutrals (lembut, creamy)
                    neutral: "#2A1A10",
                    "neutral-content": "#F3E8D8",

                    "base-100": "#FFFDF7", // hampir putih krem
                    "base-200": "#FBF3E6", // krem
                    "base-300": "#E9D7C3", // border/line
                    "base-content": "#2A1A10",

                    // Status colors (tetap jelas)
                    info: "#1D4ED8",
                    success: "#16A34A",
                    warning: "#F59E0B",
                    error: "#DC2626",

                    // Optional: rounding feel lebih soft
                    "--rounded-box": "1rem",
                    "--rounded-btn": "0.75rem",
                    "--rounded-badge": "0.75rem",
                },
            },
            "light",
        ],
    },
};
