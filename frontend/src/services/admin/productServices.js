import axios from 'axios'

export const productServices = {
    getProducts,
    store,
}

const headersAuthorization = {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
    'Content-Type': 'multipart/form-data'
}

async function getProducts() {
    try {
        const response = (await axios.get('products/get-products', {
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

async function store (product) {
    try {
        const response = (await axios.post('products/store', product, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Store Product Error: ", error)
    }
}