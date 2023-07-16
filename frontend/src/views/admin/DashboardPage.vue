<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>    
        <div class="content-right">
            <div class="pages">
                <div class="content-pages">
                    <header class="title-pages">
                        <p>Dashboard</p>
                    </header>
                    <div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <!-- CardComponent -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarComponent from '../../components/admin/SidebarComponent.vue';

export default {
    name: "DashboardPage",

    components: {
        SidebarComponent,
    },

    data () {
        return {

        };
    },

    methods: {

    },
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>
