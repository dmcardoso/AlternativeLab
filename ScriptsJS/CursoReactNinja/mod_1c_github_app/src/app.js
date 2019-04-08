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
        ajax().get(this.getGitHubApiUrl(value))
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
                        },
                        repos: [],
                        starred: [],
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
        this.getRepos = this.getRepos.bind(this);
    }

    getGitHubApiUrl (username, type) {
        const internalType = type ? `/${type}` : '';
        const internalUser = username ? `/${username}` : '';
        return `https://api.github.com/users${internalUser}${internalType}`;
    }

    getRepos (type) {
        ajax().get(this.getGitHubApiUrl(this.state.userinfo.login,type))
            .then((result) => {
                this.setState({
                    [type]: result.map((repo) => {
                        return {
                            name: repo.name,
                            link: repo.html_url,
                        };
                    }),
                });
            });
    }

    render () {
        return (
            <AppContent
                searchFunc={this.searchFunc}
                userinfo={this.state.userinfo}
                starred={this.state.starred}
                repos={this.state.repos}
                getRepos={this.getRepos('repos')}
                getStarred={this.getRepos('starred')}
            />
        );
    }
}

export default App;