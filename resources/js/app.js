import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import flatpickr from 'flatpickr';
import TomSelect from 'tom-select';
import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import 'flatpickr/dist/flatpickr.min.css';
import 'tom-select/dist/css/tom-select.css';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

Alpine.plugin(collapse);
window.Alpine = Alpine;
window.flatpickr = flatpickr;
window.TomSelect = TomSelect;
window.Swiper = Swiper;
window.SwiperNavigation = Navigation;
window.SwiperPagination = Pagination;
window.SwiperAutoplay = Autoplay;

Alpine.data('bookingSidebar', (config) => ({
  priceUrl: config.priceUrl,
  datesUrl: config.datesUrl,
  slug: config.slug,
  maxGuests: config.maxGuests,
  createUrl: config.createUrl,
  useCalendar: config.useCalendar,
  basePrice: config.basePrice || 0,
  initialDate: config.initialDate || '',
  initialGuests: Math.max(1, Math.min(config.maxGuests, parseInt(config.initialGuests, 10) || 1)),
  availabilityStartDate: config.availabilityStartDate || null,
  availabilityEndDate: config.availabilityEndDate || null,
  guests: 1,
  selectedDate: '',
  pricePerPerson: config.basePrice || 0,
  originalPricePerPerson: config.basePrice || 0,
  discountApplied: null,
  total: (config.basePrice || 0) * 1,
  currency: (config.currency === 'EUR' || !config.currency ? '€' : config.currency),
  tierLabel: '',
  loading: true,
  participantsOpen: false,
  availableDates: [],
  fp: null,
  async init() {
    this.guests = this.initialGuests;
    this.selectedDate = this.initialDate || '';
    if (!this.useCalendar) {
      this.loading = false;
      this.updatePrice();
      this.$watch('guests', () => this.updatePrice());
      return;
    }
    await this.fetchDates();
    await this.$nextTick();
    this.initFlatpickr();
    if (this.fp && this.initialDate && this.availableDates.includes(this.initialDate)) {
      this.fp.setDate(this.initialDate);
      this.selectedDate = this.initialDate;
    } else if (this.initialDate && !this.availableDates.includes(this.initialDate)) {
      this.selectedDate = '';
    }
    this.loading = false;
    this.updatePrice();
    this.$watch('guests', () => this.updatePrice());
  },
  async fetchDates() {
    try {
      const todayStr = new Date().toISOString().slice(0, 10);
      let toStr;
      if (this.availabilityEndDate) {
        toStr = this.availabilityEndDate;
      } else {
        const t = new Date();
        t.setFullYear(t.getFullYear() + 2);
        toStr = t.toISOString().slice(0, 10);
      }
      const url = `${this.datesUrl}?from=${todayStr}&to=${toStr}`;
      const res = await fetch(url);
      if (!res.ok) throw new Error('Failed to load dates');
      const data = await res.json();
      const raw = Array.isArray(data.dates) ? data.dates : [];
      this.availableDates = raw
        .filter((d) => {
          if (!d) return false;
          if (d.is_available === true || d.is_available === 1 || d.is_available === '1') return true;
          const spots = d.available_spots;
          return spots != null && Number(spots) > 0;
        })
        .map((d) => {
          const s = d.date_formatted || d.date || '';
          return String(s).slice(0, 10);
        })
        .filter((s) => /^\d{4}-\d{2}-\d{2}$/.test(s));
    } catch (e) {
      this.availableDates = [];
    }
  },
  buildFallbackDates(days) {
    const out = [];
    const d = new Date();
    for (let i = 0; i < days; i++) {
      const copy = new Date(d);
      copy.setDate(copy.getDate() + i);
      out.push(copy.toISOString().slice(0, 10));
    }
    return out;
  },
  initFlatpickr() {
    if (!window.flatpickr || !this.$refs.dateInput || !this.$refs.calendarContainer) return;
    const self = this;
    const todayStr = new Date().toISOString().slice(0, 10);
    let minDate = 'today';
    if (this.availabilityStartDate && this.availabilityStartDate > todayStr) {
      minDate = this.availabilityStartDate;
    }
    let maxDate;
    if (this.availabilityEndDate) {
      maxDate = this.availabilityEndDate;
    } else {
      maxDate = new Date();
      maxDate.setFullYear(maxDate.getFullYear() + 2);
    }

    const allowed = new Set(this.availableDates);
    const disable =
      allowed.size === 0
        ? [() => true]
        : [
            (date) => {
              const ymd = flatpickr.formatDate(date, 'Y-m-d');
              return !allowed.has(ymd);
            },
          ];

    this.fp = window.flatpickr(this.$refs.dateInput, {
      dateFormat: 'Y-m-d',
      minDate,
      maxDate,
      disable,
      static: true,
      appendTo: this.$refs.calendarContainer,
      onChange(_selected, dateStr) {
        if (dateStr && !allowed.has(dateStr)) {
          self.fp.clear();
          self.selectedDate = '';
          return;
        }
        self.selectedDate = dateStr || '';
        self.updatePrice();
      },
    });
  },
  async updatePrice() {
    try {
      let url = `${this.priceUrl}?guests=${this.guests}`;
      if (this.selectedDate) url += `&date=${this.selectedDate}`;
      const res = await fetch(url);
      const data = await res.json();
      this.pricePerPerson = data.price_per_person ?? 0;
      this.total = data.total ?? 0;
      this.originalPricePerPerson = data.original_price_per_person ?? this.pricePerPerson;
      this.discountApplied = data.discount_applied || null;
      const apiCurrency = String(data.currency || '').toUpperCase();
      if (apiCurrency && apiCurrency !== 'EUR') {
        this.currency = data.currency;
      }
      this.tierLabel = data.tier_applied ? 'Group discount applied' : '';
    } catch (e) {
      this.pricePerPerson = this.basePrice || 0;
      this.total = this.pricePerPerson * this.guests;
      this.originalPricePerPerson = this.pricePerPerson;
      this.discountApplied = null;
    }
  },
}));

