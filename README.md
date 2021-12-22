# PHP Microsite Boilerplate

[![pagespeed-100](https://img.shields.io/badge/Lighthouse%20PageSpeed-100-success.svg)](https://developers.google.com/speed/pagespeed/insights/?url=https://phpmicrosite.jenskuerschner.de)
[![pwa-valid](https://img.shields.io/badge/PWA-valid-success.svg)](https://phpmicrosite.jenskuerschner.de/)
[![w3c-css-valid](https://img.shields.io/badge/W3C%20CSS-valid-success.svg)](https://jigsaw.w3.org/css-validator/validator?uri=https%3A%2F%2Fphpmicrosite.jenskuerschner.de%2F&profile=css3svg&usermedium=all)
[![LICENSE](https://img.shields.io/badge/license-GPL%203.0-blue.svg)](https://github.com/jekuer/php-microsite-boilerplate/blob/master/LICENSE.txt)
[![github-stars-image](https://img.shields.io/github/stars/jekuer/php-microsite-boilerplate.svg?label=github%20stars)](https://github.com/jekuer/php-microsite-boilerplate)

_PHP Microsite Boilerplate_ is a PHP framework to create simple, yet strongly functional, fast, and secure websites on basically every environment.

Most frameworks and even boilerplates require an exhausting setup process, where you need to install multiple dependencies. 
This leads to a huge overhead of code, which you often do not need. All of those complexity is also a potential risk for your website. 
Furthermore, it is often not possible to use most solutions, if you need to deploy it on the cheapest shared hosting plan.

This project wants to provide you with a framework and template for this exact case:

* You need to build a rather small website, with some functionality.
* You choose PHP, because you want to do server-side scripting, while PHP is also maybe the only language, that runs on basically all hosting options.
* You build this thing on your own or with a maximum of 1 other person, which makes best practice, but complex code structure more of an unnecessary overhead than a helpful concept.
* You need to get it done fast, while you do not want to make compromises regarding security or performance.
* You therefore do not care about clean code a lot ;).

Demo: <https://phpmicrosite.jenskuerschner.de/>

## Key Features

* Easy routing.
* [Progressive Web App (PWA)](https://web.dev/progressive-web-apps/) prepared.
* Multilanguage prepared.
* [Directus CMS](https://directus.io/) integration (incl. local cache).
* Docker compose for local development.
* TailwindCSS included (optional).
* GDPR and CCPA ready.
* Intelligent serviceworker cache.
* Gettext support for easy translation (+ fallback if not installed on the server).
* SEO optimized.
* Automated sitemap generation.
* Optimized for Social sharing.
* Speed- & GDPR-optimized YouTube-Integration.
* Optional CSS and JavaScript optimization with prepared build scripts.
* Extensive in-code documentation.
* [Security Headers](https://securityheaders.com/) (.htaccess or via PHP)
* Multiple security features (most of them require an Apache server!)
* Prepared to run git deployment.
* Developed to make it extremely easy for you to remove features or add your own things.

## Usage

1. Download the respective branch/tag and upload it to your website's folder - or clone the repo as you like.

2. Adjust it to your project: 
  * Check the .htaccess file, if you run it on Apache. Mind the security headers and places, where a domain/path is specified (look for YOURDOMAIN.com). 
  * If you do not run it on Apache, check the index.php for the security headers setup and make sure every request (except for files) is send to the index.php. Check the nginx_deployment.sh - it is a pre-configured bash script to setup your nginx webserver. 
  * Adjust the values within config.php and also mind files, which are mentioned in the comments there. Setup a connection to your Directus CMS if used.
  * Check /templates/general_meta.php and create the respective favicons. 
  * Define your pages at the routing.php. (Mind legal notice and privacy policy to stay GDPR compliant!) 
  * Create those pages (as specified before) as single php files within /pages. 
  * Create respective files within /controller if necessary in your case. 
  * Check the option to auto-redirect within multi-language at index.php and all.js. 
  * Build the website with those pages, the style.css, and the all.js. Mind to minimize those files or adjust the way they get included at /templates/header.php and /templates/footer.php. 
  * Adjust the footer at /templates/footer.php to your needs. 
  * Find more details in the in-code documentation - it's a well documented playground!

3. That is basically it regarding adjustments. You can find a more detailed sample setup guide [at the corresponding Medium blog post here](https://medium.com/@jenskuerschner/build-a-kick-ass-php-microsite-in-under-3h-f21b27b904d2).

4. Building the project, hardly depends on your configuration! If you are using the TailwindCSS integration, you need to use the included build script, which requires NodeJS! If you are going plain, you can skip on that. However, not using the build scripts would also not merge and minify the css and js files. Therefore, if possible for you, it is hardly recommended. For building:
  * make sure you are within the project's root directory with your terminal.
  * run `npm install`.
  * run `npm run build:dev` for development (will not limit/minify the TailwindCSS code) or `npm run build` for production (going minimal).
  * That's it. Feel free to do this manually on your local machine and upload it to your host - or use some build pipelines at whatever tool you are using.

BTW: It is recommended to use a CDN service (e.g. [Cloudflare](https://www.cloudflare.com/)) in order to speed it up even more.

## Local Development Setup

For local development, you can make use of the included docker-compose.yml
1. Update the container name in the yml file.
2. Download and install Docker Desktop.
3. Adjust the `$the_page_url` in the config.php temporarily to "/".
4. Run `docker-compose up -d` in the terminal at the project's root directory.
5. Open the project at `localhost:80` (mind that you might see an SSL error - should be no blocker),
6. Happy coding and testing.

## Contributing

Anyone is welcome to contribute, but mind the [guidelines](.github/CONTRIBUTING.md):

* [Bug reports](.github/CONTRIBUTING.md#bugs)
* [Feature requests](.github/CONTRIBUTING.md#features)
* [Pull requests](.github/CONTRIBUTING.md#pull-requests)

## License

The code is available under the [GPL 3.0 license](LICENSE.txt).
You can basically do anything with it, but mind that if you want to distribute your work based on this code, your work needs to be GPL licensed as well.
This means that you can easily build your website with it, since this is no distribution. Distribution would be the case, if you sell a project based on this code to others or if you create public projects (no matter if you sell them or not). Even this would be all fine, as long as you license those projects also with GPL. :)
Check the [license file](LICENSE.txt) for all details.


## Inspired by

This code has been inspired by the [HTML5 Boilerplate](https://github.com/h5bp/html5-boilerplate).
