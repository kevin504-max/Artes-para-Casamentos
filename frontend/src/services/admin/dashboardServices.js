import axios from 'axios'

export const dashboardServices = {
    // getDashboardData,
    getCategories,
    getProducts,
    getOrders,
    getUsers,
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

async function getOrders() {
    try {
        const response = (await axios.get('dashboard/get-orders', {
            headers: headersAuthorization,
        })).data.orders;

        return response;
    } catch (error) {
        console.log("Get Orders Error: ", error)
        this.$swal({
            icon: 'error',
            title: 'Oops...',
            showConfirmButton: false,
            timer: 2000,
        })
    }
}

async function getUsers() {
    try {
        const response = (await axios.get('dashboard/get-users', {
            headers: headersAuthorization,
        })).data.users;

        return response;
    } catch (error) {
        console.log("Get Users Error: ", error)
        this.$swal({
            icon: 'error',
            title: 'Oops...',
            showConfirmButton: false,
            timer: 2000,
        })
    }
}