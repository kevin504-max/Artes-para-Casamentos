import axios from 'axios'

export const productServices = {
    getProducts,
    getProductsByCategory,
    getProductsBySlug,
    store,
    update,
    updateStatus,
    destroy,
}

const headersAuthorization = {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
    'Content-Type': 'multipart/form-data'
}

async function getProducts() {
    try {
        const response = (await axios.get('get-products', {
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

async function getProductsByCategory(category_slug) {
    try {
        const response = (await axios.get(`${category_slug}/products`)).data.products;

        return response;
    } catch (error) {
        console.log("Get Products By Category Error: ", error)
    }
}

async function getProductsBySlug(slug) {
    try {
        const response = (await axios.get(`get-product/${slug}`)).data.product;

        return response;
    } catch (error) {
        console.log("Get Products By Slug Error: ", error)
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

async function update (product) {
    try {
        const response = (await axios.post('products/update', product, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Update Product Error: ", error)
    }
}

async function updateStatus (product) {
    try {
        const response = (await axios.post('products/status-update', product, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Update Status Product Error: ", error)
    }
}

async function destroy (product) {
    try {
        const response = (await axios.post('products/destroy', product, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Destroy Product Error: ", error)
    }
}