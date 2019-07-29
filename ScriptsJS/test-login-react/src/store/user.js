import axios from "axios";
export const setUser = user => {
    if (user) {
        axios.defaults.headers.common["Authorization"] = `bearer ${user.token}`;
    } else {
        delete axios.defaults.headers.common["Authorization"];
    }
};
