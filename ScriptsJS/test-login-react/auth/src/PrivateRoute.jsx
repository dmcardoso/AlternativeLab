import React, { Component } from "react";
import { Route, Redirect } from "react-router-dom";
import axios from "axios";
import { setUser } from "./store/user";

const baseApiUrl = "http://localhost:4002";

const initialState = {
    redirect: false
};
class PrivateRouter extends Component {
    redirect = false;
    redirected = false;
    validateToken = async () => {
        const json = localStorage.getItem("_user_test");
        const userData = JSON.parse(json);
        setUser(userData);

        if (!userData) {
            this.redirect = true;
            this.forceUpdate();
        }

        const res = await axios.post(`${baseApiUrl}/validateToken`, userData);

        if (res.data) {
            setUser(userData);
        } else {
            localStorage.removeItem("_user_test");
            this.redirect = true;
            this.forceUpdate();
        }
    };

    validToken = exp => {
        return new Date(exp * 1000) > new Date();
    };

    async componentDidMount() {
        this.validateToken();
    }

    render() {
        const { props } = this;
        const json = localStorage.getItem("_user_test");

        const user = JSON.parse(json);

        if (!user && props.private) {
            return <Redirect to="login" {...props} />;
        } else {
            if (user && !this.validToken(user.exp)) {
                setUser(null);
                localStorage.removeItem("_user_test");
                this.forceUpdate();
            }
            if (props.private && user && user.admin) {
                return <Route {...props} />;
            } else if (props.private && (!user || (user && !user.admin))) {
                return <Redirect to="login" {...props} />;
            } else {
                return <Route {...props} />;
            }
        }
    }
}

export default PrivateRouter;
