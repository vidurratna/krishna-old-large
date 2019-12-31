import React, { Component } from 'react'

import { Switch } from 'react-router-dom';

import { Route } from 'react-router-dom';

import Index from '../Containers/Dashboard';


export default class Routes extends Component {
    render() {
        return (
            <Switch>
                <Route
                component={Index}
                exact
                path="/admin"
                />
                <Route
                component={Index}
                exact
                path="/test/admin"
                />
            </Switch>
        )
    }
}
