import axios from "axios";
import axiosData from "@/utils/axiosData";

const http = () => {
    let options = {
        baseURL: 'http://31.31.199.42',
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "Referrer-Policy": "no-referrer-when-downgrade",
            "Access-Control-Allow-Origin": 'http://31.31.199.42/',
            "Access-Control-Allow-Methods": "GET, POST, DELETE, OPTIONS"
        }
    }

    if(localStorage.getItem('token')) {
        options.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
    }

    return axios.create(options)
}

export default http