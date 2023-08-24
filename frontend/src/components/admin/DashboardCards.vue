<template>
    <div class="custom_card">
        <div class="content top">
            <h3>{{ type }}</h3>
            <p class="percentage"><i class="fa fa-arrow-up"></i> {{ percentage }}</p>
        </div>
        <div class="content footer">
            <i :class="['fa icon', icon]"></i>
            <p class="quantity">{{ quantity }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DashboardCards',

    props: {
        type: String,
        percentage: String,
        icon: String,
        quantity: String,
    }
}
</script>

<style lang="scss" scoped>
.custom_card {
    display: flex;
    flex-direction: column;
    width: 100%;
    background-color: rgba(65, 184, 184, 0.664); 
    padding: 15px;
    border-radius: 7px;
    color: #666666;

    .content {
        display: flex;
        justify-content: space-between;
    }

    .top {
        .percentage {
            color: #79F287;
        }
    }

    .footer {
        .icon {
            font-size: 35px;
        }

        .quantity {
            font-size: 30px;
            margin: 0;
        }
    }
}
</style>