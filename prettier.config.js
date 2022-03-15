module.exports = {
  tailwindConfig: './tailwind.config.js',
  tabWidth: 2,
  semi: true,
  singleQuote: true,
  vueIndentScriptAndStyle: false,
  plugins: [require('prettier-plugin-tailwindcss')],
};
