import axios from 'axios'

export const categoryServices = {
    store,
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
        this.$swal({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo deu errado! Tente novamente.',
            showConfirmButton: false,
            timer: 2000,
        })
    }
}