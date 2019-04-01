'use strict'

import React, { Component } from 'react'
import AppContent from './components/AppContent'

const initialState = {}

class App extends Component {

  constructor (props) {
    super(props)
    this.state = { ...initialState }
  }

  render () {
    return (
      <AppContent/>
    )
  }
}

export default App