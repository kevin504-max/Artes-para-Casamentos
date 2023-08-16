<template>
    <div class="description">
        <h2>Descrição</h2>
        <p class="attention">
            <span>ATENÇÃO:</span> Todos os nossos produtos são DIGITAIS. NÃO vendemos nenhum produto físico e NÃO fazemos nenhuma impressão ou montagem.
        </p>
        <p>
            - Você irá adquirir um produto 100% digital, entregue via e-mail e com layout exatamente igual ao modelo da foto, 
            personalizado com os seus dados. Sendo assim, poderá APENAS solicitar alterações de dados textuais (iniciais, data, texto...).
        </p>
        <p class="title">
            Como funciona? | Passo-a-Passo:
        </p>
        <ul class="instructions" style="list-style: none;">
            <li>
                <span>1) Formulário:</span> No dia útil seguinte a confirmação de pagamento, será enviado, ao e-mail cadastrado no site, 
                um formulário para o preenchimento dos dados, os quais serão editados na arte adquirida.
            </li>
            <li>
                <span>2) Aprovação:</span> Após o retorno do formulário preenchido, a arte será editada e 
                encaminhada para conferência das informações e aprovação. *Se a arte precisar de algum ajuste, ela retornará a edição.
            </li>
            <li>
                <span>3) Arte Final:</span> Após aprovada, a arte será finalizada e encaminhada pronta para envio virtual.
            </li>
        </ul>
        <p class="title">
            A arte é enviada em qual extensão?
        </p>
        <ul class="instructions">
            <li>
                PDF (arquivo pronto para envio virtual, com links clicáveis). <br>
                <i class="fa fa-arrow-right"></i> É necessário que os links estejam prontos quando efetuar a compra, nós só colocamos o link no convite, não criamos os links.
            </li>
        </ul>
        <p class="title">
            Tamanho original:
        </p>
        <ul class="instructions">
            <li>Tela do celular, próprio para envio virtual.</li>
        </ul>
        <p class="title">
            Prazo de entrega:
        </p>
        <ul class="instructions">
            <li>Indicado no produto - Esse prazo começa a ser contado após o retorno do formulário preenchido.</li>
        </ul>
        <p class="title">
            Demais observações:
        </p>
        <ul class="instructions">
            <li>Tamanho da arte: Não é alterável.</li>
            <li><span>NÃO</span> enviamos artes abertas/editáveis.</li>
            <li>Esse produto é destinado a uso pessoal, <span>NÃO</span> revenda.</li>
            <li><span>NÃO</span> há nenhuma criação nova nesse produto digital, você receberá a arte digital fechada igual ao modelo da foto, personalizada com seus dados.</li>
        </ul>
        <p class="title">Se tiver alguma dúvida, entre em contato conosco, ANTES de efetuar a compra!</p>
        <p class="observations">
            *Imagens Ilustrativas. <br>
            *Comercializamos APENAS artes DIGITAIS. <br>
            *As cores podem sofrer variações de monitor para monitor. <br>
        </p>
    </div>
</template>

<script>
export default {
    
}
</script>

<style lang="scss" scoped>
.description {
    width: 65%;
    margin-top: 30px;
    margin-bottom: 30px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    font-size: 1rem;
    color: #666666;

    h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-align: center;
        width: 100%;        
    }

    .attention {
        font-weight: bold;
        
        span {
            font-weight: 700;
            text-decoration: underline;
            background-color: #ff0;
        }
    }

    p {
        margin: 10px 0;
        text-align: justify;
    }

    .title {
        text-decoration: underline;
        font-weight: bold;
    }

    .instructions {
        margin-top: 10px;
        margin-left: 20px;

        li {
            margin: 5px 0;
            text-align: justify;
            
            span {
                font-weight: bold;
                text-transform: uppercase;
            }
        }
    }
}
</style>