Alpine.data('mobileBookingBar', () => ({
  visible: true,
  init() {
    const target = document.getElementById('booking-form');
    if (!target) return;
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => { this.visible = !e.isIntersecting; });
      },
      { threshold: 0.1, rootMargin: '-60px 0px 0px 0px' }
    );
    observer.observe(target);
  },
  scrollToBooking() {
    document.getElementById('booking-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  },
}));

Alpine.data('searchSidebarDate', (initialDate = '') => ({
  fp: null,
  init() {
    this.$nextTick(() => this.initFlatpickr());
  },
  initFlatpickr() {
    if (!window.flatpickr || !this.$refs.dateInput) return;
    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    this.fp = window.flatpickr(this.$refs.dateInput, {
      dateFormat: 'Y-m-d',
      minDate: 'today',
      maxDate: maxDate,
      allowInput: false,
    });
    if (initialDate) this.fp.setDate(initialDate);
  },
}));

Alpine.data('heroSearchForm', (config) => ({
  action: config.action,
  countries: config.countries || [],
  monthOptions: config.monthOptions || [],
  initialCountry: config.initialCountry || '',
  initialDate: config.initialDate || '',
  selectedCountry: config.initialCountry || '',
  selectedDate: config.initialDate || '',
  countryOpen: false,
  monthOpen: false,
  get selectedCountryName() {
    if (!this.selectedCountry) return '';
    const c = this.countries.find(x => x.slug === this.selectedCountry);
    return c ? c.name : '';
  },
  get selectedMonthLabel() {
    if (!this.selectedDate) return '';
    const row = this.monthOptions.find((x) => x.value === this.selectedDate);
    if (row) return row.label;
    const parts = String(this.selectedDate).split('-');
    if (parts.length >= 2) {
      const d = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, 1);
      return d.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    }
    return '';
  },
  init() {
    this.selectedCountry = this.initialCountry;
    this.selectedDate = this.initialDate;
  },
  selectCountry(slug) {
    this.selectedCountry = slug || '';
  },
  selectMonth(value) {
    this.selectedDate = value || '';
  },
  submitForm(e) {
    // Form submits naturally with hidden inputs
  },
}));

function homeSlider(config) {
  const fixedSlideBy = config?.fixedSlideBy;
  return {
    slideBy: fixedSlideBy ?? config?.slideBy ?? 1,
    fixedSlideBy: fixedSlideBy != null,
    init() {
      if (!this.fixedSlideBy) {
        this.$nextTick(() => this.updateSlideBy());
        window.addEventListener('resize', () => this.updateSlideBy());
      }
    },
    updateSlideBy() {
      if (this.fixedSlideBy) return;
      const el = this.$refs.track;
      if (!el) return;
      const cards = el.querySelectorAll('[data-slider-card]');
      if (cards.length === 0) return;
      const cardWidth = cards[0].offsetWidth;
      const container = el.querySelector('[data-slider-gap]');
      const gap = container ? parseInt(container.dataset.sliderGap || '20', 10) : 20;
      const containerWidth = el.parentElement?.offsetWidth ?? el.offsetWidth;
      const visibleCount = Math.floor((containerWidth + gap) / (cardWidth + gap));
      this.slideBy = Math.max(1, visibleCount);
    },
    scrollNext() {
      const el = this.$refs.track;
      if (!el) return;
      const cards = el.querySelectorAll('[data-slider-card]');
      if (cards.length === 0) return;
      const cardWidth = cards[0].offsetWidth;
      const container = el.querySelector('[data-slider-gap]');
      const gap = container ? parseInt(container.dataset.sliderGap || '20', 10) : 20;
      const scrollAmount = (cardWidth + gap) * this.slideBy;
      el.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    },
  };
}
Alpine.data('homeSlider', homeSlider);
window.homeSlider = homeSlider;

Alpine.start();
