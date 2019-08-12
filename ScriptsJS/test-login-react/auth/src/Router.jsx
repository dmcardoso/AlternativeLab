import React from "react";
import { Switch, Route } from "react-router-dom";
import Testando from "./components/Testando";
import Login from "./components/Login";
import PrivateRoute from "./PrivateRoute";

const Router = props => {
    return (
        <Switch>
            <PrivateRoute
                path="/testssss"
                component={Testando}
                {...props}
                private
            />
            <PrivateRoute path="/test" component={Testando} {...props} />
            <PrivateRoute path="/test" component={Testando} {...props} />
            <PrivateRoute path="/" component={Login} {...props} />
        </Switch>
    );
};

export default Router;
