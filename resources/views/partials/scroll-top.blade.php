@php
  $isAdminArea = request()->routeIs('admin.*');
  $pageLocale = request()->route('locale') ?? app()->getLocale();
  $floatingWhatsAppConfig = ! $isAdminArea
      ? \App\Support\WhatsAppMessage::config('direct', ['site' => config('site.name')], $pageLocale, 'floating-'.request()->path())
      : null;
  $whatsAppFloatingUrl = $floatingWhatsAppConfig['url'] ?? null;
@endphp

<style>
  .site-whatsapp-float {
    position: fixed;
    right: 1rem;
    bottom: 1.35rem;
    z-index: 1035;
    display: flex;
    align-items: center;
    gap: .6rem;
    min-height: 60px;
    min-width: 198px;
    max-width: calc(100vw - 1.5rem);
    padding: .56rem .82rem .56rem .64rem;
    border-radius: 20px;
    background: linear-gradient(180deg, rgba(24, 31, 51, 0.98) 0%, rgba(18, 24, 42, 0.98) 100%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #fff;
    box-shadow: 0 28px 60px rgba(15, 23, 42, 0.28);
    text-decoration: none;
    font-weight: 700;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, filter .2s ease;
  }

  .site-whatsapp-float:hover {
    color: #fff;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 32px 68px rgba(15, 23, 42, 0.34);
    border-color: rgba(255, 255, 255, 0.14);
    filter: saturate(1.03);
  }

  .site-whatsapp-float-icon {
    position: relative;
    flex: 0 0 auto;
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #25d366 0%, #16a34a 100%);
    color: #fff;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25), 0 16px 28px rgba(34, 197, 94, 0.22);
  }

  .site-whatsapp-float-icon::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 14px;
    border: 1px solid rgba(255, 255, 255, 0.18);
  }

  .site-whatsapp-float-icon i {
    font-size: 1.25rem;
  }

  .site-whatsapp-float-text {
    min-width: 0;
    display: flex;
    flex-direction: column;
    line-height: 1;
    overflow: hidden;
  }

  .site-whatsapp-float-label {
    margin-bottom: .22rem;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 800;
    white-space: nowrap;
    letter-spacing: -.02em;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .site-whatsapp-float-sub {
    color: rgba(255, 255, 255, 0.72);
    font-size: .64rem;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  @media (max-width: 991.98px) {
    .site-whatsapp-float {
      min-height: 58px;
      min-width: 196px;
      padding: .54rem .76rem .54rem .6rem;
      border-radius: 20px;
      gap: .56rem;
    }

    .site-whatsapp-float-icon {
      width: 40px;
      height: 40px;
      border-radius: 13px;
    }

    .site-whatsapp-float-icon::after {
      border-radius: 13px;
    }

    .site-whatsapp-float-icon i {
      font-size: 1.1rem;
    }

    .site-whatsapp-float-label {
      font-size: .94rem;
    }

    .site-whatsapp-float-sub {
      font-size: .6rem;
    }
  }

  @media (max-width: 575.98px) {
    .site-whatsapp-float {
      right: .75rem;
      bottom: .9rem;
      min-width: auto;
      min-height: 52px;
      padding: .48rem .7rem .48rem .54rem;
      gap: .52rem;
      border-radius: 18px;
      box-shadow: 0 22px 42px rgba(15, 23, 42, 0.24);
    }

    .site-whatsapp-float-icon {
      width: 38px;
      height: 38px;
      border-radius: 12px;
    }

    .site-whatsapp-float-icon::after {
      border-radius: 12px;
    }

    .site-whatsapp-float-icon i {
      font-size: 1.05rem;
    }

    .site-whatsapp-float-label {
      margin-bottom: .08rem;
      font-size: .82rem;
    }

    .site-whatsapp-float-sub {
      display: block;
      font-size: .58rem;
    }
  }
</style>

@if($whatsAppFloatingUrl)
    <a
        href="{{ $whatsAppFloatingUrl }}"
        class="site-whatsapp-float"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="{{ __('site.whatsapp_floating.label') }}"
        data-whatsapp-prefill='@json($floatingWhatsAppConfig)'
    >
        <span class="site-whatsapp-float-icon"><i class="ai-whatsapp"></i></span>
        <span class="site-whatsapp-float-text">
            <span class="site-whatsapp-float-label">{{ __('site.whatsapp_floating.label') }}</span>
            <span class="site-whatsapp-float-sub">{{ __('site.whatsapp_floating.subtext') }}</span>
        </span>
    </a>
@endif

<!-- Back to top button -->
<a class="btn-scroll-top" href="#top" data-scroll aria-label="Retour en haut">
  <svg viewBox="0 0 40 40" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <circle cx="20" cy="20" r="19" fill="none" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10">
    </circle>
  </svg>
  <i class="ai-arrow-up"></i>
</a>

<script>
  (() => {
    const buildWhatsAppUrl = (config) => {
      if (!config || !config.phone || !config.template) {
        return null;
      }

      const hour = new Date().getHours();
      const greeting = hour >= 18 ? config.greetings?.evening : config.greetings?.day;
      const replacements = { ...(config.replacements || {}), greeting: greeting || '' };
      let message = config.template;

      Object.entries(replacements).forEach(([key, value]) => {
        message = message.split(`:${key}`).join(String(value || '').trim());
      });

      message = message.replace(/\s{2,}/g, ' ').trim();

      return `https://wa.me/${config.phone}?text=${encodeURIComponent(message)}`;
    };

    const initWhatsAppLinks = () => {
      document.querySelectorAll('[data-whatsapp-prefill]').forEach((link) => {
        let config = null;

        try {
          config = JSON.parse(link.getAttribute('data-whatsapp-prefill') || '{}');
        } catch (error) {
          config = null;
        }

        if (!config) {
          return;
        }

        const applyHref = () => {
          const url = buildWhatsAppUrl(config);
          if (url) {
            link.setAttribute('href', url);
          }
        };

        applyHref();
        link.addEventListener('click', applyHref, { passive: true });
      });
    };

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initWhatsAppLinks, { once: true });
    } else {
      initWhatsAppLinks();
    }
  })();
</script>
