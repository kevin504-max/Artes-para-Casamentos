import axios from 'axios'

export const categoryServices = {
    getCategories,
    getCategoryBySlug,
    store,
    update,
    updateStatus,
    destroy,
}

const headersAuthorization = {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
    'Content-Type': 'multipart/form-data'
}

async function getCategories() {
    try {
        const response = (await axios.get('get-categories')).data.categories;

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

async function getCategoryBySlug (slug) {
    try {
        const response = (await axios.get(`get-category/${slug}`)).data.category;

        return response;
    } catch (error) {
        console.log("Get Category By Slug Error: ", error)
    }
}

async function store (category) {
    try {
        const response = (await axios.post('categories/store', category, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Store Category Error: ", error)
    }
}

async function update (category) {
    try {
        const response = (await axios.post('categories/update', category, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Update Category Error: ", error)
    }
}

async function updateStatus (category) {
    try {
        const response = (await axios.post('categories/status-update', category, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Update Status Category Error: ", error)
    }
}

async function destroy (category) {
    try {
        const response = (await axios.post('categories/destroy', category, {
            headers: headersAuthorization
        })).data;

        return response;
    } catch (error) {
        console.log("Destroy Category Error: ", error)
    }
}