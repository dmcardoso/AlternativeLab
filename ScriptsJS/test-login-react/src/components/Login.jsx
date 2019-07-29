import React, { Component, Fragment } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
class Login extends Component {
    state = {
        user: {
            email: "",
            password: ""
        }
    };

    submitForm = e => {
        e.preventDefault();
        console.log("====================================");
        console.log(e, this.state);
        console.log("====================================");

        axios
            .post("http://localhost:4002/signin", this.state.user)
            .then(res => {
                console.log("==============sigin================");
                console.log(res);
                console.log("====================================");
                localStorage.setItem("_user_test", JSON.stringify(res.data));
            });
    };

    render() {
        console.log("====================================");
        console.log(this.props);
        console.log("====================================");
        return (
            <Fragment>
                <form>
                    <input
                        type="text"
                        value={this.state.user.email}
                        name="email"
                        onChange={e => {
                            const email = e.currentTarget.value;
                            this.setState(() => {
                                const { user } = this.state;
                                user.email = email;
                                return { user };
                            });
                        }}
                    />
                    <input
                        type="text"
                        value={this.state.user.password}
                        name="password"
                        onChange={e => {
                            const password = e.target.value;
                            this.setState(
                                this.setState(() => {
                                    const { user } = this.state;
                                    user.password = password;
                                    return { user };
                                })
                            );
                        }}
                    />
                    <button type="submit" onClick={this.submitForm}>
                        Login
                    </button>
                </form>
                <Link to="/test">testeeeeee</Link>
            </Fragment>
        );
    }
}

export default Login;
