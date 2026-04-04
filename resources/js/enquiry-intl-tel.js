/**
 * Tour enquiry phone: intl-tel-input (flags + dial codes + libphonenumber utils).
 * @see https://github.com/jackocnr/intl-tel-input
 */
import intlTelInput from 'intl-tel-input/intlTelInputWithUtils';
import 'intl-tel-input/build/css/intlTelInput.css';

function initEnquiryIntlTel() {
    const input = document.querySelector('#enquiry-phone-input');
    const form = document.querySelector('#tour-enquiry-form');
    if (!input || !form) {
        return;
    }

    const initialCountry = (input.dataset.initialCountry || 'gb').toLowerCase();

    const iti = intlTelInput(input, {
        initialCountry,
        nationalMode: true,
        strictMode: true,
        formatOnDisplay: true,
        containerClass: 'tour-enquiry-iti enquiry-intl-wrap',
        showFlags: true,
        separateDialCode: true,
    });

    const raw = (input.value || '').trim();
    if (raw.startsWith('+')) {
        try {
            iti.setNumber(raw);
        } catch {
            /* ignore invalid old() value */
        }
    }

    form.addEventListener('submit', () => {
        const num = typeof iti.getNumber === 'function' ? iti.getNumber() : '';
        input.value = num || '';
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEnquiryIntlTel);
} else {
    initEnquiryIntlTel();
}
