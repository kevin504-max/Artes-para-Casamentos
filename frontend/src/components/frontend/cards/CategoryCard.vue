<template>
    <div class="card ml-5">
        <img :src="category.image || '@/assets/default-place.jpeg'" alt="image" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title">{{ category.name }}</h5>
            <p class="card-text text-truncate">{{ category.description }}</p>
            <p class="card-text">{{ (category.status == 1) ? "Ativada" : "Desativada" }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CategoryCard',
    props: {
        category: Object,
    }
}
</script>

<style lang="scss" src="../../style.scss" scoped></style>