'use strict';

import React from 'react';
import Search from './Search';
import UserInfo from './UserInfo';
import Actions from './Actions';
import Repositories from './Repositories';

const AppContent = ({ userinfo, repos, starred, searchFunc }) =>
    <div className="app">
        <Search searchFunc={searchFunc}/>
        {!!userinfo && <UserInfo userinfo={userinfo}/>}
        {!!userinfo && <Actions/>}

        {!!repos.length &&
        <Repositories
            title="Repositórios"
            class="repos"
            repos={repos}
        />
        }

        {!!starred.length &&
        <Repositories
            title="Favoritos"
            class="starred"
            repos={repos}
        />
        }
    </div>;

AppContent.propTypes = {
    searchFunc: React.PropTypes.func.isRequired,
    userInfo: React.PropTypes.object,
    repos: React.PropTypes.array.isRequired,
    starred: React.PropTypes.array.isRequired,
};

export default AppContent;