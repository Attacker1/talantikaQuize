import axios from "axios";

const http = () => {
    let options = {
        baseURL: 'http://31.31.199.42',
        headers: {}
    }

    if(localStorage.getItem('token')) {
        options.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
    }

    return axios.create(options)
}

export default http