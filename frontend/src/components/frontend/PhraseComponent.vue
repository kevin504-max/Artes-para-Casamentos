<template>
    <div class="phrase">
        <p>nossas coleções</p>
        <h2>Artes Prontas</h2>
        <p>
            Nossas coleções de artes prontas são a partir de um estudo cuidadoso para englobar
            os principais conceitos, as tendências do mercado e as cores mais desejadas. E, assim,
            conseguirmos possibilitar: design de qualidade, rapidez na entrega e valores acessíveis.
        </p>
    </div>
</template>

<script>
export default {
    name: "PhraseComponent",
}
</script>

<style lang="scss" scoped>
.phrase {
    width: 100vw;
    height: 80%;
    margin-top: 10vh;
    padding: 0 20%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background-color: #e9e9e9;
    color: #666666;
    font-size: 1.3rem;

    h2 {
        text-transform: uppercase;
    }
}
</style>