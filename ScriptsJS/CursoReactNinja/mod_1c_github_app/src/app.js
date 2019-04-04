'use strict';

import React, { Component } from 'react';
import AppContent from './components/AppContent';
import ajax from '@fdaciuk/ajax';

const initialState = {
    userinfo: null,
    repos: [],
    starred: [],
};

class App extends Component {

    searchFunc (e) {
        const { value } = e.target;
        ajax().get(`https://api.github.com/users/${value}`)
            .then((result) => {
                if (result.name) {
                    this.setState({
                        userinfo: {
                            username: result.name,
                            repos: result.public_repos,
                            followers: result.followers,
                            following: result.following,
                            foto: result.avatar_url,
                            login: result.login,
                        }
                    });
                } else {
                    this.setState({ userinfo: null });
                }
            })
            .catch((res) => {
                this.setState({ userinfo: null });
            });
    };

    constructor (props) {
        super(props);
        this.state = { ...initialState };

        this.searchFunc = this.searchFunc.bind(this);
    }

    render () {
        return (
            <AppContent
                searchFunc={this.searchFunc}
                userinfo={this.state.userinfo}
                starred={this.state.starred}
                repos={this.state.repos}
            />
        );
    }
}

export default App;