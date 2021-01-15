// Have a look at Alpine (https://github.com/alpinejs/alpine) for a minimal JavaScript framework.

/* General functions. */
// Get Cookie.
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
// Set Cookie.
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


// Check for initial language via cookie or browser language.
function adjustLanguage() {
  var languageCookie = getCookie('language_select');
  var activeLanguage = document.documentElement.lang;
  if (activeLanguage != null && activeLanguage != '') {
    if (languageCookie != null && languageCookie != '') {
      if (languageCookie != activeLanguage) {
        if (document.referrer.indexOf(window.location.host) === -1) {
          // Redirect if possible.
          var linkToLanguage_lookup = document.querySelector('link[hreflang="'+languageCookie+'"]');
          if (linkToLanguage_lookup != null && linkToLanguage_lookup != '') {
            var linkToLanguage = linkToLanguage_lookup.href;
            if (linkToLanguage !== null && linkToLanguage !== undefined && linkToLanguage != '') {
              window.location = linkToLanguage;
            }
          }
        } else {
          // Update cookie.
          setCookie('language_select', activeLanguage, 30);
        }
      }
    } else {
      // Set cookie.
      setCookie('language_select', activeLanguage, 30);
      var browserLanguage = navigator.language || navigator.userLanguage;
      if (document.referrer.indexOf(window.location.host) === -1 && browserLanguage != null && browserLanguage != '' && browserLanguage != activeLanguage) {
        var linkToLanguage = document.querySelector('link[hreflang="'+browserLanguage+'"]').href;
        if (linkToLanguage !== null && linkToLanguage !== undefined && linkToLanguage != '') {
          // This indicates that the user is new to the page and his browser language could be supported by one of the translations.
          // You could now offer him a redirect or highlight the language switcher.
          // Auto-Redirect is not recommended here in order to not piss off any search engine crawlers!

        }
      }
    }
  }
}


// Some simple stupid code for playing with the box icon.
function openIt() {
  document.getElementById("box_closed").style.display = "none";
  document.getElementById("box_opened").style.display = "block";
}
function closeIt() {
  document.getElementById("box_closed").style.display = "block";
  document.getElementById("box_opened").style.display = "none";
}
document.getElementById("open_box").addEventListener("click", openIt);
document.getElementById("close_box").addEventListener("click", closeIt);


// run on load.
function runOnStart() {
  // Adjust Language
  // Optional. Use this as JS alternative for the php version within the index.php.
  adjustLanguage();
}

runOnStart();