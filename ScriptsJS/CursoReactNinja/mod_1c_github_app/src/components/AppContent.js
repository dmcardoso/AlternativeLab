'use strict'

import React from 'react'
import Search from './Search'
import UserInfo from './UserInfo'
import Actions from './Actions'
import Repositories from './Repositories'

const AppContent = ({ userinfo, repos, starred }) =>
  <div className="app">
    <Search/>
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
  </div>

AppContent.propTypes = {
  userInfo: React.propTypes.object.isRequired,
  props: React.propTypes.array.isRequired,
  starred: React.propTypes.array.isRequired,
}

export default AppContent