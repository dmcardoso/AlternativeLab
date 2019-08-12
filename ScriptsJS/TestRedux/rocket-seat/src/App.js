import React, { Component } from 'react';
import Sidebar from './components/sidebar/Sidebar';
import Video from './components/video/Video';
import { Provider } from 'react-redux';
import store from './store';

class App extends Component {
    render () {
        return (
            <div className="App">
                <Provider store={store}>
                    <Video/>
                    <Sidebar/>
                </Provider>
            </div>
        );
    }
}

export default App;
