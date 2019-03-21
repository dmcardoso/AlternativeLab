'use strict'

import React, { Component } from 'react'

class App extends Component {
  render () {
    return (
      <div className="app">
        <div className="search">
          <input type="search" placeholder="Digite o nome do usuário no Github"/>
        </div>

        <div className="user-info">
          <img src="https://avatars0.githubusercontent.com/u/28882783?v=4" alt=""/>
          <h1><a href="https://github.com/dmcardoso">DanielMoreira</a></h1>
        </div>

        <ul className="repos-info">
          <li>- Repositórios: 8</li>
          <li>- Seguidores: 10</li>
          <li>- Seguindo: 10</li>
        </ul>

        <div className="actions">
          <button>Ver repositórios</button>
          <button>Ver favoritos</button>
        </div>

        <div className="repos">
          <h2>Repositórios</h2>
          <ul>
            <li><a href="#">Nome do repositório</a></li>
          </ul>
        </div>

        <div className="starred">
          <h2>Favoritos</h2>
          <ul>
            <li><a href="#">Nome do repositório</a></li>
          </ul>
        </div>

      </div>
    )
  }
}

export default App