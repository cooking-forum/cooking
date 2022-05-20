let appLike = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            selected: 'Radio 1',
            scelto: '',
            livello: 0,
            variants: [
                {id:1, image:"../immagini/suppli.jpg", name:"Supplì", likes:0},
                {id:2, image:"../immagini/Lasagna.jpg", name:"Lasagna", likes:0},
                {id:3, image:"../immagini/salmone-in-crosta.jpg", name:"Salmone in crosta", likes:0},
                {id:4, image:"../immagini/Zucchine-ripiene.jpg", name:"Zucchine ripiene", likes:0},
                {id:5, image:"../immagini/torta-ricotta-e-spinaci.jpg", name:"Torta ricotta e spinaci", likes:0}
            ],
            buttonsArray: [
                {nameButton:"likeB", status:"enabled"},
                {nameButton:"dislikeB", status:"enabled"}
            ],
            
            options: [
                {text: 'Radio 1', value: 'radio1'},
                {text: 'Radio 2', value: 'radio2'}
            ]
        }
    },

    methods: {
        changeStato(index) {


        },

        incrementLivello(index) { 
            this.livello += 1; 
            this.selectedVariant = index;
            this.variants[this.selectedVariant].likes++;
        },

        decrementLivello(index) { 
            if (this.livello > 0) {
                this.livello -= 1; 
                this.selectedVariant = index;
                if (this.variants[this.selectedVariant].likes > 0) { this.variants[this.selectedVariant].likes--; }
            }
        },
        //getPicPath(index) { return this.variants[this.portion+index].image; }
        getPicPath(ricetta) { return ricetta.image; },

        contaRicette() { return variants.length; }

    },

    computed: {
        addLike() { return this.variants[this.selectedVariant].likes; },
        removeLike() { return this.variants[this.selectedVariant].likes; }
    }
});

appLike.mount('#appLike');

