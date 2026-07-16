export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#1B59E0"
        },
        accent: {
          DEFAULT: "#FACC15",
          hover: "FACC8A"
        },
        background: "#F8FAFC",
        textdark: "#0F172A",
        textgray: "#475569",
        bordercolor: "#E2E8F0",
      },
    },
  },
  plugins: [],
}