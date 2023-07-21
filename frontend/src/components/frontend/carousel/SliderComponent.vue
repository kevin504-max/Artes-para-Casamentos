<template>
    <div>
        <b-carousel
            id="carousel-1"
            :interval="4000"
            controls
            indicators
            fade
            background="#ababab"
            img-width="1920"
            img-height="1080"
            style="text-shadow: 1px 1px 2px #333;"
            @sliding-start="onSlideStart"
            @sliding-end="onSlideEnd"
        >
            <b-carousel-slide img-src="https://picsum.photos/1920/1080/?image=54"></b-carousel-slide>
            <b-carousel-slide img-src="https://picsum.photos/1920/1080/?image=55"></b-carousel-slide>
            <b-carousel-slide img-src="https://picsum.photos/1920/1080/?image=56"></b-carousel-slide>
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