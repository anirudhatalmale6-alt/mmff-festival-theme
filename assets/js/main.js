/**
 * Migration Matters Film Festival - Main JavaScript
 *
 * Handles: mobile menu, sticky header, film filtering (AJAX),
 * filter pills, smooth scroll, and scroll-triggered fade-in animations.
 */

(function () {
  'use strict';

  /* ------------------------------------------------------------------ */
  /*  Utility helpers                                                    */
  /* ------------------------------------------------------------------ */

  /**
   * Debounce a function so it only fires after `delay` ms of inactivity.
   */
  function debounce(fn, delay) {
    let timer = null;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => fn.apply(this, args), delay);
    };
  }

  /**
   * Escape HTML entities to prevent XSS when injecting user-sourced data.
   */
  function escapeHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }

  /* ------------------------------------------------------------------ */
  /*  1. Mobile menu toggle                                              */
  /* ------------------------------------------------------------------ */

  function initMobileMenu() {
    const toggle = document.querySelector('.site-header__menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!toggle) return;

    toggle.addEventListener('click', function () {
      const isOpen = document.body.classList.toggle('mobile-menu-open');
      toggle.setAttribute('aria-expanded', String(isOpen));

      if (mobileMenu) {
        mobileMenu.hidden = !isOpen;
        mobileMenu.setAttribute('aria-hidden', String(!isOpen));
      }
    });

    // Close menu on Escape key.
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && document.body.classList.contains('mobile-menu-open')) {
        document.body.classList.remove('mobile-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
        if (mobileMenu) {
          mobileMenu.hidden = true;
          mobileMenu.setAttribute('aria-hidden', 'true');
        }
      }
    });
  }

  /* ------------------------------------------------------------------ */
  /*  2. Sticky header                                                   */
  /* ------------------------------------------------------------------ */

  function initStickyHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const SCROLL_THRESHOLD = 50;

    function onScroll() {
      if (window.scrollY > SCROLL_THRESHOLD) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }

    // Set initial state in case the page loads already scrolled.
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ------------------------------------------------------------------ */
  /*  3 & 4. Film filter system + filter pill buttons                    */
  /* ------------------------------------------------------------------ */

  function initFilmFilters() {
    const grid = document.getElementById('film-grid');

    // If there is no films grid on the page we have nothing to do.
    if (!grid) return;

    const searchInput = document.getElementById('film-search');
    const yearSelect = document.getElementById('film-year');
    const typeSelect = document.getElementById('film-type');
    const countrySelect = document.getElementById('film-country');
    const languageSelect = document.getElementById('film-language');
    const resetButton = document.getElementById('film-filter-reset');
    const pillButtons = document.querySelectorAll('.filter-pill');

    let currentRequest = null; // track in-flight XHR so we can abort it

    /**
     * Gather the current state of every filter control into a plain object
     * suitable for sending as POST params.
     */
    function getFilterValues() {
      const values = {};

      if (searchInput) {
        values.search = searchInput.value.trim();
      }
      if (yearSelect) {
        values.year = yearSelect.value;
      }
      if (countrySelect) {
        values.country = countrySelect.value;
      }
      if (languageSelect) {
        values.language = languageSelect.value;
      }

      // Film type can come from a <select>, a set of pill buttons, or both.
      // Pill buttons take priority when one is active; otherwise fall back
      // to the <select>.
      const activePill = document.querySelector('.filter-pill.active[data-type]');
      if (activePill) {
        values.film_type = activePill.dataset.type;
      } else if (typeSelect) {
        values.film_type = typeSelect.value;
      }

      // Support pill buttons that control the category filter.
      const activeCategoryPill = document.querySelector('.filter-pill.active[data-category]');
      if (activeCategoryPill) {
        values.category = activeCategoryPill.dataset.category;
      }

      return values;
    }

    /**
     * Show a loading indicator inside the grid.
     */
    function showLoading() {
      grid.classList.add('is-loading');
      grid.setAttribute('aria-busy', 'true');
    }

    /**
     * Hide the loading indicator.
     */
    function hideLoading() {
      grid.classList.remove('is-loading');
      grid.setAttribute('aria-busy', 'false');
    }

    /**
     * Render an array of film objects into the grid.
     */
    function renderFilms(films) {
      if (!films || films.length === 0) {
        grid.innerHTML = '<p class="no-results">No films found.</p>';
        return;
      }

      grid.innerHTML = films.map(renderFilmCard).join('');
    }

    /**
     * Perform the AJAX request with the current filter values.
     */
    function fetchFilms() {
      // Abort any in-flight request so we don't render stale data.
      if (currentRequest) {
        currentRequest.abort();
      }

      const values = getFilterValues();

      // Build FormData for the POST body.
      const formData = new FormData();
      formData.append('action', 'mmff_filter_films');
      formData.append('nonce', mmff_ajax.nonce);

      Object.keys(values).forEach(function (key) {
        if (values[key]) {
          formData.append(key, values[key]);
        }
      });

      showLoading();

      const xhr = new XMLHttpRequest();
      currentRequest = xhr;

      xhr.open('POST', mmff_ajax.url, true);

      xhr.onload = function () {
        currentRequest = null;
        hideLoading();

        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            const response = JSON.parse(xhr.responseText);
            const films = response.success ? response.data : response;
            renderFilms(Array.isArray(films) ? films : []);
          } catch (err) {
            console.error('MMFF: Failed to parse filter response', err);
            grid.innerHTML = '<p class="no-results">Something went wrong. Please try again.</p>';
          }
        } else {
          console.error('MMFF: Filter request failed', xhr.status);
          grid.innerHTML = '<p class="no-results">Something went wrong. Please try again.</p>';
        }
      };

      xhr.onerror = function () {
        currentRequest = null;
        hideLoading();
        console.error('MMFF: Network error during filter request');
        grid.innerHTML = '<p class="no-results">Something went wrong. Please try again.</p>';
      };

      xhr.onabort = function () {
        // Intentional abort; do nothing so the newer request takes over.
        currentRequest = null;
      };

      xhr.send(formData);
    }

    // --- Bind filter controls -------------------------------------------

    // Debounced search input.
    if (searchInput) {
      searchInput.addEventListener('input', debounce(fetchFilms, 300));
    }

    // Select dropdowns trigger immediately on change.
    [yearSelect, typeSelect, countrySelect, languageSelect].forEach(function (el) {
      if (el) {
        el.addEventListener('change', fetchFilms);
      }
    });

    // Reset button clears all filters and re-fetches.
    if (resetButton) {
      resetButton.addEventListener('click', function () {
        if (searchInput) searchInput.value = '';
        if (yearSelect) yearSelect.value = '';
        if (typeSelect) typeSelect.value = '';
        if (countrySelect) countrySelect.value = '';
        if (languageSelect) languageSelect.value = '';
        pillButtons.forEach(function (p) { p.classList.remove('active'); });
        fetchFilms();
      });
    }

    // Prevent form submission (use AJAX instead).
    var filterForm = document.getElementById('film-filter-form');
    if (filterForm) {
      filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        fetchFilms();
      });
    }

    // Pill buttons toggle `.active` and trigger a fetch.
    pillButtons.forEach(function (pill) {
      pill.addEventListener('click', function () {
        // Within the same group, only one pill can be active at a time.
        // Determine the group by looking at the data attribute present.
        const groupAttr = pill.dataset.type !== undefined ? 'data-type' : 'data-category';
        const siblings = document.querySelectorAll('.filter-pill[' + groupAttr + ']');

        if (pill.classList.contains('active')) {
          // Clicking the already-active pill deselects it.
          pill.classList.remove('active');
        } else {
          siblings.forEach(function (s) {
            s.classList.remove('active');
          });
          pill.classList.add('active');
        }

        fetchFilms();
      });
    });
  }

  /* ------------------------------------------------------------------ */
  /*  7. Film card render function                                       */
  /* ------------------------------------------------------------------ */

  /**
   * Build the HTML string for a single film card.
   *
   * Expects a film object with: id, title, permalink, thumbnail, excerpt,
   * duration, director, type, screening_date, screening_time,
   * countries[], languages[], categories[].
   */
  function renderFilmCard(film) {
    const title = escapeHtml(film.title);
    const permalink = escapeHtml(film.permalink);
    const thumbnail = escapeHtml(film.thumbnail);
    const type = escapeHtml(film.type);
    const director = escapeHtml(film.director);
    const duration = escapeHtml(film.duration);
    const countries = Array.isArray(film.countries)
      ? escapeHtml(film.countries.join(', '))
      : escapeHtml(film.countries || '');
    const screeningDate = escapeHtml(film.screening_date);
    const screeningTime = escapeHtml(film.screening_time);

    return (
      '<article class="film-card">' +
        '<a href="' + permalink + '">' +
          '<div class="film-card__poster">' +
            '<img src="' + thumbnail + '" alt="' + title + '">' +
            (type ? '<span class="film-card__type">' + type + '</span>' : '') +
          '</div>' +
          '<div class="film-card__info">' +
            '<h3 class="film-card__title">' + title + '</h3>' +
            (director ? '<p class="film-card__director">' + director + '</p>' : '') +
            '<div class="film-card__meta">' +
              (duration ? '<span class="film-card__duration">' + duration + '</span>' : '') +
              (countries ? '<span class="film-card__country">' + countries + '</span>' : '') +
            '</div>' +
            (screeningDate || screeningTime
              ? '<div class="film-card__schedule">' +
                  (screeningDate ? '<span>' + screeningDate + '</span>' : '') +
                  (screeningTime ? '<span>' + screeningTime + '</span>' : '') +
                '</div>'
              : '') +
          '</div>' +
        '</a>' +
      '</article>'
    );
  }

  /* ------------------------------------------------------------------ */
  /*  5. Smooth scroll for anchor links                                  */
  /* ------------------------------------------------------------------ */

  function initSmoothScroll() {
    document.addEventListener('click', function (e) {
      const link = e.target.closest('a[href^="#"]');
      if (!link) return;

      const targetId = link.getAttribute('href');
      if (!targetId || targetId === '#') return;

      const target = document.querySelector(targetId);
      if (!target) return;

      e.preventDefault();

      target.scrollIntoView({ behavior: 'smooth', block: 'start' });

      // Update the URL hash without jumping.
      if (history.pushState) {
        history.pushState(null, '', targetId);
      }
    });
  }

  /* ------------------------------------------------------------------ */
  /*  6. Fade-in on scroll (IntersectionObserver)                        */
  /* ------------------------------------------------------------------ */

  function initFadeIn() {
    const elements = document.querySelectorAll('.fade-in');
    if (!elements.length) return;

    // Graceful fallback for browsers that lack IntersectionObserver.
    if (!('IntersectionObserver' in window)) {
      elements.forEach(function (el) {
        el.classList.add('is-visible');
      });
      return;
    }

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.15,
        rootMargin: '0px 0px -40px 0px',
      }
    );

    elements.forEach(function (el) {
      observer.observe(el);
    });
  }

  /* ------------------------------------------------------------------ */
  /*  7. Language switcher (SE/EN via Google Translate)                   */
  /* ------------------------------------------------------------------ */

  function initLangSwitcher() {
    var buttons = document.querySelectorAll('.lang-switcher__btn');
    if (!buttons.length) return;

    // Load Google Translate script
    var script = document.createElement('script');
    script.src = 'https://translate.google.com/translate_a/element.js?cb=mmffTranslateInit';
    document.head.appendChild(script);

    // Initialize Google Translate (hidden widget)
    window.mmffTranslateInit = function () {
      new google.translate.TranslateElement({
        pageLanguage: 'sv',
        includedLanguages: 'sv,en',
        autoDisplay: false,
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'mmff-translate-widget');
    };

    // Create hidden container for Google Translate widget
    var widget = document.createElement('div');
    widget.id = 'mmff-translate-widget';
    widget.style.display = 'none';
    document.body.appendChild(widget);

    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var lang = btn.dataset.lang;

        // Update active state
        buttons.forEach(function (b) { b.classList.remove('lang-switcher__btn--active'); });
        btn.classList.add('lang-switcher__btn--active');

        // Trigger Google Translate
        if (lang === 'en') {
          // Set cookie for Google Translate
          document.cookie = 'googtrans=/sv/en; path=/';
          document.cookie = 'googtrans=/sv/en; path=/; domain=' + window.location.hostname;
          // Try to trigger translation
          var sel = document.querySelector('#mmff-translate-widget select');
          if (sel) {
            sel.value = 'en';
            sel.dispatchEvent(new Event('change'));
          } else {
            // Reload to activate translation
            window.location.reload();
          }
        } else {
          // Restore to Swedish (original)
          document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC';
          document.cookie = 'googtrans=; path=/; domain=' + window.location.hostname + '; expires=Thu, 01 Jan 1970 00:00:00 UTC';
          // Remove Google Translate frame if present
          var frame = document.querySelector('.goog-te-banner-frame');
          if (frame) frame.style.display = 'none';
          document.body.style.top = '0';
          // Try to restore original text
          var sel = document.querySelector('#mmff-translate-widget select');
          if (sel) {
            sel.value = 'sv';
            sel.dispatchEvent(new Event('change'));
          } else {
            window.location.reload();
          }
        }
      });
    });

    // Set initial state based on current cookie
    var match = document.cookie.match(/googtrans=\/sv\/(\w+)/);
    if (match && match[1] === 'en') {
      buttons.forEach(function (b) { b.classList.remove('lang-switcher__btn--active'); });
      var enBtn = document.querySelector('.lang-switcher__btn[data-lang="en"]');
      if (enBtn) enBtn.classList.add('lang-switcher__btn--active');
    }
  }

  /* ------------------------------------------------------------------ */
  /*  Initialise everything on DOMContentLoaded                          */
  /* ------------------------------------------------------------------ */

  document.addEventListener('DOMContentLoaded', function () {
    initMobileMenu();
    initStickyHeader();
    initFilmFilters();
    initSmoothScroll();
    initFadeIn();
    initLangSwitcher();
  });
})();
