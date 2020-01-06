import React, { Component } from 'react';

import { BrowserRouter } from 'react-router-dom';

import Routes from './Routes';
import Services from './Services';

export default class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <Routes/>
                <Services/>
            </BrowserRouter>
        )
    }
}
