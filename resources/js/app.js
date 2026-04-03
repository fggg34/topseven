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
