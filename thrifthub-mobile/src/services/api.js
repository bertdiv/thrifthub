import axios from "axios";

const api = axios.create({
  baseURL: "http://192.168.1.108/api/products",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

export default api;