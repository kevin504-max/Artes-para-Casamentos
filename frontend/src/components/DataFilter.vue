<template>
    <div class="search-input">
        <i class="fa fa-search search-icon"></i>
        <input 
        type="text"
        class="form-control"
        v-model="searchTerm"
        :placeholder="placeholder"
        @input="handleSearch()"
        >
    </div>
</template>

<script>
export default {
    name: 'DataFilter',
    props: {
        placeholder: {
            type: String,
            default: "Buscar...",
        },
        data: {
            type: Array,
            default: () => [],
        },
    },
    data () {
        return {
            searchTerm: '',
        };
    },
    methods: {
        handleSearch() {
            this.$emit('onHandleSearch', this.searchTerm);
        }
    }
}
</script>

<style lang="scss" scoped>
.search-input {
    width: 100%;
    height: 50px;
    display: flex;
    justify-content: start;
    align-items: start;
    margin: 20px auto;

    .search-icon {
        width: 8%;
        height: 70%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #666666;
        margin-top: 5px;
    }

    input {
        width: 40%;
        height: 100%;
        border: 1px solid #666666;
        padding: 0 10px;
        outline: none;
    }
}
</style>