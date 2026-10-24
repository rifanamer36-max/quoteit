import Alpine from 'alpinejs';
import html2canvas from 'html2canvas';
import QRCode from 'qrcode';

window.Alpine = Alpine;

const PROJECT_URL = 'https://github.com/rifanamer36-max/quoteit';

// State and actions for the quotes page (filters, add modal, quote card, calm session)
Alpine.data('quotesPage', (hasErrors = false) => ({
    open: hasErrors,
    mood: '',
    search: '',

    // Quote card generator (runs in the browser)
    card: { open: false, text: '', author: '', bg: '#e6dcff', fg: '#3b2a6b', font: 'Georgia, serif', stamp: true, qr: '' },
    colors: [
        { bg: '#e6dcff', fg: '#3b2a6b' }, // lavender
        { bg: '#f5ecdf', fg: '#3d2c5c' }, // beige
        { bg: '#ffe1d1', fg: '#5a3a2e' }, // peach
        { bg: '#d6f0e6', fg: '#24504a' }, // mint
        { bg: '#f9d9e4', fg: '#5b2c47' }, // rose
    ],

    // Calm session
    focus: { open: false, i: 0, items: [], timer: null },

    async init() {
        // Small QR code for the card stamp, generated in the browser
        try {
            this.card.qr = await QRCode.toDataURL(PROJECT_URL, {
                margin: 0,
                width: 120,
                color: { dark: '#3b2a6b', light: '#00000000' },
            });
        } catch (e) {
            this.card.qr = '';
        }
    },

    openCard(text, author) {
        this.card.text = text;
        this.card.author = author;
        this.card.open = true;
    },

    async downloadCard() {
        const canvas = await html2canvas(this.$refs.cardPreview, { scale: 2, backgroundColor: null });
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'edrak-quote.png';
        link.click();
    },

    startFocus(items) {
        if (!items.length) return;
        this.focus.items = items;
        this.focus.i = Math.floor(Math.random() * items.length);
        this.focus.open = true;
        this.focus.timer = setInterval(() => this.nextFocus(), 8000);
    },

    nextFocus() {
        this.focus.i = (this.focus.i + 1) % this.focus.items.length;
    },

    stopFocus() {
        clearInterval(this.focus.timer);
        this.focus.open = false;
    },
}));

Alpine.start();