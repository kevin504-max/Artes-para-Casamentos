import axios from 'axios'

export const userServices = {
    getAuthUser,
}

const headersAuthorization = {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
}

async function getAuthUser() {
    try {
        const response = (await axios.get('get-auth', {
            headers: headersAuthorization
        })).data;

        response.isAuthenticated = true;

        return response;
    } catch (error) {
        console.log('Error: ', error);
    }
}