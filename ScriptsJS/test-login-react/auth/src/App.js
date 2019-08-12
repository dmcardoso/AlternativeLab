import React from "react";
import axios from "axios";
import Routes from "./Router";
import { BrowserRouter } from "react-router-dom";

class App extends React.Component {
    render() {
        return (
            <BrowserRouter>
                <div className="App">
                    <Routes />
                </div>
            </BrowserRouter>
        );
    }
}

export default App;
