import axios from 'axios'

export const dashboardServices = {
    // getDashboardData,
    getCategories,
    getProducts,
    // getOrders,
    // getUsers,
}

const headersAuthorization = {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
}

async function getCategories() {
    try {
        const response = (await axios.get('dashboard/get-categories', {
            headers: headersAuthorization,
        })).data.categories;

        return response;
    } catch (error) {
        console.log("Get Categories Error: ", error)
        this.$swal({
            icon: 'error',
            title: 'Oops...',
            showConfirmButton: false,
            timer: 2000,
        })
    }
}

async function getProducts() {
    try {
        const response = (await axios.get('dashboard/get-products', {
            headers: headersAuthorization,
        })).data.products;

        return response;
    } catch (error) {
        console.log("Get Products Error: ", error)
        this.$swal({
            icon: 'error',
            title: 'Oops...',
            showConfirmButton: false,
            timer: 2000,
        })
    }
}