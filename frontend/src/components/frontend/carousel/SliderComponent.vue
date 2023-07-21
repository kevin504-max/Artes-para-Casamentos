<template>
    <div>
        <b-carousel
            id="carousel-1"
            :interval="4000"
            controls
            fade
            background="#ababab"
            img-width="1920"
            img-height="1080"
            style="text-shadow: 1px 1px 2px #333;"
            @sliding-start="onSlideStart"
            @sliding-end="onSlideEnd"
        >
            <b-carousel-slide
                v-for="image in featuredImages"
                :key="image"
                :img-src="image"
                alt="image"
            ></b-carousel-slide>
        </b-carousel>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "SliderComponent",
    inject: ['makeSpin'],
    data () {
        return {
            sliding: null,
            featureds: [],
            featuredImages: [],
        };
    },
    async mounted () {
        this.makeSpin.value = true;

        await axios.get('/home').then((response) => {
            this.featureds = response.data.featureds;
        }).catch((error) => {
            console.log('Error Home Page: ', error)
        })
        
        this.featureds.forEach((featured) => {
            axios.get(`/${featured.id}/featuredImage`).then((response) => {
                (response.data.status !== 200) ? this.featuredImages.push('@/assets/default-place.jpeg') : this.featuredImages.push(response.data.image_url);
            }).catch((error) => {
                console.log('Error Slider Image: ', error)
            })
        });

        this.makeSpin.value = false;
    },
    methods: {
        onSlideStart () {
            this.sliding = true;
        },

        onSlideEnd () {
            this.sliding = false;
        },
    }
}
</script>

<style lang="scss" scoped>

</style>