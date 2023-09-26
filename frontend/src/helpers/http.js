import axios from "axios";
import axiosData from "@/utils/axiosData";

const http = () => {
    let options = {
        baseURL: axiosData.hostName,
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "Referrer-Policy": "no-referrer-when-downgrade",
            "Access-Control-Allow-Origin": axiosData.hostName + '/',
            "Access-Control-Allow-Methods": "GET, POST, DELETE, OPTIONS"
        }
    }

    if(localStorage.getItem('token')) {
        options.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
    }

    return axios.create(options)
}

export default http