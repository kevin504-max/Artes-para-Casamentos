import axios from 'axios'

export const categoryServices = {
    store,
    update,
    updateStatus,
    destroy,
}

const headersAuthorization = {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
    'Content-Type': 'multipart/form-data'
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