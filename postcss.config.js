const purgecss = require('@fullhuman/postcss-purgecss')
const cssnano = require('cssnano')

module.exports = {
  plugins: [
    require('postcss-import'),
    require('tailwindcss/nesting')(require('postcss-nesting')),
    require('tailwindcss'),
    require('autoprefixer'),
    require('postcss-nested'),
    cssnano({
      preset: 'default'
    }),
    purgecss({
      content: ['./templates/*.php', './pages/*.php', './lib/*.php', './assets/js/*.js'], // update, if you add other sources for CSS selectors (and also add them at the tailwind.config.js)
      defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
    })
  ]
}