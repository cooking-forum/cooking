let appLike = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            livello: 0,
            variants: [
                {id:1, image:"../immagini/suppli.jpg", name:"Supplì", likes:0, selected: false},
                {id:2, image:"../immagini/Lasagna.jpg", name:"Lasagna", likes:0, selected: false},
                {id:3, image:"../immagini/salmone-in-crosta.jpg", name:"Salmone in crosta", likes:0, selected: false},
                {id:4, image:"../immagini/Zucchine-ripiene.jpg", name:"Zucchine ripiene", likes:0, selected: false},
                {id:5, image:"../immagini/torta-ricotta-e-spinaci.jpg", name:"Torta ricotta e spinaci", likes:0, selected: false}
            ]
        }
    },

    methods: {
        changeStato(index) {
            this.selectedVariant = index;
            if (this.variants[this.selectedVariant].selected == false) {
                this.livello += 1; 
                this.variants[this.selectedVariant].likes++;
                this.variants[this.selectedVariant].selected = true;
            }
            else {
                if (this.livello > 0) {
                    this.livello -= 1; 
                    if (this.variants[this.selectedVariant].likes > 0) { this.variants[this.selectedVariant].likes--; }
                }
                this.variants[this.selectedVariant].selected = false;
            }
        },
        
        getPicPath(ricetta) { return ricetta.image; }
    }
});

appLike.mount('#appLike');

