import axios from 'axios'

export const dashboardServices = {
    // getDashboardData,
    getCategories,
    // getProducts,
    // getOrders,
    // getUsers,
}

// const headersAuthorization = headers: {
//     Authorization: `Bearer ${localStorage.getItem('access_token')}`
// }

async function getCategories() {
    try {
        const response = (await axios.get('get-categories', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('access_token')}`
            }
        })).data.patients;

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