'use strict';

import React, { Component } from 'react';
import MarkdownEditor from './components/markdown-editor';

import './css/style.css';

class App extends Component{
  constructor (){
    super();
    this.state = {value: ''};
    this.handleChange = this.handleChange.bind(this);
    this.getMarkUp = this.getMarkUp.bind(this);
  }

  handleChange(e){
    this.setState({
      value: e.target.value,
    })
  }

  getMarkUp(){
    return {__html: this.state.value};
  }


  render(){
    return(
      <MarkdownEditor getMarkUp={this.getMarkUp} value={this.state.value} handleChange={this.handleChange}/>
    );
  }
}

export default App;
