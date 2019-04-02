'use strict'

import React, { Component } from 'react'
import AppContent from './components/AppContent'

const initialState = {
  userinfo: null,
  repos: [],
  starred: [],
}

class App extends Component {

  constructor (props) {
    super(props)
    this.state = { ...initialState }
  }

  render () {
    return (
      <AppContent
        userinfo={this.state.userinfo}
        starred={this.state.starred}
        repos={this.state.repos}
      />
    )
  }
}

export default App