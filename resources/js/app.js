import Alpine from 'alpinejs';
import html2canvas from 'html2canvas';

window.Alpine = Alpine;

// State and actions for the quotes page (mood filter, add modal, quote card generator)
Alpine.data('quotesPage', (hasErrors = false) => ({
    open: hasErrors,
    mood: '',
    card: { open: false, text: '', author: '', bg: '#e6dcff', fg: '#3b2a6b', font: 'Georgia, serif' },
        colors: [
    { bg: '#e6dcff', fg: '#3b2a6b' }, // lavender
    { bg: '#f5ecdf', fg: '#3d2c5c' }, // beige
    { bg: '#ffe1d1', fg: '#5a3a2e' }, // peach
    { bg: '#d6f0e6', fg: '#24504a' }, // mint
    { bg: '#f9d9e4', fg: '#5b2c47' }, // rose
],

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
    focus: { open: false, i: 0, items: [], timer: null },

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