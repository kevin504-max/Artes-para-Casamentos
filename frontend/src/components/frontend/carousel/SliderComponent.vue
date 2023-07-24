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
                :img-src="require('@/assets/carousel/1.jpg')"
                alt="image"
            ></b-carousel-slide>
            <b-carousel-slide
                :img-src="require('@/assets/carousel/2.jpg')"
                alt="image"
            ></b-carousel-slide>
            <b-carousel-slide
                :img-src="require('@/assets/carousel/3.png')"
                alt="image"
            ></b-carousel-slide>
        </b-carousel>
    </div>
</template>

<script>
export default {
    name: "SliderComponent",
    data () {
        return {
            sliding: null,
        };
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