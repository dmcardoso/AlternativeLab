'use strict'

import React from 'react'
import Search from './Search'
import UserInfo from './UserInfo'
import Actions from './Actions'
import Repositories from './Repositories'

const AppContent = () =>
  <div className="app">
    <Search/>
    <UserInfo/>
    <Actions/>
    <Repositories
      title="Repositórios"
      class="repos"
      repos={
        [
          {
            name: 'Nome do repositório ooo',
            link: '#'
          }
        ]
      }
    />
    <Repositories
      title="Favoritos"
      class="starred"
      repos={
        [
          {
            name: 'Nome do repositório favorito',
            link: '#'
          }
        ]
      }
    />
  </div>

export default AppContent