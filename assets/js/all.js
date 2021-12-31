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


/* Managing YouTube Videos */
// Stop all
function stopAllIframeVideos() {
	var iframes = document.querySelectorAll('iframe');
  Array.prototype.forEach.call(iframes, iframe => {
    iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'stopVideo' }), '*');
  });
};
// Deferred Loading
// Sample Element: <div class="youtube" data-embed="dQw4w9WgXcQ" data-playlist="PLi9drqWffJ9FWBo7ZVOiaVy0UQQEm4IbP" data-img="./assets/images/thumb.jpg"><div class="play-button"></div></div>
// - data-embed holds the YouTube video URL.
// - setting data-playlist, holding a playlist id, enables the video as a playlist, where the data-embed only defines the thumbnail.
// - setting data-img overrides the YouTube thumb with your own image.
function initYouTube() {
	var youtube = document.querySelectorAll( ".youtube" );
	for (var i = 0; i < youtube.length; i++) {
    var source;
    if (youtube[i].dataset.img != null) {
      source = youtube[i].dataset.img;
    }	 else {
      source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/hq720.jpg";
    }
		var image = new Image();
      image.src = source;
      image.alt = "";
			image.addEventListener( "load", function() {
				youtube[ i ].appendChild( image );
			}( i ) );		
			youtube[i].addEventListener( "click", function() {
        stopAllIframeVideos();
				var iframe = document.createElement( "iframe" );
        iframe.setAttribute( "frameborder", "0" );
        iframe.setAttribute( "allowfullscreen", "" );
        iframe.setAttribute( "allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" );
        if (this.dataset.playlist != null) {
          iframe.setAttribute( "src", "https://www.youtube-nocookie.com/embed/?listType=playlist&list="+ this.dataset.playlist +"&enablejsapi=1&autoplay=1&rel=0&showinfo=0" );
        } else {
          iframe.setAttribute( "src", "https://www.youtube-nocookie.com/embed/"+ this.dataset.embed +"?enablejsapi=1&autoplay=1&rel=0&showinfo=0" );
        }
        this.innerHTML = "<span>Loading...</span>";
        this.appendChild( iframe );
			} );	
	};	
};


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
      browserLanguage = browserLanguage.substring(0, 1);
      if (document.referrer.indexOf(window.location.host) === -1 && browserLanguage != null && browserLanguage != '' && browserLanguage != activeLanguage) {
        var linkToLanguage = document.querySelector('link[hreflang="'+browserLanguage+'"]');
        if (linkToLanguage !== null && linkToLanguage !== undefined && linkToLanguage != '') {
          linkToLanguage = linkToLanguage.href;
          // This indicates that the user is new to the page and his browser language could be supported by one of the translations.
          // You could now offer him a redirect or highlight the language switcher.
          // Auto-Redirect is not recommended here in order to not piss off any search engine crawlers!

        }
      }
    }
  }
}

// run on load.
function runOnStart() {
  // Adjust Language
  // Check for initial language via cookie or browser language and redirect automatically. The JavaScript alternative for the php version within the index.php.
  adjustLanguage();
  // Init lazy load YouTube videos.
  initYouTube();
}

runOnStart();