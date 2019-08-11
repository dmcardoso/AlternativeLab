import React, { Component } from "react";
import { Link } from "react-router-dom";

class Testando extends Component {
    render() {
        return (
            <div>
                Testando....
                <Link to="/login">loginnnn</Link>
                <Link to="/testssss">testssss</Link>
            </div>
        );
    }
}

export default Testando;
