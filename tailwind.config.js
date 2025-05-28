/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {},
  },
  darkMode: 'class', // or 'media' if you prefer
  safelist: [
    'bg-red-100', 'text-red-800', 'dark:bg-red-900/50', 'dark:text-red-200',
    'bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-900/50', 'dark:text-yellow-200',
    'bg-green-100', 'text-green-800', 'dark:bg-green-900/50', 'dark:text-green-200'
  ],
  plugins: [],
}
