const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './app_client/**/*.{vue,js,ts,jsx,tsx}',
  ],
  darkMode: 'class',
  theme: {
    fontFamily: {
      display: ['Fira Sans', 'sans-serif'],
      body: ['Lato', 'sans-serif'],
    },
    colors: {
      primary: colors.blue,
      current: 'currentColor',
      accent: colors.amber,
      black: colors.black,
      white: colors.white,
      slate: colors.slate,
      red: colors.red,
      green: colors.green,
    },
    extend: {
      backgroundImage: {
        brand: 'linear-gradient(270deg, #fb8500 0%, #ffb703 100%)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/line-clamp'),
  ],
};
